<?php

namespace App\Http\Controllers\Api;

use App\Clients;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\ImageManagerStatic as Image;


class ClientsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients = Clients::paginate(15);
        return response($clients);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $a = Image::make(file_get_contents($data['avatar']))->save(public_path().'/storage/asddadafadasdwdasd.png');
        dd($a);
        // if($request->hasFile('avatar')) {

        //     $image       = $request->file('avatar');
        //     $filename    = $image->getClientOriginalName();

        //     $image_resize = Image::make($image->getRealPath());              
        //     $image_resize->resize(300, 300);
        //     $image_resize->save(public_path('images/ServiceImages/' .$filename));
        //     dd('asdasd');
        // }
        dd('asdasdasdasss');
        $data['avatar']->move(public_path('storage/avatars'),'test');

        $client = new Clients;
        $client->first_name = $data['first_name'];
        $client->last_name = $data['last_name'];
        $client->email = $data['email'];

        //TODO validation on client


        $client->save();

        return $client;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Clients  $clients
     * @return \Illuminate\Http\Response
     */
    public function show(Clients $clients)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Clients  $clients
     * @return \Illuminate\Http\Response
     */
    public function edit(Clients $clients)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Clients  $clients
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Clients $clients)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Clients  $clients
     * @return \Illuminate\Http\Response
     */
    public function destroy(Clients $clients)
    {
        //
    }
}
