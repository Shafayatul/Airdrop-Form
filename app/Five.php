<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Five extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'fives';

    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['email_address', 'name', 'video', 'referral_emails', 'ethereum_address', 'user_id'];

    
}
