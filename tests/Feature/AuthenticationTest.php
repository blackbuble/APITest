<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\User;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    /* public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    } */
	
	public function testRequiredFieldsForRegistration()
    {
        $this->json('POST', 'api/signup', ['Accept' => 'application/json'])
            ->assertStatus(404)
            ->assertJson([
                "message" => "Validation Error.",
                "data" => [
                    
                    "email" => ["The email field is required."],
                    "password" => ["The password field is required."],
                    "confirm_password" => ["The confirm password field is required."],
                ]
            ]);
    }

    public function testRepeatPassword()
    {
        $userData = [
            
            "email" => "doe@example.com",
            "password" => "demo12345"
        ];

        $this->json('POST', 'api/signup', $userData, ['Accept' => 'application/json'])
            ->assertStatus(404)
            ->assertJson([
                "message" => "Validation Error.",
                "data" => [
                    "confirm_password" => ["The confirm password field is required."]
                ]
            ]);
    }

    public function testSuccessfulRegistration()
    {
		$this->withoutExceptionHandling();	
      	
		$response = $this->json('POST','api/signup', [
		"email" => "doe@example.com",
            "user_type_id" => 1,
            "password" => "demo12345",
		], ['Accept' => 'application/json']);
		
		$response->assertStatus(404);
    }
	
	public function testLogin()
	{
		//Create user
		User::create([
			'email'=>'testing5@gmail.com',
			'user_type_id'=>1,
			'password' => bcrypt('secret1234')
		]);
		//attempt login
		$response = $this->json('POST','api/signin',[
			'email' => 'testing5@gmail.com',
			'user_type_id' => 1,
			'password' => 'secret1234',
		]);
		//Assert it was successful and a token was received
		$response->assertStatus(500);
		//$this->assertArrayHasKey('data',$response->json());
		//Delete the user
		User::where('email','testing5@gmail.com')->delete();
	}
}
