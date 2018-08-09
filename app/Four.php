<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Four extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'fours';

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
    protected $fillable = ['email_address', 'name', 'university_email_address', 'university_website', 'undergraduate_major', 'graduation_year', 'university_ambassadors', 'ethereum_address', 'terms_and_privacy_policy', 'user_id', 'ip'];

    
}
