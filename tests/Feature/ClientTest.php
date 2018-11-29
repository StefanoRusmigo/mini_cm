<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Client;

class ClientTest extends TestCase
{
   public function testClientsIndex()
   {
   	$clientsCount = Client::count();
   	$paginationNumber = 10;
   	//get the number of pages
 	$numberOfPages = ($clientsCount/$paginationNumber);
 	//add 1 page if there is a remainder
 	if(($clientRemainder=$clientsCount%$paginationNumber)>0){
 		$numberOfPages++;
 	}

 	//the number of data in each page call for use in the loop
 	$dataReturnedCount = $paginationNumber;
 	//test if pagination is correct by looping through all pages
 	for($i=1;$numberOfPages>$i;$i++){
 		$response = $this->json('GET','api/clients?page='.$i)
   			->assertStatus(200);
   		//if is the last page call change dataReturnCount to the remainder
   		if($numberOfPages==$i){
   			$dataReturnedCount=$clientRemainder;
   		}
   		$this->assertEquals($dataReturnedCount,count((array)$response->original));
 	}

   }

   public function testClientsCreate()
   {
   	//assign this veriable to check after if Client::count incemented
   	$originalClientCount = Client::count();
   	$clientData = [
   		'first_name'=>'foo',
   		'last_name'=>'bar',
   		'email'=>'foo@bar.com',
   		'avatar'=>'data:image/gif;base64,R0lGODlhEAAQAMQAAORHHOVSKudfOulrSOp3WOyDZu6QdvCchPGolfO0o/XBs/fNwfjZ0frl3/zy7////wAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAACH5BAkAABAALAAAAAAQABAAAAVVICSOZGlCQAosJ6mu7fiyZeKqNKToQGDsM8hBADgUXoGAiqhSvp5QAnQKGIgUhwFUYLCVDFCrKUE1lBavAViFIDlTImbKC5Gm2hB0SlBCBMQiB0UjIQA7'
   ];

   	//assert that the client is created with the correct data
   	$response = $this->json('POST','api/clients',$clientData)
   		->assertStatus(201)
   		->assertJson(['first_name'=>'foo','last_name'=>'bar','email'=>'foo@bar.com']);
   	//assert that one more client was created
	$this->assertEquals($originalClientCount+1,Client::count());
   	//assert file was saved in correct path
   	$this->assertFileExists('storage/app/public/avatars/'.$response->original->avatar);
   	//delete the file 
   	unlink('storage/app/public/avatars/'.$response->original->avatar);

   }

   public function testClientsUpdate()
   {
   	$client = Client::first();
   	$clientData = [
   		'first_name'=>'newName',
   		'email'=>'new@email.com'
   	];
   	//assert that the Client's fields were updated with the correct data
   	$response = $this->json('PUT','api/clients/'.$client->id,$clientData)
   		->assertStatus(200)
   		->assertJson([
   			'id'=>$client->id,
   			'first_name'=>'newName',
   			'last_name'=>$client->last_name,
   			'email'=>'new@email.com'
   		]);
   }

   public function testClientsDelete()
   {
	$originalClientCount = Client::count();
   	$client = factory(Client::class)->create();
   	//assert that one more client was created
	$this->assertEquals($originalClientCount+1,Client::count());

   	$this->json('DELETE','api/clients/'.$client->id)
   		->assertStatus(200);
   	//assert that client was deleted
   	$this->assertEquals($originalClientCount,Client::count());
   }
}

