<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transactions extends Model
{
    /**
     * Get the client of the transaction.
     */
    public function post()
    {
        return $this->belongsTo('App\Clients');
    }
}
