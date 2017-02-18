<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class links extends Model
{
    protected $table = 'links';
    protected $primaryKey = 'link_id';
    protected  $guarded = [];
    public $timestamps = false;
}
