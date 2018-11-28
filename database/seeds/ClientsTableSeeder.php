<?php

use Illuminate\Database\Seeder;

class ClientsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Client::class,25)->create()->each(function($client){
        	for($i=1;$i<10;$i++){
        		$client->transactions()->save(factory(App\Transaction::class)->make());
        	}
        });
    }
}
