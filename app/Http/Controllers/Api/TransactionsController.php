<?php

namespace App\Http\Controllers\Api;

use App\Transactions;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Client;

class TransactionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $client = Client::find($id);
        if(!$client){
             return response('Cannot find client with id:'.$id,404);
        }

        return $client->transactions()->paginate(10);
    }
}
