<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $table = 'article';
    protected $primaryKey = 'art_id';
    protected  $guarded = [];
    public $timestamps = false;
}


//APP_DEBUG=false
//APP_LOG_LEVEL=debug
//APP_URL=http://bxu2442540273.my3w.com
//
//DB_CONNECTION=mysql
//DB_HOST=bdm262241111.my3w.com
//DB_PORT=3306
//DB_PREFIX=blog_
//DB_DATABASE=bdm262241111_db
//DB_USERNAME=root
//DB_PASSWORD=xz13762355790