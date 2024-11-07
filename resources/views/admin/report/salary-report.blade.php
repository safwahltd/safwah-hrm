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
        <div class="">
            <h4 align="center">Salary Report For {{ $year }}</h4>
        </div>
        @foreach($months as $month => $salaries)
        <table style="width:100% ; text-align: center ;margin-bottom: 4px">
            <tr>
                <th colspan="5"><h4 align="center">{{ $month }}</h4></th>
            </tr>
            <tr style="background-color: aliceblue; font-size: 14px">
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
                <tr style="">
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $salary['employee_name'] }}</td>
                    <td>{{ $salary['employee_id'] }}</td>
                    <td>{{ $salary['employee_designation'] }}</td>
                    @php
                        $allowance = $salary['house_rent'] + $salary['medical_allowance'] + $salary['conveyance_allowance'] + $salary['others'] + $salary['mobile_allowance'] + $salary['bonus'];
                        $deduct = $salary['meal_deduction'] + $salary['income_tax'] + $salary['other_deduction'] + $salary['attendance_deduction'];
                    @endphp
                    <td>{{ $s = ($salary['basic_salary'] + $allowance) - $deduct }}</td>
                </tr>
                @php
                    $salaryTotal = $salaryTotal + $s;
                @endphp
            @endforeach
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td style="font-weight: bold">Total : {{$salaryTotal}}</td>
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


