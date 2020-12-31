<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class club extends Model
{
	use SoftDeletes;
    protected $fillable = [
        'club_name','club_banner','club_logo','club_description',
    ];
    protected $dates = ['deleted_at'];
}
