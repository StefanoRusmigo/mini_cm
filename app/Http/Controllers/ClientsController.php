<?php

namespace App\Http\Controllers;

use App\Clients;
use View;


class ClientsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return View('clients.index');
    }
}
