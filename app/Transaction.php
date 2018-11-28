<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
	public $timestamps = false;
    /**
     * Get the client of the transaction.
     */
    public function post()
    {
        return $this->belongsTo('App\Client');
    }
}
