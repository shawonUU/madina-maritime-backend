<?php

namespace Modules\Website\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Website\App\Models\WebsiteCareerSetting;

class WebsiteCareerSettingSeeder extends Seeder
{
    public function run(): void
    {
        WebsiteCareerSetting::updateOrCreate(
            ['id' => 1],
            [
                'hero_label' => 'Careers at MML',
                'hero_title' => 'Build your',
                'hero_highlight' => 'future with us.',
                'hero_description' => 'Join a growing maritime organization where talented people, technology and operational excellence come together.',
                'hero_image' => '/images/ship32.jpeg',
                'hero_button_text' => 'Explore Opportunities',
                'hero_button_url' => '#open-positions',
                'bottom_caption' => 'Careers & Opportunities',

                'stats' => [
                    [
                        'value' => '24/7',
                        'label' => 'Operational Environment',
                    ],
                    [
                        'value' => '100%',
                        'label' => 'Commitment to People',
                    ],
                    [
                        'value' => '∞',
                        'label' => 'Opportunities to Grow',
                    ],
                ],

                'why_label' => '01 — Why MML',

                'why_benefits' => [
                    [
                        'icon' => 'GraduationCap',
                        'title' => 'Professional Growth',
                        'desc' => 'Opportunities to learn, develop new skills and grow with the organization.',
                    ],
                    [
                        'icon' => 'Sparkles',
                        'title' => 'Innovation',
                        'desc' => 'Work on modern digital solutions and technology-driven business initiatives.',
                    ],
                    [
                        'icon' => 'Users',
                        'title' => 'Collaborative Culture',
                        'desc' => 'A professional environment where people, ideas and teamwork are valued.',
                    ],
                ],

                'jobs_label' => '02 — Open Positions',
                'jobs_title' => 'Find your next opportunity.',
                'jobs_description' => 'Explore our current openings and find a role where your skills and experience can make an impact.',

                'status' => true,
            ]
        );
    }
}