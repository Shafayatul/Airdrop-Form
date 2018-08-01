<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Two extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'twos';

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
    protected $fillable = ['privacy', 'type', 'number', 'user_id', 'point'];

    
}
