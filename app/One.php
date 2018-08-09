<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class One extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'ones';

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
    protected $fillable = ['name', 'user_id', 'street', 'city', 'zip', 'state', 'country', 'ip'];

    
}