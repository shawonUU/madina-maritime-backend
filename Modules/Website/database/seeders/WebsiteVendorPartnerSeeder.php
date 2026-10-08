<?php

namespace Modules\Website\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Website\App\Models\WebsiteVendorPartner;
use Modules\Website\App\Models\WebsiteVendorPartnerPage;
use Modules\Website\App\Models\WebsiteVendorPartnerStat;

class WebsiteVendorPartnerSeeder extends Seeder
{
    public function run(): void
    {
        WebsiteVendorPartnerPage::updateOrCreate(
            ['id' => 1],
            [
                'label' => 'Vendors & Partners',
                'title' => 'Strong partnerships.',
                'highlight' => 'Reliable operations.',
                'description' => 'We work with trusted vendors, suppliers and service partners who help us deliver safe, reliable and efficient maritime operations across Bangladesh.',
                'hero_image' => '/images/ship-new2.jpeg',
                'explore_button_text' => 'Explore Partners',
                'explore_button_url' => '#partners',
                'partner_button_text' => 'Become a Partner',
                'partner_button_url' => '/contact',
                'status' => true,
            ]
        );

        $stats = [
            [
                'value' => '500+',
                'label' => 'Trusted Partners',
                'icon' => 'Handshake',
                'sort_order' => 1,
                'status' => true,
            ],
            [
                'value' => '15+',
                'label' => 'Service Categories',
                'icon' => 'Globe2',
                'sort_order' => 2,
                'status' => true,
            ],
            [
                'value' => '1000+',
                'label' => 'Successful Operations',
                'icon' => 'Ship',
                'sort_order' => 3,
                'status' => true,
            ],
            [
                'value' => '98%',
                'label' => 'Partner Satisfaction',
                'icon' => 'Star',
                'sort_order' => 4,
                'status' => true,
            ],
        ];

        foreach ($stats as $stat) {
            WebsiteVendorPartnerStat::updateOrCreate(
                [
                    'label' => $stat['label'],
                ],
                $stat
            );
        }

        $partners = [
            [
                'name' => 'Fujairah National Quarry (FNQ)',
                'category' => 'Mother Vessel',
                'logo' => '/images/Fujairah National Quarry (FNQ).jpeg',
                'description' => 'Fujairah National Quarry (FNQ), one of its subsidiaries and segregated in 2007 from one of its divisions Fujairah Concrete Products, is its main producer of high quality aggregate and crushed sand producing a total of 2.9 million tonnes of quarry products per annum.',
                'sort_order' => 1,
            ],
            [
                'name' => 'Combined Mining Shipping',
                'category' => 'Mother Vessel',
                'logo' => '/images/Combined Mining Shipping.png',
                'description' => 'Combined Mining and Shipping is a mining and maritime operations company founded in 2010 in Fujairah, United Arab Emirates.',
                'sort_order' => 2,
            ],
            [
                'name' => 'Mashafi Crusher',
                'category' => 'Mother Vessel',
                'logo' => '/images/Masafi Crusher.png',
                'description' => 'Masafi Crusher was founded in 2001 in the Emirate of Fujairah Masafi area and Licensed by the Government of Fujairah Emirate under license number (14721)',
                'sort_order' => 3,
            ],
            [
                'name' => 'South West Mining',
                'category' => 'Mother Vessel',
                'logo' => '/images/South West Mining.jpg',
                'description' => 'South West Mining most prominently refers to South West Mining Limited (SWML) in India',
                'sort_order' => 4,
            ],
            [
                'name' => 'Ali Musa',
                'category' => 'Mother Vessel',
                'logo' => '/images/TDB.png',
                'description' => 'The vessel TDB (IMO 9503811, MMSI 414535000) is a Bulk Carrier built in 2011 and currently sailing under the flag of China.',
                'sort_order' => 5,
            ],
            [
                'name' => 'TDB',
                'category' => 'Mother Vessel',
                'logo' => '/images/SOLE.png',
                'description' => 'The vessel SOLE (IMO 9650145, MMSI 210238000) is a Bulk Carrier built in 2013 and currently sailing under the flag of Cyprus.',
                'sort_order' => 6,
            ],
            [
                'name' => 'Abdur Rashid',
                'category' => 'Mother Vessel',
                'logo' => '/images/New Horizon.png',
                'description' => 'The vessel NEW HORIZON (IMO 9420318, MMSI 538008295) is a Bulk Carrier built in 2010 and currently sailing under the flag of Marshall Islands.',
                'sort_order' => 7,
            ],
            [
                'name' => 'CMH',
                'category' => 'Mother Vessel',
                'logo' => '/images/MV Kosom.png',
                'description' => 'The vessel COSMOS (IMO 9574171, MMSI 538007691) is a Bulk Carrier built in 2010 and currently sailing under the flag of Marshall Islands.',
                'sort_order' => 8,
            ],
            [
                'name' => 'MJL Bangladesh PLC',
                'category' => 'Lubricant',
                'logo' => '/images/MJL Bangladesh PLC.svg',
                'description' => 'MJL Bangladesh PLC is an embodiment of trust when it comes to providing excellence in petroleum products and retaining optimum performance.',
                'sort_order' => 9,
            ],
            [
                'name' => 'Ranks Petroleum Ltd',
                'category' => 'Lubricant',
                'logo' => '/images/Ranks Petroleum Ltd.png',
                'description' => 'Ranks Petroleum Ltd. (RKPL), one of the prominent SBUs of Rancon, has been the Macro Distributor of Shell Lubricants in Bangladesh since 2004.',
                'sort_order' => 10,
            ],
            [
                'name' => 'ACI Motors',
                'category' => 'Tyre',
                'logo' => '/images/ACI Motors.svg',
                'description' => 'ACI Motors Limited provides Complete Farm Mechanization Solution to farmers by offering a wide range of agriculture machineries.',
                'sort_order' => 11,
            ],
            [
                'name' => 'Rahimafrooz Batteries Ltd',
                'category' => 'Battery',
                'logo' => '/images/Rahimafrooz Batteries Ltd.png',
                'description' => 'Rahimafrooz Batteries Ltd. (RBL) is the largest lead-acid battery manufacturer in Bangladesh.',
                'sort_order' => 12,
            ],
            [
                'name' => 'Panna Battery Ltd',
                'category' => 'Battery',
                'logo' => '/images/Panna Battery Ltd.png',
                'description' => 'Panna Battery Ltd.(PBL) is the largest lead-acid battery manufacturer in Bangladesh started its journey 2006 with 5,76,000 Sq. Feet area.',
                'sort_order' => 13,
            ],
            [
                'name' => 'Hamko Corporation',
                'category' => 'Tyre',
                'logo' => '/images/Hamko Corporation.png',
                'description' => 'Become the leading battery manufacturer in Bangladesh and offer other daily life products and solutions to customers with highest quality to make HAMKO a chosen brand name in multiple industries.',
                'sort_order' => 14,
            ],
            [
                'name' => 'Fuch Lubricant',
                'category' => 'Lubricant',
                'logo' => '/images/Fuch Lubricant.png',
                'description' => 'FUCHS is a global lubricant supplier offering automotive lubricants, industrial lubricants, lubricating greases, metal processing lubricants.',
                'sort_order' => 15,
            ],
            [
                'name' => 'Esab Bangladesh',
                'category' => 'Welding Electrodes',
                'logo' => '/images/Esab Bangladesh.webp',
                'description' => 'ESAB is a world leader in welding and cutting equipment and consumables. We offer a complete line of fabrication solutions for virtually every application.',
                'sort_order' => 16,
            ],
            [
                'name' => 'BSRM Wires Ltd',
                'category' => 'Welding Electrodes',
                'logo' => '/images/BSRM Wires Ltd.png',
                'description' => 'BSRM ventured into a new business area as part of continuous innovation philosophy and diversification plan and set up BSRM Wires at Mirsarai.',
                'sort_order' => 17,
            ],
            [
                'name' => 'Elite Paint',
                'category' => 'Marine Paint',
                'logo' => '/images/Elite Paint.png.svg',
                'description' => 'We are proud to offer a comprehensive range of premium paints and coatings that will elevate the beauty and protection of your surfaces.',
                'sort_order' => 18,
            ],
            [
                'name' => 'Berger Bangladesh',
                'category' => 'Marine Paint',
                'logo' => '/images/Berger Bangladesh.png',
                'description' => 'Transform your home with Berger Paints, the best paint company in Bangladesh.',
                'sort_order' => 19,
            ],
            [
                'name' => 'Jotun Bangladesh',
                'category' => 'Marine Paint',
                'logo' => '/images/Jotun Bangladesh.svg',
                'description' => 'As one of the world\'s leading paint and coating manufacturers, Jotun protects all types of property - from iconic buildings to beautiful homes.',
                'sort_order' => 20,
            ],
        ];

        foreach ($partners as $partner) {
            WebsiteVendorPartner::updateOrCreate(
                [
                    'name' => $partner['name'],
                ],
                [
                    ...$partner,
                    'status' => true,
                ]
            );
        }
    }
}