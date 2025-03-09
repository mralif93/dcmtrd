<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DefaultUsersSeeder extends Seeder
{
    public function run()
    {
        // First insert permissions
        $permissions = [
            [
                'name' => 'DCMTRD',
                'short_name' => 'DCMTRD',
                'full_name' => 'Debt Capital Market Trading',
                'description' => 'Access to debt capital market trading features',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'REITS',
                'short_name' => 'REITS',
                'full_name' => 'Real Estate Investment Trusts',
                'description' => 'Access to real estate investment trusts features',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'LEGAL',
                'short_name' => 'LEGAL',
                'full_name' => 'Legal Department',
                'description' => 'Access to legal department features',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'COMPLIANCE',
                'short_name' => 'COMPLIANCE',
                'full_name' => 'Compliance Department',
                'description' => 'Access to compliance features',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('permissions')->insert($permissions);

        // Get the permission IDs
        $dcmtrdPermissionId = DB::table('permissions')->where('name', 'DCMTRD')->value('id');
        $reitsPermissionId = DB::table('permissions')->where('name', 'REITS')->value('id');
        $legalPermissionId = DB::table('permissions')->where('name', 'LEGAL')->value('id');
        $compliancePermissionId = DB::table('permissions')->where('name', 'COMPLIANCE')->value('id');

        // Sample data for users
        $usersData = [
            [
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'role' => 'admin',
                'job_title' => 'Executive',
                'department' => 'Administration',
                'office_location' => 'Headquarters',
                'email_verified_at' => now(),
                'password' => bcrypt('P@ssw0rd123'), // Use bcrypt for password hashing
                'two_factor_code' => null,
                'two_factor_expires_at' => null,
                'two_factor_verified' => false,
                'two_factor_enabled' => false,
                'remember_token' => null,
                'last_login_at' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'DCMTRD User A',
                'email' => 'dcmtrd1@example.com',
                'role' => 'user',
                'job_title' => 'Executive',
                'department' => 'Debt Capital Markets',
                'office_location' => 'Trading Floor',
                'email_verified_at' => now(),
                'password' => bcrypt('P@ssw0rd123'),
                'two_factor_code' => null,
                'two_factor_expires_at' => null,
                'two_factor_verified' => false,
                'two_factor_enabled' => false,
                'remember_token' => null,
                'last_login_at' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'DCMTRD User B',
                'email' => 'dcmtrd2@example.com',
                'role' => 'user',
                'job_title' => 'Executive',
                'department' => 'Debt Capital Markets',
                'office_location' => 'Trading Floor',
                'email_verified_at' => now(),
                'password' => bcrypt('P@ssw0rd123'),
                'two_factor_code' => null,
                'two_factor_expires_at' => null,
                'two_factor_verified' => false,
                'two_factor_enabled' => false,
                'remember_token' => null,
                'last_login_at' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'REITS User A',
                'email' => 'reits1@example.com',
                'role' => 'user',
                'job_title' => 'Executive',
                'department' => 'Real Estate',
                'office_location' => 'East Wing',
                'email_verified_at' => now(),
                'password' => bcrypt('P@ssw0rd123'),
                'two_factor_code' => null,
                'two_factor_expires_at' => null,
                'two_factor_verified' => false,
                'two_factor_enabled' => false,
                'remember_token' => null,
                'last_login_at' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'REITS User B',
                'email' => 'reits2@example.com',
                'role' => 'user',
                'job_title' => 'Executive',
                'department' => 'Real Estate',
                'office_location' => 'East Wing',
                'email_verified_at' => now(),
                'password' => bcrypt('P@ssw0rd123'),
                'two_factor_code' => null,
                'two_factor_expires_at' => null,
                'two_factor_verified' => false,
                'two_factor_enabled' => false,
                'remember_token' => null,
                'last_login_at' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Manager',
                'email' => 'manager@example.com',
                'role' => 'user',
                'job_title' => 'Manager',
                'department' => 'Executive',
                'office_location' => 'Headquarters',
                'email_verified_at' => now(),
                'password' => bcrypt('P@ssw0rd123'),
                'two_factor_code' => null,
                'two_factor_expires_at' => null,
                'two_factor_verified' => false,
                'two_factor_enabled' => false,
                'remember_token' => null,
                'last_login_at' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Regular User',
                'email' => 'user@example.com',
                'role' => 'user',
                'job_title' => 'Executive',
                'department' => 'Operations',
                'office_location' => 'Headquarters',
                'email_verified_at' => now(),
                'password' => bcrypt('P@ssw0rd123'),
                'two_factor_code' => null,
                'two_factor_expires_at' => null,
                'two_factor_verified' => false,
                'two_factor_enabled' => false,
                'remember_token' => null,
                'last_login_at' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Compliance Officer',
                'email' => 'compliance@example.com',
                'role' => 'compliance',
                'job_title' => 'Executive',
                'department' => 'Compliance',
                'office_location' => 'Headquarters',
                'email_verified_at' => now(),
                'password' => bcrypt('P@ssw0rd123'),
                'two_factor_code' => null,
                'two_factor_expires_at' => null,
                'two_factor_verified' => false,
                'two_factor_enabled' => false,
                'remember_token' => null,
                'last_login_at' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Legal Advisor',
                'email' => 'legal@example.com',
                'role' => 'legal',
                'job_title' => 'Executive',
                'department' => 'Legal',
                'office_location' => 'Headquarters',
                'email_verified_at' => now(),
                'password' => bcrypt('P@ssw0rd123'),
                'two_factor_code' => null,
                'two_factor_expires_at' => null,
                'two_factor_verified' => false,
                'two_factor_enabled' => false,
                'remember_token' => null,
                'last_login_at' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        // Insert data into the users table
        DB::table('users')->insert($usersData);

        // Now we need to create the permission_users relationships
        $permissionUserData = [];
        
        // Admin gets all permissions
        $adminId = DB::table('users')->where('email', 'admin@example.com')->value('id');
        foreach ([$dcmtrdPermissionId, $reitsPermissionId, $legalPermissionId, $compliancePermissionId] as $permissionId) {
            $permissionUserData[] = [
                'user_id' => $adminId,
                'permission_id' => $permissionId,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        
        // DCMTRD Users
        $dcmtrdUser1Id = DB::table('users')->where('email', 'dcmtrd1@example.com')->value('id');
        $dcmtrdUser2Id = DB::table('users')->where('email', 'dcmtrd2@example.com')->value('id');
        $permissionUserData[] = [
            'user_id' => $dcmtrdUser1Id,
            'permission_id' => $dcmtrdPermissionId,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        $permissionUserData[] = [
            'user_id' => $dcmtrdUser2Id,
            'permission_id' => $dcmtrdPermissionId,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        
        // REITS Users
        $reitsUser1Id = DB::table('users')->where('email', 'reits1@example.com')->value('id');
        $reitsUser2Id = DB::table('users')->where('email', 'reits2@example.com')->value('id');
        $permissionUserData[] = [
            'user_id' => $reitsUser1Id,
            'permission_id' => $reitsPermissionId,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        $permissionUserData[] = [
            'user_id' => $reitsUser2Id,
            'permission_id' => $reitsPermissionId,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        
        // Legal Advisor gets LEGAL permission
        $legalId = DB::table('users')->where('email', 'legal@example.com')->value('id');
        $permissionUserData[] = [
            'user_id' => $legalId,
            'permission_id' => $legalPermissionId,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        
        // Compliance Officer gets COMPLIANCE permission
        $complianceId = DB::table('users')->where('email', 'compliance@example.com')->value('id');
        $permissionUserData[] = [
            'user_id' => $complianceId,
            'permission_id' => $compliancePermissionId,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        
        // Manager and Regular users get all permissions
        $managerId = DB::table('users')->where('email', 'manager@example.com')->value('id');
        $regularUserId = DB::table('users')->where('email', 'user@example.com')->value('id');
        
        foreach ([$managerId, $regularUserId] as $userId) {
            foreach ([$dcmtrdPermissionId, $reitsPermissionId, $legalPermissionId, $compliancePermissionId] as $permissionId) {
                $permissionUserData[] = [
                    'user_id' => $userId,
                    'permission_id' => $permissionId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }
        
        // Insert the permission relationships
        DB::table('permission_users')->insert($permissionUserData);
    }
}