<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Clients extends Model
{
    /**
     * Get all the transactions of the client.
     */
    public function comments()
    {
        return $this->hasMany('App\Transactions');
    }
}
