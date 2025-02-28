<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DefaultUsersSeeder extends Seeder
{
    public function run()
    {
        // Sample data for users
        $usersData = [
            [
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'role' => 'admin',
                'position' => 'Executive',
                'permission' => 'DCMTRD',
                'email_verified_at' => now(),
                'password' => bcrypt('P@ssw0rd123'), // Use bcrypt for password hashing
                'two_factor_code' => null,
                'two_factor_expires_at' => null,
                'two_factor_verified' => false,
                'two_factor_enabled' => false,
                'remember_token' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'DCMTRD User A',
                'email' => 'dcmtrd1@example.com',
                'role' => 'user',
                'position' => 'Executive',
                'permission' => 'DCMTRD',
                'email_verified_at' => now(),
                'password' => bcrypt('P@ssw0rd123'), // Use bcrypt for password hashing
                'two_factor_code' => null,
                'two_factor_expires_at' => null,
                'two_factor_verified' => false,
                'two_factor_enabled' => false,
                'remember_token' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'DCMTRD User B',
                'email' => 'dcmtrd2@example.com',
                'role' => 'user',
                'position' => 'Executive',
                'permission' => 'DCMTRD',
                'email_verified_at' => now(),
                'password' => bcrypt('P@ssw0rd123'), // Use bcrypt for password hashing
                'two_factor_code' => null,
                'two_factor_expires_at' => null,
                'two_factor_verified' => false,
                'two_factor_enabled' => false,
                'remember_token' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'REITS User A',
                'email' => 'reits1@example.com',
                'role' => 'user',
                'position' => 'Executive',
                'permission' => 'REITS',
                'email_verified_at' => now(),
                'password' => bcrypt('P@ssw0rd123'), // Use bcrypt for password hashing
                'two_factor_code' => null,
                'two_factor_expires_at' => null,
                'two_factor_verified' => false,
                'two_factor_enabled' => false,
                'remember_token' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'REITS User B',
                'email' => 'reits2@example.com',
                'role' => 'user',
                'position' => 'Executive',
                'permission' => 'REITS',
                'email_verified_at' => now(),
                'password' => bcrypt('P@ssw0rd123'), // Use bcrypt for password hashing
                'two_factor_code' => null,
                'two_factor_expires_at' => null,
                'two_factor_verified' => false,
                'two_factor_enabled' => false,
                'remember_token' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Manager',
                'email' => 'manager@example.com',
                'role' => 'user',
                'position' => 'Manager',
                'permission' => '[DCMTRD, REITS]',
                'email_verified_at' => now(),
                'password' => bcrypt('P@ssw0rd123'), // Use bcrypt for password hashing
                'two_factor_code' => null,
                'two_factor_expires_at' => null,
                'two_factor_verified' => false,
                'two_factor_enabled' => false,
                'remember_token' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Regular User',
                'email' => 'user@example.com',
                'role' => 'user',
                'position' => 'Executive',
                'permission' => '[DCMTRD, REITS]',
                'email_verified_at' => now(),
                'password' => bcrypt('P@ssw0rd123'),
                'two_factor_code' => null,
                'two_factor_expires_at' => null,
                'two_factor_verified' => false,
                'two_factor_enabled' => false,
                'remember_token' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Compliance Officer',
                'email' => 'compliance@example.com',
                'role' => 'compliance',
                'position' => 'Executive',
                'permission' => '[DCMTRD, REITS]',
                'email_verified_at' => now(),
                'password' => bcrypt('P@ssw0rd123'),
                'two_factor_code' => null,
                'two_factor_expires_at' => null,
                'two_factor_verified' => false,
                'two_factor_enabled' => false,
                'remember_token' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Legal Advisor',
                'email' => 'legal@example.com',
                'role' => 'legal',
                'position' => 'Executive',
                'permission' => '[DCMTRD, REITS]',
                'email_verified_at' => now(),
                'password' => bcrypt('P@ssw0rd123'),
                'two_factor_code' => null,
                'two_factor_expires_at' => null,
                'two_factor_verified' => false,
                'two_factor_enabled' => false,
                'remember_token' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        // Insert data into the users table
        DB::table('users')->insert($usersData);
    }
}