<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
      protected $guarded=['id'];

       public function shop(){
        return $this->belongsTo('App\Shop','shop_id','id');
      }



}


