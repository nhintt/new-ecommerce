<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserMailChimpModel extends Model
{
    public $timestamps = false; //set time to false
    protected $fillable = [
    	'customer_email','customer_name','customer_phone'
    ];
    protected $primaryKey = 'customer_id';
    protected $table = 'tbl_customers';

}
