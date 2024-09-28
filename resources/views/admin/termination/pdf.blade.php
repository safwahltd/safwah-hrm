<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Termination Letter</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.5; }
        h1 { text-align: center; }
        .content { margin: 0 auto; width: 80%; }
        .signature { margin-top: 50px; }
    </style>
</head>
<body>
    <div class="content">
        <div class="">
            <img class="img-responsive" width="200" src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('admin/assets/Safwah-Limited-logo.webp'))) }}" alt="">
        </div>
        <p>Confidence Center, Building-2, 10B, Shahjadpur, Gulshan-2, Dhaka, Bangladesh</p>

        <h2 align="center">Termination Letter</h2>
        <p><span style="font-weight: bold">Date: </span>{{ now()->format('d M, Y') }}</p>

        <p>To,</p>
        <p>{{ $termination->employee->name }}<br>
            <span style="font-weight: bold">Employee ID: </span>{{ $termination->employee->userInfo->employee_id }}<br>
            <span style="font-weight: bold">Department: </span>{{ $termination->employee->userInfo->designations->department->department_name }}</p>

        <p>Dear {{ $termination->employee->name }},</p>

        <p>We regret to inform you that your employment with {{ config('app.name') }} is being terminated effective immediately.</p>

        <p><span style="font-weight: bold">Reason for Termination: </span>{{ $termination->reason }}</p>

        <p>{{ $termination->details }}</p>

        <p>Please return all company property in your possession before your departure. We wish you the best of luck in your future endeavors.</p>

        <div class="signature">
            <p>Sincerely,</p>
            <p>{{ config('app.name') }}</p>
            <p>HR Department</p>
        </div>
    </div>
</body>
</html>

