<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$notice->title}}</title>
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
        <p style="font-weight: bold">Subject : {{ $notice->title }}</p>
        <p align="justify">{{ $notice->content }}</p><br>
        <address style="font-family: 'Arial Black', sans-serif; line-height: 1.5;">
            Regards & Thanks <br>
            {{ $notice->user->userInfo->designations->name ?? 'Managing Director' }}<br>
            Shahjadpur,Gulsan-2,Confidence Center,Dhaka-1212,Bangladesh<br>
            info@safwahltd.com<br>
        </address>
    </div>
</div>
</div>
</body>
</html>


