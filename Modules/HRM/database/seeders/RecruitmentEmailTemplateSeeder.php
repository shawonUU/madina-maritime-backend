<?php

namespace Modules\HRM\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\HRM\App\Models\RecruitmentEmailTemplate;

class RecruitmentEmailTemplateSeeder extends Seeder
{
    public function run(): void
    {
        $templates = [
            [
                'name' => 'Application Received',
                'code' => 'application_received',
                'subject' => 'Application Received - {{job_title}}',
                'body' => '
                    <p>Dear {{applicant_name}},</p>

                    <p>
                        Thank you for applying for the
                        <strong>{{job_title}}</strong>
                        position at Madina Maritime Ltd.
                    </p>

                    <p>
                        Your application has been successfully received.
                    </p>

                    <p>
                        <strong>Application No:</strong>
                        {{application_no}}
                    </p>

                    <p>
                        Our HR team will review your application and
                        contact you if you are selected for the next stage.
                    </p>

                    <p>
                        Regards,<br>
                        HR Department<br>
                        Madina Maritime Ltd.
                    </p>
                ',
            ],

            [
                'name' => 'Application Shortlisted',
                'code' => 'shortlisted',
                'subject' => 'Application Shortlisted - {{job_title}}',
                'body' => '
                    <p>Dear {{applicant_name}},</p>

                    <p>
                        We are pleased to inform you that your application
                        for the position of
                        <strong>{{job_title}}</strong>
                        has been shortlisted.
                    </p>

                    <p>
                        Our HR team will contact you regarding the next
                        stage of the recruitment process.
                    </p>

                    <p>
                        <strong>Application No:</strong>
                        {{application_no}}
                    </p>

                    <p>
                        Regards,<br>
                        HR Department<br>
                        Madina Maritime Ltd.
                    </p>
                ',
            ],

            [
                'name' => 'Interview Invitation',
                'code' => 'interview',
                'subject' => 'Interview Invitation - {{job_title}}',
                'body' => '
                    <p>Dear {{applicant_name}},</p>

                    <p>
                        We are pleased to inform you that you have been
                        shortlisted for an interview for the position of
                        <strong>{{job_title}}</strong>.
                    </p>

                    <p>
                        <strong>Interview Date:</strong>
                        {{interview_date}}
                    </p>

                    <p>
                        <strong>Interview Time:</strong>
                        {{interview_time}}
                    </p>

                    <p>
                        <strong>Interview Type:</strong>
                        {{interview_mode}}
                    </p>

                    <p>
                        <strong>Location:</strong>
                        {{interview_location}}
                    </p>

                    <p>
                        <strong>Meeting Link:</strong>
                        {{meeting_link}}
                    </p>

                    <p>
                        {{interview_note}}
                    </p>

                    <p>
                        Regards,<br>
                        HR Department<br>
                        Madina Maritime Ltd.
                    </p>
                ',
            ],

            [
                'name' => 'Selection',
                'code' => 'selected',
                'subject' => 'Congratulations - Selected for {{job_title}}',
                'body' => '
                    <p>Dear {{applicant_name}},</p>

                    <p>
                        We are pleased to inform you that you have been
                        selected for the position of
                        <strong>{{job_title}}</strong>
                        at Madina Maritime Ltd.
                    </p>

                    <p>
                        Our HR team will contact you regarding the next
                        steps and joining formalities.
                    </p>

                    <p>
                        Congratulations and welcome to the team.
                    </p>

                    <p>
                        Regards,<br>
                        HR Department<br>
                        Madina Maritime Ltd.
                    </p>
                ',
            ],

            [
                'name' => 'Rejection',
                'code' => 'rejected',
                'subject' => 'Application Update - {{job_title}}',
                'body' => '
                    <p>Dear {{applicant_name}},</p>

                    <p>
                        Thank you for your interest in the
                        <strong>{{job_title}}</strong>
                        position at Madina Maritime Ltd.
                    </p>

                    <p>
                        After careful consideration, we regret to inform
                        you that your application has not been selected
                        for the current position.
                    </p>

                    <p>
                        We appreciate the time and effort you invested in
                        the recruitment process and wish you success in
                        your future career.
                    </p>

                    <p>
                        Regards,<br>
                        HR Department<br>
                        Madina Maritime Ltd.
                    </p>
                ',
            ],
        ];

        foreach ($templates as $template) {
            RecruitmentEmailTemplate::updateOrCreate(
                [
                    'code' => $template['code'],
                ],
                [
                    'name' => $template['name'],
                    'subject' => $template['subject'],
                    'body' => $template['body'],
                    'is_active' => true,
                ]
            );
        }
    }
}