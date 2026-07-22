# Deployment Pipeline

Automated CI/CD for this Laravel app using **GitHub Actions + SSH** to a
Hostinger KVM VPS.

## Flow

```
 Pull Request  ──►  CI (ci.yml)                 install deps, Pint, tests
      │
      ▼
 merge to devN ──►  Deploy to Staging           auto, no approval
      │             (deploy-staging.yml)
      ▼
 merge to main ──►  Deploy to Production         manual approval required
                    (deploy-production.yml)
```

- **`devN`** → **Staging** — https://ccicrm.in (auto-deploy on merge, for team testing).
- **`main`** → **Production** — https://crmcargoconvoy.co (deploys after a manual
  approval in GitHub, for added safety).

Both environments live on the **same VPS in different directories**. Queue
workers are managed by **Supervisor** and reload new code via
`php artisan queue:restart`.

Each deploy: `git reset --hard` to the branch → `composer install --no-dev` →
maintenance mode → `migrate --force` → `optimize:clear` + `config:cache` +
`event:cache` + `view:cache` → `queue:restart` → back online. If any step
fails, the app is automatically brought back out of maintenance mode.

> **`route:cache` is intentionally skipped** — `routes/web.php` currently has
> ~16 duplicate route names, which make Laravel's route caching fail. The app
> runs fine without it (routes resolve dynamically). Once the duplicate names
> are cleaned up, replace the three `*:cache` calls in the deploy workflows with
> a single `php artisan optimize`. See "Known follow-ups" below.

---

## One-time GitHub setup

### 1. Repository secrets

`Settings → Secrets and variables → Actions → Secrets` (shared by both
environments, since it's one VPS):

| Secret            | Value                                               |
|-------------------|-----------------------------------------------------|
| `SSH_HOST`        | VPS IP address or hostname                           |
| `SSH_USER`        | Deploy user (e.g. `deployer`)                        |
| `SSH_PORT`        | SSH port (usually `22`)                              |
| `SSH_PRIVATE_KEY` | The **private** key for the deploy user (see below)  |

### 2. Environments and their variables

Create two environments under `Settings → Environments`: **`staging`** and
**`production`**. For each, add these **variables** (not secrets):

| Variable       | Staging value                  | Production value                  | Required |
|----------------|--------------------------------|-----------------------------------|----------|
| `DEPLOY_PATH`  | `/var/www/crm-staging`         | `/var/www/crm-production`         | ✅ yes   |
| `DEPLOY_URL`   | `https://ccicrm.in`            | `https://crmcargoconvoy.co`      | optional |
| `PHP_BIN`      | `php` (or `php8.2`)            | `php` (or `php8.2`)              | optional |
| `COMPOSER_BIN` | `composer`                     | `composer`                        | optional |

`PHP_BIN` / `COMPOSER_BIN` only need setting if `php`/`composer` aren't on the
deploy user's `PATH` (common on shared Hostinger setups — use the full path,
e.g. `/opt/alt/php82/usr/bin/php`).

### 3. Require manual approval for Production

In `Settings → Environments → production`:

- Enable **Required reviewers** and add yourself / the release owners.
- (Optional) Enable **"Allow administrators to bypass"** off for stricter control.

Now every push to `main` will pause the production deploy until a reviewer
clicks **Approve** in the Actions run.

### 4. (Recommended) Branch protection

`Settings → Rules / Branches` — protect `devN` and `main`:

- Require a pull request before merging.
- Require the **`CI / Build & Test`** check to pass.

This ensures nothing reaches a deploy branch without passing CI.

---

## SSH key setup

Generate a dedicated deploy key (do **not** reuse a personal key):

```bash
ssh-keygen -t ed25519 -C "github-actions-deploy" -f deploy_key
```

- Add the **public** key (`deploy_key.pub`) to the VPS deploy user:
  ```bash
  cat deploy_key.pub >> ~/.ssh/authorized_keys
  ```
- Paste the **private** key (`deploy_key`, the whole file including the
  `-----BEGIN...-----` / `-----END...-----` lines) into the `SSH_PRIVATE_KEY`
  GitHub secret.
- Delete the local key files afterwards.

