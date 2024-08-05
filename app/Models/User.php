<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

use App\Models\WorkingTime;
use Carbon\Carbon;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

   public function seedWorkingTimes()
{
    // Sử dụng Carbon::now() nếu created_at là null
    $createDate = $this->created_at ? $this->created_at->startOfDay() : Carbon::now()->startOfDay();

    $this->seedWorkingDaysForMonth($createDate);
    $this->seedWorkingDaysForMonth(Carbon::today()->addMonth()->startOfMonth());
}

private function seedWorkingDaysForMonth(Carbon $startOfMonth)
{
    $endOfMonth = $startOfMonth->copy()->endOfMonth();

    // Sử dụng created_at nếu nó là cùng tháng, nếu không thì bắt đầu từ đầu tháng
    $startDate = $this->created_at && $this->created_at->isSameMonth($startOfMonth) ? $this->created_at->startOfDay() : $startOfMonth;

    for ($date = $startDate; $date->lte($endOfMonth); $date->addDay()) {
        if ($date->isWeekend()) {
            continue;
        }
        WorkingTime::firstOrCreate([
            'user_id' => $this->id,
            'date_checkin' => $date->toDateString()
        ]);
    }
}

}