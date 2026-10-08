<?php

namespace Modules\Website\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Website\App\Models\WebsiteHomeSetting;

class WebsiteHomeSettingSeeder extends Seeder
{
    public function run(): void
    {
        WebsiteHomeSetting::updateOrCreate(
            ['id' => 1],
            [
                'hero_label' => 'Madina Maritime Limited',
                'hero_title' => 'Connecting',
                'hero_highlight' => 'Business',
                'hero_title_suffix' => 'Through The Sea.',
                'hero_description' =>
                    'Flexible, reliable and on-time maritime services built around operational excellence, trust and long-term partnerships.',

                'hero_primary_button_text' => 'Discover MML',
                'hero_primary_button_url' => '/about',

                'hero_secondary_button_text' => 'Contact Us',
                'hero_secondary_button_url' => '/contact',

                'stats' => [
                    [
                        'value' => '24/7',
                        'label' => 'Operational Support',
                        'icon' => 'Waves',
                    ],
                    [
                        'value' => '30+',
                        'label' => 'Years of Experience',
                        'icon' => 'Award',
                    ],
                    [
                        'value' => '05',
                        'label' => 'Business Divisions',
                        'icon' => 'Globe2',
                    ],
                    [
                        'value' => '100%',
                        'label' => 'Commitment',
                        'icon' => 'CheckCircle2',
                    ],
                ],

                'about_label' => '01 — About Us',
                'about_title' => 'Built on trust.',
                'about_highlight' => 'Driven by progress.',
                'about_description' =>
                    'Madina Maritime Limited is part of Madina Group, one of the leading diversified business groups in Bangladesh.',
                'about_secondary_description' =>
                    'We are a group of professionals committed to expand services & business in the field of Maritime Trade, Transportation and Logistics, Supply Chain Management business with an innovative idea through meeting the international standard of best business practice.',
                'about_image' => '/images/ship2.jpg',
                'about_badge_title' => 'Maritime',
                'about_badge_subtitle' => 'Excellence',
                'about_button_text' => 'More About Us',
                'about_button_url' => '/about',

                'about_points' => [
                    'Reliable marine operations',
                    'Experienced professionals',
                    'Safety-focused culture',
                    'Long-term partnerships',
                ],

                'philosophy_label' => '02 — Our Philosophy',
                'philosophy_title' =>
                    'Delivering flexible, reliable, and timely shipping solutions across waters.',
                'philosophy_description' =>
                    'We are delighted to introduce ourselves as Madina Maritime Limited (MML). From a modest company to an International conglomerate, take a journey through our historic timeline to learn more about how Madina Maritime came to be how we are today.',

                'philosophy_items' => [
                    [
                        'number' => '01',
                        'title' => 'Rapid Progress',
                        'desc' => 'Madina Maritime Limited is a concern of Madina Group, one of the leading companies in Bangladesh, with diversified interests across Polymer Industries, Marine Services, Trading, Cement Industries and Property Development.',
                        'img' => '/images/ship-new4.jpeg',
                        'icon' => 'MoveUpRight',
                    ],
                    [
                        'number' => '02',
                        'title' => 'Trust',
                        'desc' => 'We continuously strive to accomplish what has not easily been done before through the ideas, efforts and capabilities of every member of our team. A challenging mindset is fundamental to our approach.',
                        'img' => '/images/ship-new1.jpeg',
                        'icon' => 'ShieldCheck',
                    ],
                    [
                        'number' => '03',
                        'title' => 'Action',
                        'desc' => 'Economic success is a common objective across industries. At MML, successful results matter, but we also place strong emphasis on the process, discipline and continuous improvement behind those results.',
                        'img' => '/images/ship-new2.jpeg',
                        'icon' => 'Target',
                    ],
                ],

                'business_label' => '03 — Our Business',
                'business_title' => 'Diverse capabilities.',
                'business_highlight' => 'One trusted partner.',
                'business_description' =>
                    'Our diversified business capabilities allow us to create long-term value across multiple industries and markets.',

                'business_divisions' => [
                    [
                        'title' => 'Marine Services',
                        'description' => 'Reliable marine operations supported by experienced teams and modern operational practices.',
                        'image' => '/images/Picture4.png',
                        'icon' => 'Ship',
                        'url' => '/services',
                    ],
                    [
                        'title' => 'Marine Logistics',
                        'description' => 'Efficient commercial operations connecting products, partners and markets.',
                        'image' => '/images/ship2.jpg',
                        'icon' => 'Globe2',
                        'url' => '/services',
                    ],
                    [
                        'title' => 'Industrial Operations',
                        'description' => 'Supporting diversified industrial activities through disciplined and reliable operations.',
                        'image' => '/images/Picture3.png',
                        'icon' => 'Anchor',
                        'url' => '/services',
                    ],
                ],

                'why_label' => '04 — Why MML',
                'why_title' => 'Reliability is not',
                'why_highlight' => 'just a promise.',
                'why_description' =>
                    'It is reflected in the way we operate, communicate and build relationships with our customers and partners.',

                'why_items' => [
                    [
                        'icon' => 'ShieldCheck',
                        'title' => 'Safety First',
                        'desc' => 'Safety remains central to our operational culture.',
                    ],
                    [
                        'icon' => 'Users',
                        'title' => 'Experienced Team',
                        'desc' => 'Skilled people driving disciplined maritime operations.',
                    ],
                    [
                        'icon' => 'Award',
                        'title' => 'Operational Excellence',
                        'desc' => 'Focused on consistency, quality and continuous improvement.',
                    ],
                ],

                'why_image' => '/images/ship-new3.jpeg',

                'responsible_title' => 'Responsible Growth',
                'responsible_description' =>
                    'Building sustainable value for our business, people and communities.',

                'status' => true,
            ]
        );
    }
}