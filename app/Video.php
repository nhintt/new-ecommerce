<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    public $timestamps = false; //set time to false
    protected $fillable = [
    	'video_title', 'video_link','video_desc'
    ];
    protected $primaryKey = 'video_id';
 	protected $table = 'tbl_videos';
}
