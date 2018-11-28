<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    /**
     * Get all the transactions of the client.
     */
    public function transactions()
    {
        return $this->hasMany('App\Transaction');
    }

    public function createManyTransactions(array $tranactions)
    {
    	foreach ($tranactions as $tranaction) {
    		$this->transactions = $tranaction;
    		$this->save();
    	}
    }
}
