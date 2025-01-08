<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Termination Letter</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.5; }
        h1 { text-align: center; }
        .content { margin: 0 auto; width: 90%; }
        .signature { margin-top: 50px; }
    </style>
</head>
<body>
    <div class="content">
        <div class="">
            <img class="img-responsive" width="150px" src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('admin/assets/Safwah-Limited-logo.webp'))) }}" alt="">
        </div>
        <p style="font-size: 10px;">Confidence Center, Building-2, 10B, Shahjadpur, Gulshan-2, Dhaka, Bangladesh</p>

        <h3 align="center">Termination Letter</h3>
        <p><span style="font-weight: bold">Date: </span>{{ now()->format('d M, Y') }}</p>

        <p>To,</p>
        <p>{{ $termination->employee->name }}<br>
            <span style="font-weight: bold">ID: </span>{{ $termination->employee->userInfo->employee_id }}<br>
            <span style="font-weight: bold">Department: </span>{{ $termination->employee->userInfo->designations->department->department_name }}</p>

        <p>Dear {{ $termination->employee->name }},</p>


        <p>{{ $termination->reason }}</p>

        <p>{{ $termination->details }}</p>

        <div class="signature">
            <p>Sincerely,</p>
            <p>{{ $termination->terminatedBy->name }}</p>
            <p>{{ $termination->terminatedBy->userInfo->designations->department->department_name }}</p>
        </div>
    </div>
</body>
</html>

