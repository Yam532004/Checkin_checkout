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

        for ($date = $today->copy()->startOfMonth(); $date->lte($endOfMonth); $date->addDay()) {
            if($date->isWeekend()){
                continue;
            }
            foreach($users as $user){
                WorkingTime::firstOrCreate([
                    'user_id' => $user->id,
                    'date_checkin' => $date->toDateString()
                ]);
            }
        }
        $this->info('Working days seeded successfully');
    }
}
