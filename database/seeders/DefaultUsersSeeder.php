<?php

namespace Database\Seeders;

use App\Models\User;
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
            // Admin Users
            [
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'role' => 'admin',
                'job_title' => 'Executive',
                'department' => 'Administration',
                'office_location' => 'Headquarters',
                'email_verified_at' => now(),
                'password' => bcrypt('Dcmtrd@2025'),
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
                'name' => 'MOHD ASHRAF BIN AZMI',
                'email' => 'ashraf_azmi@artrustees.com.my',
                'role' => 'admin',
                'job_title' => 'ASISSTANT MANAGER',
                'department' => 'DIGITALIZATION DEPARTMENT',
                'office_location' => 'AMANAHRAYA TRUSTEES BERHAD',
                'email_verified_at' => now(),
                'password' => bcrypt('Dcmtrd@2025'),
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
                'name' => 'MUQRI AMIN BIN MOHD SHAMSUDDIN',
                'email' => 'muqri.amin@artrustees.com.my',
                'role' => 'admin',
                'job_title' => 'SENIOR EXECUTIVE',
                'department' => 'DIGITALIZATION DEPARTMENT',
                'office_location' => 'AMANAHRAYA TRUSTEES BERHAD',
                'email_verified_at' => now(),
                'password' => bcrypt('Dcmtrd@2025'),
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
                'name' => 'NUR FARZANA BINTI ZAIRUL AZMI',
                'email' => 'nurfarzana@artrustees.com.my',
                'role' => 'admin',
                'job_title' => 'EXECUTIVE',
                'department' => 'DIGITALIZATION DEPARTMENT',
                'office_location' => 'AMANAHRAYA TRUSTEES BERHAD',
                'email_verified_at' => now(),
                'password' => bcrypt('Dcmtrd@2025'),
                'two_factor_code' => null,
                'two_factor_expires_at' => null,
                'two_factor_verified' => false,
                'two_factor_enabled' => false,
                'remember_token' => null,
                'last_login_at' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // DCMT Users
            [
                'name' => 'ROSLIM SYAH BIN IDRIS',
                'email' => 'roslimsyah@artrustees.com.my',
                'role' => 'user',
                'job_title' => 'SENIOR MANAGER',
                'department' => 'DEBT CAPITAL MARKET & TRUST UNIT',
                'office_location' => 'AMANAHRAYA TRUSTEES BERHAD',
                'email_verified_at' => now(),
                'password' => bcrypt('Dcmtrd@2025'),
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
                'name' => 'MOHAMAD AZAHARI BIN AB AZIZ',
                'email' => 'mohamad.azahari@artrustees.com.my',
                'role' => 'user',
                'job_title' => 'ASSISTANT MANAGER',
                'department' => 'DEBT CAPITAL MARKET & TRUST UNIT',
                'office_location' => 'AMANAHRAYA TRUSTEES BERHAD',
                'email_verified_at' => now(),
                'password' => bcrypt('Dcmtrd@2025'),
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
                'name' => 'FARAEDALISMALINA BINTI ZAKARIA',
                'email' => 'faraedalismalina@artrustees.com.my',
                'role' => 'user',
                'job_title' => 'SENIOR EXECUTIVE',
                'department' => 'DEBT CAPITAL MARKET & TRUST UNIT',
                'office_location' => 'AMANAHRAYA TRUSTEES BERHAD',
                'email_verified_at' => now(),
                'password' => bcrypt('Dcmtrd@2025'),
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
                'name' => 'NOR IZZAH BINTI MOHAMAD ARIFF',
                'email' => 'izzahariff@artrustees.com.my',
                'role' => 'user',
                'job_title' => 'SENIOR EXECUTIVE',
                'department' => 'DEBT CAPITAL MARKET & TRUST UNIT',
                'office_location' => 'AMANAHRAYA TRUSTEES BERHAD',
                'email_verified_at' => now(),
                'password' => bcrypt('Dcmtrd@2025'),
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
                'name' => 'NUR SAKIENAH BINTI KHAIRUDDIN',
                'email' => 'nursakienah@artrustees.com.my',
                'role' => 'user',
                'job_title' => 'EXECUTIVE',
                'department' => 'DEBT CAPITAL MARKET & TRUST UNIT',
                'office_location' => 'AMANAHRAYA TRUSTEES BERHAD',
                'email_verified_at' => now(),
                'password' => bcrypt('Dcmtrd@2025'),
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
                'name' => 'MUHAMMAD SAYYIDI BIN MOHD BASIL',
                'email' => 'sayyidi@artrustees.com.my',
                'role' => 'user',
                'job_title' => 'EXECUTIVE',
                'department' => 'DEBT CAPITAL MARKET & TRUST UNIT',
                'office_location' => 'AMANAHRAYA TRUSTEES BERHAD',
                'email_verified_at' => now(),
                'password' => bcrypt('Dcmtrd@2025'),
                'two_factor_code' => null,
                'two_factor_expires_at' => null,
                'two_factor_verified' => false,
                'two_factor_enabled' => false,
                'remember_token' => null,
                'last_login_at' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // REITS Users
            [
                'name' => 'DANG FATHIHAH BINTI IBRAHIM',
                'email' => 'fathihah@artrustees.com.my',
                'role' => 'user',
                'job_title' => 'ASSISTANT MANAGER',
                'department' => 'REAL ESTATE INVESTMENT TRUST UNIT',
                'office_location' => 'AMANAHRAYA TRUSTEES BERHAD',
                'email_verified_at' => now(),
                'password' => bcrypt('Dcmtrd@2025'),
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
                'name' => 'NURUL SHAHIDAH BINTI RAS TAMAJIS',
                'email' => 'nurul.shahidah@artrustees.com.my',
                'role' => 'user',
                'job_title' => 'SENIOR EXECUTIVE',
                'department' => 'REAL ESTATE INVESTMENT TRUST UNIT',
                'office_location' => 'AMANAHRAYA TRUSTEES BERHAD',
                'email_verified_at' => now(),
                'password' => bcrypt('Dcmtrd@2025'),
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
                'name' => 'MUHAMMAD AFIS BIN AZMAN',
                'email' => 'afis.azman@artrustees.com.my',
                'role' => 'user',
                'job_title' => 'EXECUTIVE',
                'department' => 'REAL ESTATE INVESTMENT TRUST UNIT',
                'office_location' => 'AMANAHRAYA TRUSTEES BERHAD',
                'email_verified_at' => now(),
                'password' => bcrypt('Dcmtrd@2025'),
                'two_factor_code' => null,
                'two_factor_expires_at' => null,
                'two_factor_verified' => false,
                'two_factor_enabled' => false,
                'remember_token' => null,
                'last_login_at' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Compliance
            [
                'name' => 'RASIDHA BINTI SAKHUDIN @ SALLEHUDIN',
                'email' => 'rasidha@artrustees.com.my',
                'role' => 'compliance',
                'job_title' => 'SENIOR MANAGER',
                'department' => 'COMPLIANCE MONITORING DEPARTMENT',
                'office_location' => 'AMANAHRAYA TRUSTEES BERHAD',
                'email_verified_at' => now(),
                'password' => bcrypt('Dcmtrd@2025'),
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
                'name' => 'DALILA BINTI ZOBIR',
                'email' => 'dalila@artrustees.com.my',
                'role' => 'compliance',
                'job_title' => 'MANAGER',
                'department' => 'COMPLIANCE MONITORING DEPARTMENT',
                'office_location' => 'AMANAHRAYA TRUSTEES BERHAD',
                'email_verified_at' => now(),
                'password' => bcrypt('Dcmtrd@2025'),
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
                'name' => 'SHARIFAH NURAINI BINTI SYED KHALID',
                'email' => 'nuraini@artrustees.com.my',
                'role' => 'compliance',
                'job_title' => 'MANAGER',
                'department' => 'COMPLIANCE MONITORING DEPARTMENT',
                'office_location' => 'AMANAHRAYA TRUSTEES BERHAD',
                'email_verified_at' => now(),
                'password' => bcrypt('Dcmtrd@2025'),
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
                'name' => 'DIAN NADIRAH BINTI JASRI',
                'email' => 'dianjasri@artrustees.com.my',
                'role' => 'compliance',
                'job_title' => 'ASSISTANT MANAGER',
                'department' => 'COMPLIANCE MONITORING DEPARTMENT',
                'office_location' => 'AMANAHRAYA TRUSTEES BERHAD',
                'email_verified_at' => now(),
                'password' => bcrypt('Dcmtrd@2025'),
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
                'name' => 'NUR EFFA NAJIHAH BINTI ABDUL WAHAB',
                'email' => 'effanajihah@artrustees.com.my',
                'role' => 'compliance',
                'job_title' => 'SENIOR EXECUTIVE',
                'department' => 'COMPLIANCE MONITORING DEPARTMENT',
                'office_location' => 'AMANAHRAYA TRUSTEES BERHAD',
                'email_verified_at' => now(),
                'password' => bcrypt('Dcmtrd@2025'),
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
                'name' => 'KHAIRUN NISA BINTI ABD RAZAK',
                'email' => 'khairunnisa_razak@artrustees.com.my',
                'role' => 'compliance',
                'job_title' => 'EXECUTIVE',
                'department' => 'COMPLIANCE MONITORING DEPARTMENT',
                'office_location' => 'AMANAHRAYA TRUSTEES BERHAD',
                'email_verified_at' => now(),
                'password' => bcrypt('Dcmtrd@2025'),
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
                'name' => 'NURUL SYAFIQAH BINTI ABD KADIR',
                'email' => 'nurul.syafiqah@artrustees.com.my',
                'role' => 'compliance',
                'job_title' => 'EXECUTIVE',
                'department' => 'COMPLIANCE MONITORING DEPARTMENT',
                'office_location' => 'AMANAHRAYA TRUSTEES BERHAD',
                'email_verified_at' => now(),
                'password' => bcrypt('Dcmtrd@2025'),
                'two_factor_code' => null,
                'two_factor_expires_at' => null,
                'two_factor_verified' => false,
                'two_factor_enabled' => false,
                'remember_token' => null,
                'last_login_at' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Legal
            [
                'name' => 'ZULHIDA BINTI ABD MAURAD',
                'email' => 'zulhida@artrustees.com.my',
                'role' => 'legal',
                'job_title' => 'SENIOR MANAGER',
                'department' => 'LEGAL DEPARTMENT',
                'office_location' => 'AMANAHRAYA TRUSTEES BERHAD',
                'email_verified_at' => now(),
                'password' => bcrypt('Dcmtrd@2025'),
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
                'name' => 'NUR FARAH BINTI MOHD KAMAL',
                'email' => 'nur.farah@artrustees.com.my',
                'role' => 'legal',
                'job_title' => 'ASSISTANT MANAGER',
                'department' => 'LEGAL DEPARTMENT',
                'office_location' => 'AMANAHRAYA TRUSTEES BERHAD',
                'email_verified_at' => now(),
                'password' => bcrypt('Dcmtrd@2025'),
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
                'name' => 'ASMA NUR QURAISYAH BINTI YUNUS',
                'email' => 'asma.quraisyah@artrustees.com.my',
                'role' => 'legal',
                'job_title' => 'SENIOR EXECUTIVE',
                'department' => 'LEGAL DEPARTMENT',
                'office_location' => 'AMANAHRAYA TRUSTEES BERHAD',
                'email_verified_at' => now(),
                'password' => bcrypt('Dcmtrd@2025'),
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
                'name' => 'AMIR AMSYAR BIN MOHD NAZIR',
                'email' => 'amir.amsyar@artrustees.com.my',
                'role' => 'legal',
                'job_title' => 'SENIOR EXECUTIVE',
                'department' => 'LEGAL DEPARTMENT',
                'office_location' => 'AMANAHRAYA TRUSTEES BERHAD',
                'email_verified_at' => now(),
                'password' => bcrypt('Dcmtrd@2025'),
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
                'name' => 'MAISARAH HUMAIRA BINTI MEOR YAHAYA',
                'email' => 'maisarah.humaira@artrustees.com.my',
                'role' => 'legal',
                'job_title' => 'EXECUTIVE',
                'department' => 'LEGAL DEPARTMENT',
                'office_location' => 'AMANAHRAYA TRUSTEES BERHAD',
                'email_verified_at' => now(),
                'password' => bcrypt('Dcmtrd@2025'),
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
                'name' => 'KHARIESHA BINTI KHALID',
                'email' => 'khariesha@artrustees.com.my',
                'role' => 'legal',
                'job_title' => 'EXECUTIVE',
                'department' => 'LEGAL DEPARTMENT',
                'office_location' => 'AMANAHRAYA TRUSTEES BERHAD',
                'email_verified_at' => now(),
                'password' => bcrypt('Dcmtrd@2025'),
                'two_factor_code' => null,
                'two_factor_expires_at' => null,
                'two_factor_verified' => false,
                'two_factor_enabled' => false,
                'remember_token' => null,
                'last_login_at' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Insert data into the users table
        DB::table('users')->insert($usersData);

        // Now we need to create the permission_users relationships
        $permissionUserData = [];
        
        // Admin users get DCMTRD permission
        $adminEmails = [
            'ashraf_azmi@artrustees.com.my',
            'muqri.amin@artrustees.com.my',
            'nurfarzana@artrustees.com.my'
        ];
        
        foreach ($adminEmails as $email) {
            $userId = DB::table('users')->where('email', $email)->value('id');
            $permissionUserData[] = [
                'user_id' => $userId,
                'permission_id' => $dcmtrdPermissionId,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        
        // DCMTRD Users
        $dcmtrdEmails = [
            'roslimsyah@artrustees.com.my',
            'mohamad.azahari@artrustees.com.my',
            'faraedalismalina@artrustees.com.my',
            'izzahariff@artrustees.com.my',
            'nursakienah@artrustees.com.my',
            'sayyidi@artrustees.com.my'
        ];
        
        foreach ($dcmtrdEmails as $email) {
            $userId = DB::table('users')->where('email', $email)->value('id');
            $permissionUserData[] = [
                'user_id' => $userId,
                'permission_id' => $dcmtrdPermissionId,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        
        // Special case: ROSLIM SYAH BIN IDRIS has both DCMTRD and REITS
        $roslimId = DB::table('users')->where('email', 'roslimsyah@artrustees.com.my')->value('id');
        $permissionUserData[] = [
            'user_id' => $roslimId,
            'permission_id' => $reitsPermissionId,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        
        // REITS Users
        $reitsEmails = [
            'fathihah@artrustees.com.my',
            'nurul.shahidah@artrustees.com.my',
            'afis.azman@artrustees.com.my'
        ];
        
        foreach ($reitsEmails as $email) {
            $userId = DB::table('users')->where('email', $email)->value('id');
            $permissionUserData[] = [
                'user_id' => $userId,
                'permission_id' => $reitsPermissionId,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        
        // Compliance Officers get both DCMTRD and REITS permissions
        $complianceEmails = [
            'rasidha@artrustees.com.my',
            'dalila@artrustees.com.my',
            'nuraini@artrustees.com.my',
            'dianjasri@artrustees.com.my',
            'effanajihah@artrustees.com.my',
            'khairunnisa_razak@artrustees.com.my',
            'nurul.syafiqah@artrustees.com.my'
        ];
        
        foreach ($complianceEmails as $email) {
            $userId = DB::table('users')->where('email', $email)->value('id');
            // Add COMPLIANCE permission
            $permissionUserData[] = [
                'user_id' => $userId,
                'permission_id' => $compliancePermissionId,
                'created_at' => now(),
                'updated_at' => now(),
            ];
            // Add DCMTRD permission
            $permissionUserData[] = [
                'user_id' => $userId,
                'permission_id' => $dcmtrdPermissionId,
                'created_at' => now(),
                'updated_at' => now(),
            ];
            // Add REITS permission
            $permissionUserData[] = [
                'user_id' => $userId,
                'permission_id' => $reitsPermissionId,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        
        // Legal users get both DCMTRD and REITS permissions
        $legalEmails = [
            'zulhida@artrustees.com.my',
            'nur.farah@artrustees.com.my',
            'asma.quraisyah@artrustees.com.my',
            'amir.amsyar@artrustees.com.my',
            'maisarah.humaira@artrustees.com.my',
            'khariesha@artrustees.com.my'
        ];
        
        foreach ($legalEmails as $email) {
            $userId = DB::table('users')->where('email', $email)->value('id');
            // Add LEGAL permission
            $permissionUserData[] = [
                'user_id' => $userId,
                'permission_id' => $legalPermissionId,
                'created_at' => now(),
                'updated_at' => now(),
            ];
            // Add DCMTRD permission
            $permissionUserData[] = [
                'user_id' => $userId,
                'permission_id' => $dcmtrdPermissionId,
                'created_at' => now(),
                'updated_at' => now(),
            ];
            // Add REITS permission
            $permissionUserData[] = [
                'user_id' => $userId,
                'permission_id' => $reitsPermissionId,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        
        // Insert the permission relationships
        DB::table('permission_users')->insert($permissionUserData);
    }
}