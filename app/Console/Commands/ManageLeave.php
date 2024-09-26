<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\UserInfos;

class ManageLeave extends Command
{
    protected $signature = 'app:manage-leave';
    protected $description = 'Command description';

    public function __construct()
    {
        parent::__construct();
    }
    public function handle()
    {
// Reset sick and casual leave balances at the start of each year
            UserInfos::query()->update([
                'sick_leave' => 10,
                'casual_leave' => 10,
            ]);
    }
}
