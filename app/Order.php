<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
		// protected $fillable = ['user_id', 'total_price', 'address'];
		protected $fillable = ['user_id','total_price'];
}
