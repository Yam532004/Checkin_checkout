<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\WorkingTime;
use Carbon\Carbon;


class SeedWorkingDays extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'seed:working-days';



    /**
     * The console command description.
     *
     * @var string
     */
    protected $description  = 'Seed working day for all users except weekends';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $users = User::all();
        $today = Carbon::today();
        $endOfMonth = $today->copy()->endOfMonth();

        // Xác định ngày đầu tiên của tháng hiện tại và tháng tiếp theo
        $startOfMonth = $today->copy()->startOfMonth();
        $startOfNextMonth = $endOfMonth->copy()->addDay()->startOfMonth();

        // Sinh dữ liệu cho tháng hiện tại
        for ($date = $startOfMonth; $date->lte($endOfMonth); $date->addDay()) {
            if ($date->isWeekend()) {
                continue;
            }
            foreach ($users as $user) {
                WorkingTime::firstOrCreate([
                    'user_id' => $user->id,
                    'date_checkin' => $date->toDateString()
                ]);
            }
        }

        // Sinh dữ liệu cho tháng tiếp theo
        $endOfNextMonth = $startOfNextMonth->copy()->endOfMonth();
        for ($date = $startOfNextMonth; $date->lte($endOfNextMonth); $date->addDay()) {
            if ($date->isWeekend()) {
                continue;
            }
            foreach ($users as $user) {
                WorkingTime::firstOrCreate([
                    'user_id' => $user->id,
                    'date_checkin' => $date->toDateString()
                ]);
            }
        }

        $this->info('Working days seeded successfully for current and next month');
    }
}
