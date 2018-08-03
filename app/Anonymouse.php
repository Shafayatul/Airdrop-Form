<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Anonymouse extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'anonymouses';

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
    protected $fillable = ['email', 'ethereum_address', 'privacy', 'type', 'number', 'user_id'];

    
}
