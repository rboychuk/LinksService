<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Link extends Model
{

    public function sites()
    {
        $this->belongsTo('App\Site','site_id');
    }


}
