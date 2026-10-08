<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Modules\Admin\App\Models\Module;
use Modules\Admin\App\Models\User;
use Modules\Admin\App\Models\UserAccess;
use Modules\Admin\Database\Seeders\MenuSeeder;
use Modules\Canteen\Database\Seeders\MealDatabaseSeeder;
use Modules\HRM\Database\Seeders\RecruitmentEmailTemplateSeeder;
use Modules\Website\Database\Seeders\AboutPageSeeder;
use Modules\Website\Database\Seeders\ContactSettingSeeder;
use Modules\Website\Database\Seeders\WebsiteCareerSettingSeeder;
use Modules\Website\Database\Seeders\WebsiteCustomerSeeder;
use Modules\Website\Database\Seeders\WebsiteHomeSettingSeeder;
use Modules\Website\Database\Seeders\WebsiteServicesSeeder;
use Modules\Website\Database\Seeders\WebsiteSisterConcernSeeder;
use Modules\Website\Database\Seeders\WebsiteVendorPartnerSeeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Canteen Seeder
        |--------------------------------------------------------------------------
        */

        $this->call([
            MealDatabaseSeeder::class,
        ]);


        /*
        |--------------------------------------------------------------------------
        | Admin Menu Seeder
        |--------------------------------------------------------------------------
        */

        $this->call([
            MenuSeeder::class,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Recruitment Email Template Seeder
        |--------------------------------------------------------------------------
        */
        $this->call([
            RecruitmentEmailTemplateSeeder::class,
        ]);


        /*
        |--------------------------------------------------------------------------
        | About Page Seeder
        |--------------------------------------------------------------------------
        */
        $this->call([
            AboutPageSeeder::class,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Sister Concern Seeder
        |--------------------------------------------------------------------------
        */

        $this->call([
            WebsiteSisterConcernSeeder::class,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Service Seeder
        |--------------------------------------------------------------------------
        */

        $this->call([
            WebsiteServicesSeeder::class,
        ]);

                /*
        |--------------------------------------------------------------------------
        | Customer Seeder
        |--------------------------------------------------------------------------
        */

        $this->call([
            WebsiteCustomerSeeder::class,
        ]);


        /*
        |--------------------------------------------------------------------------
        | Vendor And Partner Seeder
        |--------------------------------------------------------------------------
        */

        $this->call([
            WebsiteVendorPartnerSeeder::class,
        ]);


        /*
        |--------------------------------------------------------------------------
        | Contact Seeder
        |--------------------------------------------------------------------------
        */

        $this->call([
            ContactSettingSeeder::class,
        ]);


                /*
        |--------------------------------------------------------------------------
        | Career Seeder
        |--------------------------------------------------------------------------
        */

        $this->call([
            WebsiteCareerSettingSeeder::class,
        ]);


        /*
        |--------------------------------------------------------------------------
        | Career Seeder
        |--------------------------------------------------------------------------
        */

        $this->call([
            WebsiteHomeSettingSeeder::class,
        ]);

        


        /*
        |--------------------------------------------------------------------------
        | Admin User
        |--------------------------------------------------------------------------
        */

        $admin = User::updateOrCreate(
            [
                'email' => 'sawonmiah@madina.co',
            ],
            [
                'code' => getGenerateCode(
                    User::class,
                    'code',
                    'USR',
                    8
                ),
                'name' => 'Md. Sawon Miah',
                'password' => Hash::make('12345678'),
            ]
        );


        /*
        |--------------------------------------------------------------------------
        | Other Users
        |--------------------------------------------------------------------------
        */

        User::updateOrCreate(
            [
                'email' => 'mojmeen@gmail.com',
            ],
            [
                'code' => getGenerateCode(
                    User::class,
                    'code',
                    'USR',
                    8
                ),
                'name' => 'Mojmeen Akther',
                'password' => Hash::make('12345678'),
            ]
        );


        User::updateOrCreate(
            [
                'email' => 'hr@gmail.com',
            ],
            [
                'code' => getGenerateCode(
                    User::class,
                    'code',
                    'USR',
                    8
                ),
                'name' => 'Jannatul Ferdous',
                'password' => Hash::make('12345678'),
            ]
        );


        /*
        |--------------------------------------------------------------------------
        | Admin Full Access
        |--------------------------------------------------------------------------
        |
        | Admin will have full access to every Menu and Child Menu.
        |
        | can_view   = true
        | can_create = true
        | can_update = true
        | can_delete = true
        |
        */

        $modules = Module::with([
            'menus.childMenus',
        ])->get();


        foreach ($modules as $module) {

            foreach ($module->menus as $menu) {

                /*
                |--------------------------------------------------------------------------
                | Menu Access
                |--------------------------------------------------------------------------
                */

                UserAccess::updateOrCreate(
                    [
                        'user_id' => $admin->id,
                        'menu_id' => $menu->id,
                        'child_menu_id' => null,
                    ],
                    [
                        'module_id' => $module->id,
                        'can_view' => true,
                        'can_create' => true,
                        'can_update' => true,
                        'can_delete' => true,
                    ]
                );


                /*
                |--------------------------------------------------------------------------
                | Child Menu Access
                |--------------------------------------------------------------------------
                */

                foreach ($menu->childMenus as $childMenu) {

                    UserAccess::updateOrCreate(
                        [
                            'user_id' => $admin->id,
                            'menu_id' => $menu->id,
                            'child_menu_id' => $childMenu->id,
                        ],
                        [
                            'module_id' => $module->id,
                            'can_view' => true,
                            'can_create' => true,
                            'can_update' => true,
                            'can_delete' => true,
                        ]
                    );
                }
            }
        }
    }
}