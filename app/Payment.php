<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\UserRef;

class Payment extends Model
{

    protected $table = 'payments';

    public const REF_APP = 'app-fee';
    public const REF_FIRE = 'fire-fee';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'flower_root_ref_id', 'week', 'stripe_payment_intent_id', 'amount', 'amount_received', 'ref'
    ];

    public function user() {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function flowerRootUserRef() {
        return $this->belongsTo('App\UserRef', 'flower_root_ref_id', 'id');
    }
}
