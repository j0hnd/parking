<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Messages extends Model
{
    protected $fillable = [
            'subject',
            'booking_id',
            'drop_off',
            'order',
            'name',
            'status'
    ];

    public function booking()
    {
        $this->hasOne(Bookings::class, 'booking_id', 'id');
    }

    public function get_day_name($timestamp) {
	    $date = date('d/m/Y', $timestamp);

	    if($date == date('d/m/Y')) {
	      $date = 'Today';
	    }
	    else if($date == date('d/m/Y',strtotime(now()) - (24 * 60 * 60))) {
	      $date = 'Yesterday';
	    }
	    return $date;
	}
}
