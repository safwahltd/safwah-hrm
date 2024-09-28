<?php

namespace App\Console\Commands;

use App\Models\UserInfos;
use Illuminate\Console\Command;

class ManageLeaveHalfDay extends Command
{
    protected $signature = 'app:manage-leave-half-day';
    protected $description = 'Command description';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Reset half-day leave counts at the start of each month
        UserInfos::query()->update([
            'half_day_leave' => 2,
        ]);
    }
}