The GitHub repo must also be reachable from the server for `git fetch`. Easiest
option: add the same public key (or a deploy key) to the repo under
`Settings → Deploy keys`, or use HTTPS with a token in the remote URL.

---

## One-time server setup (per environment directory)

Only needed once per environment; deploys assume the checkout already exists.

```bash
# As the deploy user
cd /var/www
git clone <REPO_URL> crm-staging      # and crm-production
cd crm-staging

cp .env.example .env
# Edit .env: APP_ENV=staging|production, APP_DEBUG=false, APP_KEY (next line),
# real DB credentials, mail, etc.
php artisan key:generate

composer install --no-interaction --optimize-autoloader --no-dev
php artisan storage:link
php artisan migrate --force

# Writable dirs for the web server user
sudo chown -R $USER:www-data storage bootstrap/cache
chmod -R ug+rwx storage bootstrap/cache
```

Point the web server (nginx/apache) document root at
`/var/www/crm-<env>/public`.

> `.env` is gitignored, so `git reset --hard` during deploys never touches it.

### Supervisor (queue workers)

Create `/etc/supervisor/conf.d/crm-staging-worker.conf` (one per environment):

```ini
[program:crm-staging-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/crm-staging/artisan queue:work --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
user=www-data
numprocs=1
redirect_stderr=true
stdout_logfile=/var/www/crm-staging/storage/logs/worker.log
stopwaitsecs=3600
```

```bash
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start crm-staging-worker:*
```

The deploy's `php artisan queue:restart` signals these workers to gracefully
finish their current job and restart on the new code — no Supervisor reload
needed on each deploy.

---

## Testing a deploy

- **Staging:** merge a PR into `devN` (or run *Deploy to Staging* manually via
  `Actions → Deploy to Staging → Run workflow`).
- **Production:** merge `devN` into `main`, then approve the paused run under
  `Actions → Deploy to Production`.

---

## Troubleshooting

| Symptom                                   | Fix                                                                 |
|-------------------------------------------|--------------------------------------------------------------------|
| `php: command not found`                  | Set `PHP_BIN` variable to the full PHP path.                        |
| `composer: command not found`             | Set `COMPOSER_BIN` to the full path (or install composer globally). |
| `Permission denied (publickey)`           | Public key not in server `~/.ssh/authorized_keys`, or wrong user.  |
| `fatal: could not read from remote`       | Server can't reach GitHub — add a deploy key / token remote.       |
| Migrations fail, app stuck in maintenance | The trap runs `artisan up` automatically; check the Actions log and re-run once fixed. |
| Composer OOM                              | Add `COMPOSER_MEMORY_LIMIT=-1` as an environment variable.          |

---

## Known follow-ups (surfaced during setup)

These are pre-existing issues in the app, not caused by the pipeline. The
pipeline works around them; clean them up when convenient:

1. **Duplicate route names in `routes/web.php`** (~16, some 3×) — break
   `route:cache`. Deduplicate them, then re-enable `php artisan optimize` in the
   deploy workflows. Confirm no `route('<name>')` / `redirect()->route()` calls
   break when a name is removed.
2. **Migration history drift** — the server DB was seeded from a SQL dump, so
   some tables exist without a matching row in the `migrations` table
   (e.g. `logs`). This makes `migrate --force` try to re-create existing tables
   and fail. Reconcile with `php artisan migrate:status`, then mark
   already-applied migrations as run (insert their filename into the
   `migrations` table) so future `migrate --force` runs are clean.
3. **Server-only files not in git** — the site had files that were never
   committed (`app/Models/DndList.php`, `app/Models/Newsletter.php`, some blade
   views) plus junk/backups (`app-old/`, `resources--old/`, `routes--old/`,
   `bigdump.php`, `*.sql`). Decide per file: commit the real ones to the repo,
   delete the junk. Note: `*.sql` DB dumps should not sit on the server.

## Future extensions (not yet enabled)

- Make Pint + tests **blocking** in `ci.yml` (remove `continue-on-error`) once
  the code is formatted and a real test suite exists.
- Automated rollback (`git reset --hard` to the previous commit SHA).
- Zero-downtime / atomic releases (release directories + symlink swap, e.g.
  Deployer or Envoyer).
