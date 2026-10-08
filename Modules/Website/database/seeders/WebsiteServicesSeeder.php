<?php

namespace Modules\Website\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Website\App\Models\WebsiteServiceEquipment;
use Modules\Website\App\Models\WebsiteService;
use Modules\Website\App\Models\WebsiteServicePage;
use Modules\Website\App\Models\WebsiteServiceStat;

class WebsiteServicesSeeder extends Seeder
{
    public function run(): void
    {
        WebsiteServicePage::updateOrCreate(
            ['id' => 1],
            [
                'label' => 'Madina Maritime Limited',
                'title' => 'Marine',
                'highlight' => 'Services',
                'description' => 'Reliable maritime solutions built around safety, operational excellence and long-term partnerships.',
                'hero_image' => '/images/ship2.jpg',
                'status' => true,
            ]
        );

        $stats = [
            [
                'value' => '24/7',
                'label' => 'Operational Support',
                'sort_order' => 1,
            ],
            [
                'value' => '15+',
                'label' => 'Years of Experience',
                'sort_order' => 2,
            ],
            [
                'value' => '01',
                'label' => 'Trusted Partner',
                'sort_order' => 3,
            ],
            [
                'value' => '100%',
                'label' => 'Safety Commitment',
                'sort_order' => 4,
            ],
        ];

        foreach ($stats as $stat) {
            WebsiteServiceStat::updateOrCreate(
                [
                    'sort_order' => $stat['sort_order'],
                ],
                [
                    'value' => $stat['value'],
                    'label' => $stat['label'],
                    'status' => true,
                ]
            );
        }

        $services = [
            [
                'number' => '01',
                'title' => 'Shipping Agency',
                'description' => 'Providing reliable vessel agency services, including port coordination, documentation, and operational support.',
                'icon' => 'Ship',
                'sort_order' => 1,
            ],
            [
                'number' => '02',
                'title' => 'C&F Agency',
                'description' => 'Handling customs clearance, documentation, and related procedures for smooth and efficient cargo movement.',
                'icon' => 'FileCheck',
                'sort_order' => 2,
            ],
            [
                'number' => '03',
                'title' => 'Ship Handling Operator',
                'description' => 'Managing ship handling operations with efficient coordination, safety, and timely execution at port.',
                'icon' => 'ShipWheel',
                'sort_order' => 3,
            ],
            [
                'number' => '04',
                'title' => 'Filling Service',
                'description' => 'Providing professional filling and cargo-related support services to ensure smooth and efficient operations.',
                'icon' => 'PackageCheck',
                'sort_order' => 4,
            ],
            [
                'number' => '05',
                'title' => 'Lighter Vessel Operator',
                'description' => 'Operating lighter vessels for safe and efficient transportation of cargo between vessels and ports.',
                'icon' => 'Anchor',
                'sort_order' => 5,
            ],
            [
                'number' => '06',
                'title' => 'Logistics (Loading / Unloading) Service',
                'description' => 'Providing efficient loading, unloading, cargo handling, and logistics support for seamless cargo movement.',
                'icon' => 'Container',
                'sort_order' => 6,
            ],
            [
                'number' => '07',
                'title' => 'International Trading',
                'description' => 'Facilitating international trade through reliable sourcing, supply, import, and export solutions.',
                'icon' => 'Globe2',
                'sort_order' => 7,
            ],
            [
                'number' => '08',
                'title' => 'Holding Capacity',
                'description' => 'Providing reliable cargo holding and storage capacity to support efficient handling, temporary storage, and smooth cargo operations.',
                'icon' => 'Warehouse',
                'sort_order' => 8,
            ],
            [
                'number' => '09',
                'title' => 'Ship Building',
                'description' => 'Supporting ship building projects with reliable coordination, quality-focused execution, and efficient marine construction solutions.',
                'icon' => 'ShipIcon',
                'sort_order' => 9,
            ],
        ];

        foreach ($services as $service) {
            WebsiteService::updateOrCreate(
                [
                    'sort_order' => $service['sort_order'],
                ],
                $service + ['status' => true]
            );
        }

        $equipments = [
            [
                'category' => 'Marine Vessel',
                'name' => 'Lighter Vessel',
                'units' => '31',
                'description' => 'A fleet of lighter vessels supporting bulk cargo transportation, loading, unloading and efficient movement of goods through inland and coastal waterways.',
                'image' => '/images/Picture3.png',
                'sort_order' => 1,
            ],
            [
                'category' => 'Marine Vessel',
                'name' => 'Hatch Barge',
                'units' => '10',
                'description' => 'Covered cargo barges designed for secure transportation and handling of bulk and general cargo across inland waterways.',
                'image' => '/images/ship3.jpg',
                'sort_order' => 2,
            ],
            [
                'category' => 'Marine Vessel',
                'name' => 'Flat Barge',
                'units' => '5',
                'description' => 'Versatile flat-deck barges suitable for transporting heavy equipment, construction materials and bulk cargo.',
                'image' => '/images/Barge Haji Salim-2.jpg',
                'sort_order' => 3,
            ],
            [
                'category' => 'Cargo Handling',
                'name' => 'Conveyor Belt Barge',
                'units' => '5',
                'description' => 'Specialized barges equipped with conveyor systems for efficient loading, unloading and continuous movement of bulk materials.',
                'image' => '/images/conveyor-belt-barge.webp',
                'sort_order' => 4,
            ],
            [
                'category' => 'Marine Support',
                'name' => 'Tug Boat',
                'units' => '4',
                'description' => 'Reliable tug boat support for vessel maneuvering, towing, berthing and safe maritime operations within port areas.',
                'image' => '/images/tug-boat2.jpg',
                'sort_order' => 5,
            ],
            [
                'category' => 'Heavy Equipment',
                'name' => 'Crane',
                'units' => '7',
                'description' => 'Heavy lifting equipment supporting cargo loading, unloading and material handling across operational and port facilities.',
                'image' => '/images/cranes.jpg',
                'sort_order' => 6,
            ],
            [
                'category' => 'Heavy Equipment',
                'name' => 'Excavator',
                'units' => '7',
                'description' => 'Powerful excavation equipment used for earthwork, dredging support, material handling and construction activities.',
                'image' => '/images/excavator.jpg',
                'sort_order' => 7,
            ],
            [
                'category' => 'Heavy Equipment',
                'name' => 'Payloader',
                'units' => '5',
                'description' => 'Wheel loaders supporting efficient loading, stockpiling and movement of bulk materials across operational sites.',
                'image' => '/images/payloader.jpg',
                'sort_order' => 8,
            ],
            [
                'category' => 'Heavy Equipment',
                'name' => 'Dump Truck',
                'units' => '60',
                'description' => 'Heavy-duty dump trucks supporting the transportation of bulk materials, aggregates and cargo across operational sites.',
                'image' => '/images/dump-truck.jpg',
                'sort_order' => 9,
            ],
            [
                'category' => 'Marine Equipment',
                'name' => 'Dredger',
                'units' => '2',
                'description' => 'Dredging equipment supporting waterway maintenance, sediment removal and marine infrastructure operations.',
                'image' => '/images/Dredger.jpg',
                'sort_order' => 10,
            ],
            [
                'category' => 'Scale',
                'name' => 'Bridge Scale',
                'units' => null,
                'description' => 'Accurately measures the weight of trucks and cargo, ensuring efficient and transparent weighing operations for bulk materials and goods.',
                'image' => '/images/bridge scale.jpg',
                'sort_order' => 11,
            ],
        ];

        foreach ($equipments as $equipment) {
            WebsiteServiceEquipment::updateOrCreate(
                [
                    'sort_order' => $equipment['sort_order'],
                ],
                $equipment + ['status' => true]
            );
        }
    }
}