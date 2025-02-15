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
                'email_verified_at' => now(),
                'password' => bcrypt('P@ssw0rd123'), // Use bcrypt for password hashing
                'two_factor_code' => null,
                'two_factor_expires_at' => null,
                'two_factor_verified' => false,
                'two_factor_enabled' => true,
                'remember_token' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Regular User',
                'email' => 'user@example.com',
                'role' => 'user',
                'email_verified_at' => now(),
                'password' => bcrypt('P@ssw0rd123'),
                'two_factor_code' => null,
                'two_factor_expires_at' => null,
                'two_factor_verified' => false,
                'two_factor_enabled' => true,
                'remember_token' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Compliance Officer',
                'email' => 'compliance@example.com',
                'role' => 'compliance',
                'email_verified_at' => now(),
                'password' => bcrypt('P@ssw0rd123'),
                'two_factor_code' => null,
                'two_factor_expires_at' => null,
                'two_factor_verified' => false,
                'two_factor_enabled' => true,
                'remember_token' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Legal Advisor',
                'email' => 'legal@example.com',
                'role' => 'legal',
                'email_verified_at' => now(),
                'password' => bcrypt('P@ssw0rd123'),
                'two_factor_code' => null,
                'two_factor_expires_at' => null,
                'two_factor_verified' => false,
                'two_factor_enabled' => true,
                'remember_token' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Approver User',
                'email' => 'approver@example.com',
                'role' => 'approver',
                'email_verified_at' => now(),
                'password' => bcrypt('P@ssw0rd123'),
                'two_factor_code' => null,
                'two_factor_expires_at' => null,
                'two_factor_verified' => false,
                'two_factor_enabled' => true,
                'remember_token' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Maker User',
                'email' => 'maker@example.com',
                'role' => 'maker',
                'email_verified_at' => now(),
                'password' => bcrypt('P@ssw0rd123'),
                'two_factor_code' => null,
                'two_factor_expires_at' => null,
                'two_factor_verified' => false,
                'two_factor_enabled' => true,
                'remember_token' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Insert data into the users table
        DB::table('users')->insert($usersData);
    }
}