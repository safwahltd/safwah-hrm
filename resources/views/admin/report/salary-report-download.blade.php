<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salary Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.5;
            font-size: 15px;
        }
        h1 { text-align: center; }
        .content { margin: 0 auto; width: 90%; }
        .signature { margin-top: 50px; }
        table,th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }
    </style>
</head>
<body>
<div class="">
    @foreach($monthlyReport as $year => $months)
        <div class="row" style="margin-bottom: 4px">
            <div class="">
                <h4 align="center">Salary Report For {{ $year }}</h4>
            </div>
            @foreach($months as $month => $salaries)
                <table style="width:100% ; text-align: center; margin-bottom: 5px">
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
                        <td>Total : {{$salaryTotal}}</td>
                    </tr>
                </table>
            @endforeach
        </div>
    @endforeach
</div>
</body>
</html>



