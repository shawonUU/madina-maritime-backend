<?php

namespace Modules\Website\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Website\App\Models\WebsiteCustomer;
use Modules\Website\App\Models\WebsiteCustomerPage;
use Modules\Website\App\Models\WebsiteCustomerStat;

class WebsiteCustomerSeeder extends Seeder
{
    public function run(): void
    {
        WebsiteCustomerPage::updateOrCreate(
            ['id' => 1],
            [
                'label' => 'Our Customers',
                'title' => 'Trusted by',
                'highlight' => 'industry leaders.',
                'description' => 'We build long-term relationships with organizations that value reliability, operational excellence and dependable maritime solutions.',
                'hero_image' => '/images/ship22.jpg',
                'explore_button_text' => 'Explore Customers',
                'explore_button_url' => '#customers',
                'partner_button_text' => 'Become a Partner',
                'partner_button_url' => '/contact',
                'status' => true,
            ]
        );

        $stats = [
            [
                'value' => '50+',
                'label' => 'Corporate Clients',
                'icon' => 'Building2',
                'sort_order' => 1,
            ],
            [
                'value' => '15+',
                'label' => 'Industries Served',
                'icon' => 'Globe2',
                'sort_order' => 2,
            ],
            [
                'value' => '1000+',
                'label' => 'Successful Operations',
                'icon' => 'Ship',
                'sort_order' => 3,
            ],
            [
                'value' => '98%',
                'label' => 'Client Satisfaction',
                'icon' => 'Star',
                'sort_order' => 4,
            ],
        ];

        foreach ($stats as $stat) {
            WebsiteCustomerStat::updateOrCreate(
                ['label' => $stat['label']],
                $stat + ['status' => true]
            );
        }

        $customers = [
            [
                'name' => 'Rahim Group',
                'category' => 'Industrial',
                'logo' => '/images/customer_rahim_steel.png',
                'description' => 'Supporting large-scale industrial and logistics operations with dependable maritime solutions.',
                'sort_order' => 1,
            ],
            [
                'name' => 'Awal & Brothers Chemicals Company Limited',
                'category' => 'Industrial',
                'logo' => '/images/Awal & Brothers Chemicals Company Limited.jpg',
                'description' => 'Providing reliable transportation and maritime support for large-scale commercial operations.',
                'sort_order' => 2,
            ],
            [
                'name' => 'Astha Feed Industries Limited',
                'category' => 'Manufacturing',
                'logo' => '/images/Astha Feed Industries Ltd.png',
                'description' => 'Delivering efficient logistics and marine transportation solutions for industrial requirements.',
                'sort_order' => 3,
            ],
            [
                'name' => 'Bashundhara Group',
                'category' => 'Manufacturing',
                'logo' => '/images/bashundhara group.png',
                'description' => 'Supporting supply-chain movement through reliable transportation and operational services.',
                'sort_order' => 4,
            ],
            [
                'name' => 'Nabil Group',
                'category' => 'Manufacturing',
                'logo' => '/images/Nabil Group.png',
                'description' => 'Nabil Group is one of the largest and leading conglomerates in Bangladesh.',
                'sort_order' => 5,
            ],
            [
                'name' => 'Akij Cement IND. LTD',
                'category' => 'Cement Manufacturing',
                'logo' => '/images/AKIJ CEMENT IND LTD.png',
                'description' => 'AKIJ Cement Company Limited is currently considered a strategic business unit under AKIJ Resource. We are the first in Bangladesh to implement vertical roller mill technology to provide home builders with the highest quality cement available.',
                'sort_order' => 6,
            ],
            [
                'name' => 'Index Agro Industries Limited',
                'category' => 'AGRO INDUSTRIES',
                'logo' => '/images/INDEX AGRO INDUSTRIES LIMITED.png',
                'description' => 'Index Agro Industries Limited (IAIL), a concern of XIC, began operations in the year 2000. IAIL produces poultry feed, fish-feed, and Day-Old Chicks (broiler & layer). Most recently, IAIL has decided to move ahead with Initial.',
                'sort_order' => 7,
            ],
            [
                'name' => 'RAK Group',
                'category' => 'Manufacturing',
                'logo' => '/images/RAK GROUP.png',
                'description' => 'RAK Group, leading private sector business conglomerate in country, commenced business the year of 1994 in name and style of Gentech International.',
                'sort_order' => 8,
            ],
        ];

        foreach ($customers as $customer) {
            WebsiteCustomer::updateOrCreate(
                ['name' => $customer['name']],
                $customer + ['status' => true]
            );
        }
    }
}