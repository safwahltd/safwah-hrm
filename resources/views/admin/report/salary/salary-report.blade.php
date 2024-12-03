<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salary Report</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.5;font-size: 15px; }
        h1 { text-align: center; }
        .content { margin: 0 auto; width: 90%; }
        .signature { margin-top: 50px; }
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }
        @media only screen and (max-width: 600px) {
            * {
                font-size: 10px;
            }
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
<div class="content">
    @forelse($monthlyReport as $year => $months)
    <div class="row" style="margin-top: 4px;">
        <div class="" style="background-color: #00a686; color: white">
            <h5 align="center" style="padding: 3px; text-transform: uppercase;">Salary Report For {{ $year }}</h5>
        </div>
        @foreach($months as $month => $salaries)
        <table style="width:100% ; text-align: center ;margin-bottom: 4px">
            <tr>
                <th colspan="5"><h5 style="margin: 0 ; padding: 6px; text-transform: uppercase;" align="center">{{ $month }} {{ $year }}</h5></th>
            </tr>
            <tr style="background-color: #5c636a; font-size: 10px; color: white; text-transform: uppercase;">
                <th>SL</th>
                <th>Name</th>
                <th>Employee ID</th>
                <th>Designation</th>
                <th>Total Salary</th>
            </tr>
            @php
                $salaryTotal = 0;
            @endphp
            @foreach($salaries as $salary)
                <tr style="font-size: 10px;">
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $salary['employee_name'] }}</td>
                    <td>{{ $salary['employee_id'] }}</td>
                    <td>{{ $salary['employee_designation'] }}</td>
                    @php
                        $allowance = $salary['house_rent'] + $salary['medical_allowance'] + $salary['conveyance_allowance'] + $salary['others'] + $salary['mobile_allowance'] + $salary['bonus'] + $salary['pay'];
                        $deduct = $salary['meal_deduction'] + $salary['income_tax'] + $salary['other_deduction'] + $salary['attendance_deduction'] + $salary['deduct'];
                    @endphp
                    <td>{{ $s = ($salary['basic_salary'] + $allowance) - $deduct }}</td>
                </tr>
                @php
                    $salaryTotal = $salaryTotal + $s;
                @endphp
            @endforeach
            <tr>
                <td colspan="4" align="center" style="font-weight: bold; font-size: 10px;">Total</td>
                <td style="font-weight: bold; font-size: 10px;"> {{$salaryTotal}}</td>
            </tr>
        </table>
        @endforeach
    </div>
    @empty
        <div class="row">
            <div class="">
                <h4 align="center">Salary Report</h4>
            </div>
            <table style="width:100% ; text-align: center">
                <tr style="background-color: aliceblue">
                    <th>SL</th>
                    <th>Employee ID</th>
                    <th>Name</th>
                    <th>Base Salary</th>
                    <th>Allowance</th>
                    <th>Deduction</th>
                    <th>Total Salary</th>
                </tr>
                <tr>
                        <td colspan="7">No Data Found</td>
                    </tr>

            </table>
        </div>
    @endforelse

    @if($monthlyReport)
    <div class="floating-button">
        <form action="{{ route('admin.download.salary.report') }}" method="get">
            @csrf
            <input type="hidden" name="month" value="{{$mon}}">
            <input type="hidden" name="year" value="{{$yr}}">
            <button class="btn btn-black" style="position: absolute; bottom: 0px; right: 0;">Download</button>
        </form>
    </div>
    @endif
</div>
</body>
</html>


