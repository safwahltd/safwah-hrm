<?php

namespace App\Exports;

use App\Models\Attendance;
use App\Models\User;
use Carbon\CarbonPeriod;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AttendanceExport implements WithTitle,FromCollection,WithHeadings,WithMapping
{
    protected $month;
    protected $year;
    protected $day;
    protected $daysInMonth;

    public function __construct($year,$month,$day)
    {
        $this->year = $year;
        $this->month = $month;
        $this->day = $day;
        $this->daysInMonth = Carbon::createFromDate($year, $month, 1)->daysInMonth;
    }

    public function collection()
    {
        $report = collect();

        $users = User::whereNotIN('id',[1])->get();
        foreach ($users as $user) {
            $userData = [
                'user' => $user->name,
            ];
            // Loop through each day of the month
            for ($day = 1; $day <= $this->daysInMonth; $day++) {
                $date = Carbon::create($this->year, $this->month, $day)->format('Y-m-d');
                // Fetch attendance for the user on a specific day
                $attendance = Attendance::where('user_id', $user->id)
                    ->whereDate('clock_in_date', $date)
                    ->first();
                // If there's no attendance, set clock in/out to 'N/A'
                if ($attendance) {
                    $clockIn = Carbon::parse($attendance->clock_in)->format('h:i A');
                    $clockOut = Carbon::parse($attendance->clock_out)->format('h:i A');
                    $userData["day_$day"] = $clockIn . ' / ' . $clockOut;
                } else {
                    $userData["day_$day"] = 'N/A';
                }
            }
            // Add the user row to the report collection
            $report->push((object) $userData);
        }
        return $report;
    }

    public function headings(): array
    {
        $headings = ['User Name'];
        // Add a heading for each day of the month
        for ($day = 1; $day <= $this->daysInMonth; $day++) {
            $date = Carbon::create($this->year, $this->month, $day)->format('Y-m-d');
            $headings[] = "$date (In / Out)";
        }
        return $headings;
    }

    public function map($row): array
    {
        // Map user and their attendance data for each day
        $mapped = [$row->user];

        for ($day = 1; $day <= $this->daysInMonth; $day++) {
            $mapped[] = $row->{"day_$day"} ?? '';
        }

        return $mapped;
    }
    public function title(): string
    {
        return 'Attendance Report - ' . Carbon::createFromDate($this->year, $this->month)->format('M Y');
    }
}
