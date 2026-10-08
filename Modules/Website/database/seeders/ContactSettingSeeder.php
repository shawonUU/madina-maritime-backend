<?php

namespace Modules\Website\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Website\App\Models\ContactSetting;

class ContactSettingSeeder extends Seeder
{
    public function run(): void
    {
        ContactSetting::updateOrCreate(
            ['id' => 1],
            [
                'hero_label' => 'Get In Touch',
                'hero_title' => "Let's start a conversation.",
                'hero_highlight' => 'We are here to help',
                'hero_description' => 'Have a question, business inquiry, or need more information about our services? Get in touch with our team and we will be happy to assist you.',
                'hero_image' => '/images/Picture4.png',
                'hero_button_text' => 'Contact Us',
                'hero_button_url' => '#contact-form',

                'bottom_caption' => 'Connecting Business Through The Sea',

                'address_label' => 'Our Location',
                'office_title' => 'Head Office',
                'address' => 'Madina Square, 64/A Shahid Buddhijibi Monir Chowdhury Sharak (Central Road), Dhaka-1205, Bangladesh',

                'phone_label' => 'Call Us',
                'phone_title' => 'Office: 88 (0222) 3363531, 3368840 Ext :385,HP: +8801730-702927',
                'phone_description' => 'Our team is available to assist you.',
                
                'email_label' => 'Email Us',
                'email' => 'operation.head@madina.co',

                'hours_label' => 'Working Hours',
                'working_days' => 'Sunday – Thursday',
                'working_hours' => '9:00 AM – 6:00 PM',

                'form_label' => 'Send Us a Message',
                'form_title' => 'Let’s Talk',
                'form_description' => 'Fill out the form below and our team will get back to you as soon as possible.',

                'map_title' => 'Find Us',
                'map_embed_url' => 'https://www.google.com/maps?q=Madina%20Square%2C%20Dhaka&output=embed',

                'status' => 1,
            ]
        );
    }
}