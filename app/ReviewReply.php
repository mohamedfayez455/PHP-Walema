<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReviewReply extends Model
{
    protected $fillable = ['review_id' , 'supplier_id' , 'body'];
}
