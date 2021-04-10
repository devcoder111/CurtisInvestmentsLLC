<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Cashier\Billable;

class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;
    use Billable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'country_code', 'email', 'password', 'unassigned', 'wallet', 'week_joined', 'referrer_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function payments()
    {
        return $this->hasMany('App\Payment');
    }

    public static function readablePosition($week, $position) {
        $pos = abs($week - $position - 1);
        switch ($pos) {
            case 0:
                return 'Water';
            case 1:
                return 'Earth';
            case 2:
                return 'Air';
            case 3:
                return 'Fire';
        }
        return '';
    }

    public function getFriendlyRoleAttribute() {
        $role = $this->roles()->first();
        if (!$role) return 'User';

        switch ($role->name) {
            case 'admin':
                return 'Admin';
            case 'members-rel-rep':
                return 'Member Relations Rep';
            default:
                return 'User';
        }
    }

    public function requiresAppPayment() {
        $currentWeek = Flower::find(1)->current_week;
        if ($currentWeek == null) {
            return true;
        } else {
            $userWeekJoined = $this->week_joined ? $this->week_joined : 1;
            return (($currentWeek - $userWeekJoined) % 4 == 0);
        }
    }

    public function hasPayment($week = null, $ref = 'app-fee') {
        return $this->payments()
            ->where('week', '=', $week)
            ->where('ref', '=', $ref)->get()
            ->count() == 1;
    }
}
