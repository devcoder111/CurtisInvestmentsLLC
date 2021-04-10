<?php

namespace App;

use App\UserRef;
use Illuminate\Database\Eloquent\Model;

class Flower extends Model
{

    protected $table = 'flowers';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'current_week', 'enter_payment', 'accumulated_payments', 'root_user_ref_id'
    ];

    public function flowerRoot() {
        return $this->hasOne('App\UserRef', 'id', 'root_user_ref_id');
    }

    public function getUsers() {
        $rootRef = $this->flowerRoot()->first();
        if (!$rootRef) return collect([]);

        return UserRef::with('user')->whereNotNull('user_id')->descendantsAndSelf($rootRef->id);
    }

    public static function initFlower() {
        $flower = Flower::query()->first();

        if (!$flower) {
            $userRef = new UserRef();
            $userRef->save();

            $flower = new Flower(['root_user_ref_id' => $userRef->id]);
            $flower->save();
        }
    }
}
