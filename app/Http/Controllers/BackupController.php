<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Response;

class BackupController extends Controller
{
    public function backup()
    {
        $filename = 'backup_' . date('Y_m_d_His') . '.sql';
      $folderdate = date('Y_m_d');
      $folderPath = storage_path("app/backup/{$folderdate}");
      $path = "{$folderPath}/{$filename}";

      // Ensure the backup folder exists
      if (!file_exists($folderPath)) {
          mkdir($folderPath, 0755, true);
      }

      // Database credentials from .env
      $dbHost = escapeshellarg(env('DB_HOST'));
      $dbUser = escapeshellarg(env('DB_USERNAME'));
      $dbPass = env('DB_PASSWORD'); // handle this separately
      $dbName = escapeshellarg(env('DB_DATABASE'));

      // Use process piping to safely insert password
      $command = "mysqldump -h {$dbHost} -u {$dbUser} --password=" . escapeshellarg($dbPass) . " {$dbName} > " . escapeshellarg($path);

      $output = null;
      $result = null;
      exec($command, $output, $result);

      if ($result === 0) {
          return response()->json([
              'success' => true,
              'message' => "Backup saved to: {$filename}"
          ]);
      } else {
          return response()->json([
              'success' => false,
              'message' => "Backup failed",
              'code' => $result
          ], 500);
      }
    }
}
