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
        //validation on the request
        $validatedData = $request->validate([
            'first_name'=>'required',
            'last_name'=>'required',
            'email'=>'required|unique:clients',
            'avatar'=>'required'
        ]);
        $data = $request->all();
        //create new client instance 
        $client = new Clients();
        //assign
        $client->first_name = $data['first_name'];
        $client->last_name = $data['last_name'];
        $client->email = $data['email'];
        $client->avatar = $client->first_name.$client->last_name.time().'.png';

        //crop and save file
        $img = Image::make(file_get_contents($data['avatar']));
        $img->resize(100, 100);
        $img->save(public_path().'/storage/avatars/'.$client->avatar);

        $client->save();

        return $client;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Clients  $clients
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Clients::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Clients  $clients
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $client = Clients::find($id);
        //validation on the request
        $validatedData = $request->validate([
            'first_name'=>'required',
            'last_name'=>'required',
            'email'=>'required|email|unique:clients,email,'.$id,
            'avatar'=>'required'
        ]);
        $data = $request->all();
        //assign
        $client->first_name = $data['first_name'];
        $client->last_name = $data['last_name'];
        $client->email = $data['email'];
        if(strpos($data['avatar'], 'data:image')){
            $client->avatar = $client->first_name.$client->last_name.time().'.png';
            //crop and save file
            $img = Image::make(file_get_contents($data['avatar']));
            $img->resize(100, 100);
            $img->save(public_path().'/storage/avatars/'.$client->avatar);
        }
        $client->save();

        return $client;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Clients  $clients
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //check if client exists
        $client = Clients::find($id);
        if(!$client){
            return response('Cannot find client with id:'.$id,422);
        }
        
        Clients::destroy($id);
        return $client;
    }
}
