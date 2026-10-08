<?php

namespace Modules\Website\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Website\App\Models\WebsiteAbout;
use Modules\Website\App\Models\WebsiteAboutStat;
use Modules\Website\App\Models\WebsiteAboutTeam;

class AboutPageSeeder extends Seeder
{
    public function run(): void
    {

        $about = [
            'label' => 'About Madina Maritime',

            'title' => 'Built on Trust. Driven by Progress.',

            'highlight' => 'Trust.',

            'description' => 'Discover the people, principles and ambitions behind Madina Maritime Limited and our journey toward a stronger maritime future.',

            'image' => '/images/ship2.jpg',

            'journey_description' => 'Our story is one of continuous progress. From our early beginnings to our current maritime operations, each stage has shaped who we are today.',

            'milestones' => [
                [
                    'year' => '2000+',
                    'title' => 'The Beginning',
                    'description' => 'The foundation of a long-term business journey built around ambition, discipline and trust.',
                ],
                [
                    'year' => '2010+',
                    'title' => 'Business Expansion',
                    'description' => 'Expansion across multiple business areas strengthened the group\'s capabilities and market presence.',
                ],
                [
                    'year' => '2020+',
                    'title' => 'Digital Evolution',
                    'description' => 'Technology and modern operational systems became increasingly important to our way of working.',
                ],
                [
                    'year' => '2026',
                    'title' => 'Moving Forward',
                    'description' => 'Continuing to develop our maritime capabilities with a strong focus on reliability, innovation and sustainable growth.',
                ],
            ],

            'mission_title' => 'Delivering meaningful maritime solutions.',

            'mission_description' => 'Madina Maritime Ltd. is a concern of Madina Group, strive to develop this venture through its customer driven value-added shipping services by meeting the requirements of its customer/ partner through innovation, strategy and to create competitive edge in growing Maritime Trade development to/from Bangladesh.',

            'vision_title' => 'Creating a stronger maritime future.',

            'vision_description' => 'To become a trusted maritime organization recognized for operational excellence, innovation, safety and sustainable contribution to the industries and communities we serve.',

            'looking_ahead_title' => 'Looking Ahead',

            'looking_ahead_description' => 'We continue to invest in people, technology and operational capabilities to build a stronger future.',

            'tonnage' => [
                [
                    'year' => 2022,
                    'tonnage' => 185000,
                ],
                [
                    'year' => 2023,
                    'tonnage' => 240000,
                ],
                [
                    'year' => 2024,
                    'tonnage' => 315000,
                ],
                [
                    'year' => 2025,
                    'tonnage' => 380000,
                ],
            ],

            'status' => 1,

            'created_at' => now(),
            'updated_at' => now(),
        ];

        /*
        |--------------------------------------------------------------------------
        | About Record
        |--------------------------------------------------------------------------
        */

        $existingAbout = WebsiteAbout::first();

        if ($existingAbout) {
            $existingAbout->update($about);
        } else {
            WebsiteAbout::create($about);
        }

        /*
        |--------------------------------------------------------------------------
        | About Statistics
        |--------------------------------------------------------------------------
        */
        WebsiteAboutStat::truncate();

        WebsiteAboutStat::insert([
            [
                'value' => '30+',
                'label' => 'Years of Experience',
                'sort_order' => 1,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'value' => '05',
                'label' => 'Business Divisions',
                'sort_order' => 2,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'value' => '50+',
                'label' => 'Global Routes',
                'sort_order' => 3,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'value' => '1000+',
                'label' => 'Successful Deliveries',
                'sort_order' => 4,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | About Team
        |--------------------------------------------------------------------------
        */

        WebsiteAboutTeam::truncate();

        WebsiteAboutTeam::insert([
            [
                'name' => 'Mojmeen Akther',
                'designation' => 'AGM (A&F)',
                'category' => 'leadership',
                'image' => '',
                'email' => 'mojmeen@madina.co',
                'phone' => null,
                'sort_order' => 1,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Azad Mollik',
                'designation' => 'Manager(Operation)',
                'category' => 'leadership',
                'image' => '',
                'email' => 'mallik@madina.co',
                'phone' => null,
                'sort_order' => 2,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'MD Reaz Uddin',
                'designation' => 'Sr. Manager, SCM',
                'category' => 'leadership',
                'image' => null,
                'email' => 'reaz.uddin@madina.co',
                'phone' => null,
                'sort_order' => 3,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'MD Golam Moktadir',
                'designation' => 'Manager, IT',
                'category' => 'leadership',
                'image' => null,
                'email' => 'golam.moktadir@madina.co',
                'phone' => null,
                'sort_order' => 4,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        $this->command->info('About page default data seeded successfully.');
    }
}