<?php

namespace Modules\Website\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Website\App\Models\WebsiteSisterConcern;
use Modules\Website\App\Models\WebsiteSisterConcernPage;
use Modules\Website\App\Models\WebsiteSisterConcernSector;
use Modules\Website\App\Models\WebsiteSisterOrganization;

class WebsiteSisterConcernSeeder extends Seeder
{
    public function run(): void
    {
        WebsiteSisterConcernPage::query()->delete();
        WebsiteSisterConcernSector::query()->delete();
        WebsiteSisterConcern::query()->delete();
        WebsiteSisterOrganization::query()->delete();

        WebsiteSisterConcernPage::create([
            'label' => 'Madina Group',
            'title' => 'One Group',
            'highlight' => 'Many Capabilities.',
            'description' => 'Our sister concerns bring together expertise across marine services, logistics, transportation, equipment, energy and industrial operations.',
            'hero_image' => '/images/ship-new3.jpeg',
            'status' => true,
        ]);

        $sectors = [
            [
                'value' => '09',
                'label' => 'Sister Concerns',
                'icon' => 'Building2',
                'sort_order' => 1,
            ],
            [
                'value' => '06+',
                'label' => 'Business Sectors',
                'icon' => 'Globe2',
                'sort_order' => 2,
            ],
            [
                'value' => 'Marine',
                'label' => 'Core Expertise',
                'icon' => 'Ship',
                'sort_order' => 3,
            ],
            [
                'value' => 'Bangladesh',
                'label' => 'Primary Market',
                'icon' => 'Landmark',
                'sort_order' => 4,
            ],
        ];

        foreach ($sectors as $sector) {
            WebsiteSisterConcernSector::create($sector);
        }

        $concerns = [
            [
                'title' => 'Madina Polymer Industries Ltd',
                'short_title' => 'Polymer',
                'category' => 'Polymer',
                'description' => 'Madina TANK · Madina PUMP · Madina Kitchen Sink · Madina Gas Stove · Madina HDPE Pipe',
                'image' => '/images/Madina Polymer Industries Ltd.jpg',
                'icon' => 'Wrench',
                'number' => '01',
                'sort_order' => 1,
            ],
            [
                'title' => 'Madina Developments Ltd',
                'short_title' => 'Developments',
                'category' => 'Developments',
                'description' => 'Madina Maritime Ltd',
                'image' => '/images/Madina Developments1.png',
                'icon' => 'Ship',
                'number' => '03',
                'sort_order' => 2,
            ],
            [
                'title' => 'ERZA Plastic Company Ltd',
                'short_title' => 'Household',
                'category' => 'Household',
                'description' => 'Household · Plastic Furniture',
                'image' => '/images/ERZA Plastic.png',
                'icon' => 'Wrench',
                'number' => '05',
                'sort_order' => 3,
            ],
            [
                'title' => 'Madina Trading Corporation (Pvt.) Ltd',
                'short_title' => 'Trading',
                'category' => 'Trading',
                'description' => 'Trading',
                'image' => '/images/Madina Trading Corporation.jpg',
                'icon' => 'Waves',
                'number' => '06',
                'sort_order' => 4,
            ],
            [
                'title' => 'Duroplast BD Ltd',
                'short_title' => 'Duroplast',
                'category' => 'Duroplast',
                'description' => 'Duroplast Tank · Duroplast Pipe',
                'image' => '/images/Duroplast BD Ltd.jpg',
                'icon' => 'Fuel',
                'number' => '08',
                'sort_order' => 5,
            ],
            [
                'title' => 'Chand Sarder Cold Storage Ltd.',
                'short_title' => 'Cold Storage',
                'category' => 'Cold Storage',
                'description' => 'Chand Sarder Cold Storage Ltd',
                'image' => null,
                'icon' => 'Factory',
                'number' => '09',
                'sort_order' => 6,
            ],
        ];

        foreach ($concerns as $concern) {
            WebsiteSisterConcern::create($concern);
        }

        $organizations = [
            [
                'name' => 'Madina Shipyard',
                'function' => 'Docking & Repairing',
                'icon' => 'Ship',
                'sort_order' => 1,
            ],
            [
                'name' => 'Madina Logistics & Shipping Ltd',
                'function' => 'Clearing and Shipping Agent',
                'icon' => 'Package',
                'sort_order' => 2,
            ],
            [
                'name' => 'M M R (Bangladesh) Shipping Ltd',
                'function' => 'Shipping Agent',
                'icon' => 'Ship',
                'sort_order' => 3,
            ],
            [
                'name' => 'Fleet International Ltd',
                'function' => 'Cargo Handling Operator',
                'icon' => 'Truck',
                'sort_order' => 4,
            ],
            [
                'name' => 'Madina Equipment Ltd',
                'function' => 'Equipment Service',
                'icon' => 'Wrench',
                'sort_order' => 5,
            ],
            [
                'name' => 'Bismillah Navigation Ltd',
                'function' => 'Inland River Carrier',
                'icon' => 'Waves',
                'sort_order' => 6,
            ],
            [
                'name' => 'Madina Transport Ltd',
                'function' => 'Road Transport Service',
                'icon' => 'Truck',
                'sort_order' => 7,
            ],
            [
                'name' => 'Madina Petroleum Service Ltd',
                'function' => 'Fuel Supply',
                'icon' => 'Fuel',
                'sort_order' => 8,
            ],
            [
                'name' => 'Madina Cement Industries Ltd',
                'function' => 'Cement Producer (Tiger Brand)',
                'icon' => 'Factory',
                'sort_order' => 9,
            ],
        ];

        foreach ($organizations as $organization) {
            WebsiteSisterOrganization::create($organization);
        }
    }
}