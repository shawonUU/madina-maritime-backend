<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">

    <title>Application Update</title>
</head>

<body style="margin:0; padding:0; background:#f5f7fa; font-family:Arial,sans-serif;">

<div style="max-width:650px; margin:40px auto; background:#ffffff; padding:35px; border-radius:12px;">

    <h2 style="color:#06245a; margin-top:0;">
        Application Update
    </h2>

    <p>
        Dear {{ $application->name }},
    </p>

    <p>
        Thank you for applying for the
        <strong>{{ $application->jobPost->title }}</strong>
        position.
    </p>

    <p>
        Your application status is now:
    </p>

    <div style="
        padding:15px;
        background:#f1f5f9;
        border-radius:8px;
        font-size:18px;
        font-weight:bold;
        color:#06245a;
    ">
        {{ $application->status }}
    </div>

    <p style="margin-top:25px;">
        Application No:
        <strong>{{ $application->application_no }}</strong>
    </p>

    @if($application->hr_note)
        <p>
            <strong>Message from HR:</strong>
        </p>

        <p>
            {{ $application->hr_note }}
        </p>
    @endif

    <p>
        We appreciate your interest in joining our team.
    </p>

    <p>
        Regards,<br>
        HR Department<br>
        Madina Group
    </p>

</div>

</body>
</html>