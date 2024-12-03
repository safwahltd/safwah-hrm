<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asset Report</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.5;font-size: 15px; }
        h1 { text-align: center; }
        .content { margin: 0 auto; width: 100%; }
        .signature { margin-top: 50px; }
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }
    </style>
    <style>
        .floating-button {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 1000; /* Ensure it stays above other content */
        }

        .floating-button .btn {
            background-color:  black; /* Bootstrap primary color */
            color: white;
            padding: 15px 20px;
            border-radius: 50px; /* Makes it look like a pill */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            text-align: center;
            text-decoration: none;
        }

        .floating-button .btn:hover {
            background-color: black; /* Darker shade on hover */
            text-decoration: none;
        }
    </style>

</head>
<body>
<div class="">
    <div class="row" style="margin-top: 4px;">
        <div style="border-top: 1px solid black; border-left: 1px solid #000000; border-right: 1px solid black; margin:0;">
            <h4 style="padding:10px; margin: 0" align="center">Asset Report</h4>
        </div>
        <table style="width:100% ; text-align: center ;margin-bottom: 4px">
            <tr style="background-color: #5c636a; color: white; font-size: 10px; text-transform: uppercase">
                <th>SL</th>
                <th>Name</th>
                <th>Id</th>
                <th>Designation</th>
                <th>Asset Name</th>
                <th>Asset Id</th>
                <th>Condition</th>
                <th>Hand In</th>
                <th>Hand Over</th>
                <th>Status</th>
            </tr>
            @foreach($assets as $asset)
                <tr style="font-size: 10px">
                    <td align="center"><span class="fw-bold">{{$loop->iteration}}</span></td>
                    <td align="center"><span class="fw-bold">{{$asset->user->name}}</span></td>
                    <td align="center"><span class="fw-bold">{{$asset->user->userInfo->employee_id}}</span></td>
                    <td align="center"><span class="fw-bold">{{$asset->user->userInfo->designations->name}}</span></td>
                    <td align="center"><span class="fw-bold">{{$asset->asset_name}}</span></td>
                    <td align="center"><span class="fw-bold">{{$asset->asset_id}}</span></td>
                    <td align="center"><span class="fw-bold">{{$asset->condition}}</span></td>
                    <td align="center"><span class="fw-bold">{{$asset->hand_in_date}}</span></td>
                    <td align="center"><span class="fw-bold">{{$asset->hand_over_date ?? 'Running'}}</span></td>
                    <td align="center"><span class="fw-bold">{{$asset->status == 1 ? 'Active':'Inactive'}}</span></td>
                </tr>
            @endforeach
        </table>
    </div>
</div>
</body>
</html>




