<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Zero extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'zeros';

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
    protected $fillable = ['ethereum_address', 'user_id'];

    
}
