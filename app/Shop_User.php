<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Shop_User extends Model
{
    use SoftDeletes;

    protected $table = 'shop_user';

    protected $fillable = [
        'shop_id', 'user_id',
    ];

}