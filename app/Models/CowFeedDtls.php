<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CowFeedDtls extends Model
{
	protected $table = "cow_feed_dtls";
    protected $fillable = [
        'feed_id', 'item_id', 'qty', 'unit_id','time'
    ];
}
