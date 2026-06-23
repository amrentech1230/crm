<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class Userseeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'role_id' => 1,
                'name' => 'Master Admin',
                'email' => 'master@cargoconvoy.co',
                'email_verified_at' => Carbon::now(),
                'password' => bcrypt('master@cargoconvoy.co'),
                'remember_token' => Str::random(10),
                'address' => '123 Main St, Springfield, IL',
                'department' => 1,
                'office' => 1,
                'manager' => 1,
                'team_lead' => 1,
                'emergency_contact' => '555-1234',
                'emp_code' => 'EMP001',
                'bio' => 'A dedicated software developer.',
                'profile_picture' => 'https://themesdesign.in/upcube/layouts/assets/images/users/avatar-1.jpg',
                'status' => 'active',
            ],
            [
                'role_id' => 2,
                'name' => 'Superadmin',
                'email' => 'superadmin@cargoconvoy.co',
                'email_verified_at' => Carbon::now(),
                'password' => bcrypt('superadmin@cargoconvoy.co'),
                'remember_token' => Str::random(10),
                'address' => '456 Oak Rd, Springfield, IL',
                'department' => 1,
                'office' => 1,
                'manager' => 1,
                'team_lead' => 1,
                'emergency_contact' => '555-5678',
                'emp_code' => 'EMP002',
                'bio' => 'A creative graphic designer.',
                'profile_picture' => 'https://themesdesign.in/upcube/layouts/assets/images/users/avatar-1.jpg',
                'status' => 'active',
            ]

        ]);

        DB::table('departments')->insert([
            [
                'department_name' => 'Admin',
                'status' => 'active',
            ],
            [
                'department_name' => 'Account',
                'status' => 'active',
            ],
            [
                'department_name' => 'Broker',
                'status' => 'active',
            ]
        ]);

        DB::table('offices')->insert([
            [
                'office_name' => 'CCI',
                'department_id' => 1,
                'status' => 'active',
            ],
        ]);

         DB::table('roles')->insert([
            ['id' => 1, 'name' => 'Master admin', 'department_id' => 1, 'type' => 1, 'parent_role' => null, 'created_at' => '2025-05-05 08:41:21', 'updated_at' => '2025-05-05 08:41:21'],
            ['id' => 2, 'name' => 'Super Admin', 'department_id' => 1, 'type' => 1, 'parent_role' => 1, 'created_at' => '2025-05-05 08:42:00', 'updated_at' => '2025-05-05 08:42:00'],
            ['id' => 3, 'name' => 'Admin', 'department_id' => 1, 'type' => 1, 'parent_role' => 2, 'created_at' => '2025-05-05 08:42:18', 'updated_at' => '2025-05-05 08:42:18'],
            ['id' => 4, 'name' => 'AP Manager', 'department_id' => 2, 'type' => 2, 'parent_role' => 3, 'created_at' => '2025-05-05 08:42:45', 'updated_at' => '2025-05-05 08:42:45'],
            ['id' => 5, 'name' => 'AP Team Leader', 'department_id' => 2, 'type' => 3, 'parent_role' => 4, 'created_at' => '2025-05-05 08:43:11', 'updated_at' => '2025-05-05 08:43:11'],
            ['id' => 6, 'name' => 'AP User', 'department_id' => 2, 'type' => 4, 'parent_role' => 5, 'created_at' => '2025-05-05 08:43:49', 'updated_at' => '2025-05-05 08:43:49'],
            ['id' => 7, 'name' => 'AR Manager', 'department_id' => 2, 'type' => 2, 'parent_role' => 3, 'created_at' => '2025-05-05 08:46:50', 'updated_at' => '2025-05-05 08:46:50'],
            ['id' => 8, 'name' => 'AR Team Leader', 'department_id' => 2, 'type' => 3, 'parent_role' => 7, 'created_at' => '2025-05-05 08:47:19', 'updated_at' => '2025-05-05 08:47:19'],
            ['id' => 9, 'name' => 'AR User', 'department_id' => 2, 'type' => 4, 'parent_role' => 8, 'created_at' => '2025-05-05 08:47:51', 'updated_at' => '2025-05-05 08:47:51'],
            ['id' => 10, 'name' => 'Compliance Manager', 'department_id' => 2, 'type' => 2, 'parent_role' => 3, 'created_at' => '2025-05-05 08:49:36', 'updated_at' => '2025-05-05 08:49:36'],
            ['id' => 11, 'name' => 'Compliance Team Leader', 'department_id' => 2, 'type' => 3, 'parent_role' => 10, 'created_at' => '2025-05-05 08:49:55', 'updated_at' => '2025-05-05 08:49:55'],
            ['id' => 12, 'name' => 'Compliance user', 'department_id' => 2, 'type' => 4, 'parent_role' => 11, 'created_at' => '2025-05-05 08:50:19', 'updated_at' => '2025-05-05 08:50:19'],
            ['id' => 13, 'name' => 'MIS Manager', 'department_id' => 2, 'type' => 2, 'parent_role' => 3, 'created_at' => '2025-05-05 09:17:46', 'updated_at' => '2025-05-05 09:17:46'],
            ['id' => 14, 'name' => 'MIS Team Leader', 'department_id' => 2, 'type' => 3, 'parent_role' => 13, 'created_at' => '2025-05-05 09:18:28', 'updated_at' => '2025-05-05 09:18:28'],
            ['id' => 15, 'name' => 'MIS User', 'department_id' => 2, 'type' => 4, 'parent_role' => 14, 'created_at' => '2025-05-05 09:19:10', 'updated_at' => '2025-05-05 09:19:10'],
            ['id' => 16, 'name' => 'Credit Manager', 'department_id' => 2, 'type' => 2, 'parent_role' => 3, 'created_at' => '2025-05-05 09:19:50', 'updated_at' => '2025-05-05 09:19:50'],
            ['id' => 17, 'name' => 'Credit Team Leader', 'department_id' => 2, 'type' => 3, 'parent_role' => 16, 'created_at' => '2025-05-05 09:20:11', 'updated_at' => '2025-05-05 09:20:11'],
            ['id' => 18, 'name' => 'Credit User', 'department_id' => 2, 'type' => 4, 'parent_role' => 17, 'created_at' => '2025-05-05 09:23:54', 'updated_at' => '2025-05-05 09:23:54'],
            ['id' => 19, 'name' => 'Agent Manager', 'department_id' => 3, 'type' => 2, 'parent_role' => 3, 'created_at' => '2025-05-05 09:25:29', 'updated_at' => '2025-05-05 09:25:29'],
            ['id' => 20, 'name' => 'Agent Team Leader', 'department_id' => 3, 'type' => 3, 'parent_role' => 19, 'created_at' => '2025-05-05 09:25:59', 'updated_at' => '2025-05-05 09:25:59'],
            ['id' => 21, 'name' => 'Agent User', 'department_id' => 3, 'type' => 4, 'parent_role' => 20, 'created_at' => '2025-05-05 09:26:31', 'updated_at' => '2025-05-05 09:26:31'],
        ]);

         DB::table('permissions')->insert([
            ['id' => 1, 'name' => 'accounting', 'department_id' => 2, 'created_at' => '2025-04-23 08:08:59', 'updated_at' => '2025-04-23 08:08:59'],
            ['id' => 2, 'name' => 'Home', 'department_id' => 1, 'created_at' => '2025-04-29 07:11:10', 'updated_at' => '2025-04-29 07:11:10'],
            ['id' => 3, 'name' => 'admin', 'department_id' => 1, 'created_at' => '2025-04-29 07:11:22', 'updated_at' => '2025-04-29 07:11:22'],
            ['id' => 4, 'name' => 'user', 'department_id' => 1, 'created_at' => '2025-04-29 07:11:29', 'updated_at' => '2025-04-29 07:11:29'],
            ['id' => 5, 'name' => 'Roles', 'department_id' => 1, 'created_at' => '2025-04-29 07:11:38', 'updated_at' => '2025-04-29 07:11:38'],
            ['id' => 6, 'name' => 'permission', 'department_id' => 1, 'created_at' => '2025-04-29 07:11:58', 'updated_at' => '2025-04-29 07:11:58'],
            ['id' => 7, 'name' => 'All Activity Logs', 'department_id' => 1, 'created_at' => '2025-04-29 07:12:14', 'updated_at' => '2025-04-29 07:12:14'],
            ['id' => 8, 'name' => 'Add new user', 'department_id' => 1, 'created_at' => '2025-04-29 07:13:41', 'updated_at' => '2025-04-29 07:13:41'],
            ['id' => 9, 'name' => 'Department', 'department_id' => 1, 'created_at' => '2025-04-29 07:46:01', 'updated_at' => '2025-04-29 07:46:01'],
            ['id' => 10, 'name' => 'Office', 'department_id' => 1, 'created_at' => '2025-04-29 07:46:12', 'updated_at' => '2025-04-29 07:46:12'],
            ['id' => 11, 'name' => 'Manager', 'department_id' => 1, 'created_at' => '2025-04-29 07:46:24', 'updated_at' => '2025-04-29 07:46:24'],
            ['id' => 12, 'name' => 'Team leader', 'department_id' => 1, 'created_at' => '2025-04-29 07:46:33', 'updated_at' => '2025-04-29 07:46:33'],
            ['id' => 13, 'name' => 'Status Type', 'department_id' => 1, 'created_at' => '2025-04-29 07:46:43', 'updated_at' => '2025-04-29 07:46:43'],
            ['id' => 14, 'name' => 'Shipment Type', 'department_id' => 1, 'created_at' => '2025-04-29 07:46:58', 'updated_at' => '2025-04-29 07:46:58'],
            ['id' => 15, 'name' => 'Broker users list', 'department_id' => 1, 'created_at' => '2025-04-29 07:47:13', 'updated_at' => '2025-04-29 07:47:13'],
            ['id' => 16, 'name' => 'Account users list', 'department_id' => 1, 'created_at' => '2025-04-29 07:47:24', 'updated_at' => '2025-04-29 07:47:24'],
            ['id' => 17, 'name' => 'Admin users list', 'department_id' => 1, 'created_at' => '2025-04-29 07:48:37', 'updated_at' => '2025-04-29 07:48:37'],
            ['id' => 18, 'name' => 'Account Manager', 'department_id' => 2, 'created_at' => '2025-04-29 07:50:00', 'updated_at' => '2025-04-29 07:50:00'],
            ['id' => 19, 'name' => 'Reporting', 'department_id' => 2, 'created_at' => '2025-04-29 07:50:13', 'updated_at' => '2025-04-29 07:50:13'],
            ['id' => 20, 'name' => 'Vendor System', 'department_id' => 2, 'created_at' => '2025-04-29 07:50:24', 'updated_at' => '2025-04-29 07:50:24'],
            ['id' => 21, 'name' => 'Compliance', 'department_id' => 2, 'created_at' => '2025-04-29 07:50:43', 'updated_at' => '2025-04-29 07:50:43'],
            ['id' => 22, 'name' => 'Customer', 'department_id' => 3, 'created_at' => '2025-04-29 07:51:11', 'updated_at' => '2025-04-29 07:51:11'],
            ['id' => 23, 'name' => 'Carrier', 'department_id' => 2, 'created_at' => '2025-04-29 07:51:19', 'updated_at' => '2025-04-29 07:51:19'],
            ['id' => 24, 'name' => 'Shipper', 'department_id' => 3, 'created_at' => '2025-04-29 07:51:27', 'updated_at' => '2025-04-29 07:51:27'],
            ['id' => 25, 'name' => 'Consignee', 'department_id' => 3, 'created_at' => '2025-04-29 07:51:40', 'updated_at' => '2025-04-29 07:51:40'],
            ['id' => 26, 'name' => 'Load Creation', 'department_id' => 3, 'created_at' => '2025-04-29 07:51:49', 'updated_at' => '2025-04-29 07:51:49'],
        ]);

        
    }
}
