<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;

class AttendanceExport implements FromCollection
{
    protected $month;
    protected $year;
    protected $day;

    public function __construct($year,$month,$day)
    {
        $this->year = $year;
        $this->month = $month;
        $this->day = $day;
    }

    public function collection()
    {
        // Fetch users with their attendance for the specified month and year
        return User::select('id', 'name')->with(['attendances' => function ($query) {
            $query->select('user_id', 'clock_in', 'clock_out')
                ->whereYear('clock_in', $this->year)
                ->whereMonth('clock_in', $this->month);
            if ($this->day != '') {
                $query->whereDay('clock_in', $this->day);
            }
        }])->get();
    }

    public function headings(): array
    {
        $daysInMonth = Carbon::create($this->year, $this->month)->daysInMonth;
        $dates = [];

        for ($day = 1; $day <= $daysInMonth; $day++) {
            $dates[] = Carbon::create($this->year, $this->month, $day)->toDateString();
        }

        return array_merge(['User'], $dates);
    }

    public function map($user): array
    {
        $daysInMonth = Carbon::create($this->year, $this->month)->daysInMonth;
        $row = [$user->name];

        for ($day = 1; $day <= $daysInMonth; $day++) {
            $date = Carbon::create($this->year, $this->month, $day)->toDateString();
            $attendance = $user->attendances->firstWhere('clock_in', $date);

            if ($attendance) {
                $row[] = 'In: ' . Carbon::parse($attendance->clock_in)->format('H:i') . ', Out: ' . Carbon::parse($attendance->clock_out)->format('H:i');
            } else {
                $row[] = '-';
            }
        }

        return $row;
    }
}
