<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Three extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'threes';

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
    protected $fillable = ['phone_number', 'code', 'user_id', 'code'];

    
}
