<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class UserTest extends TestCase
{

    use RefreshDatabase;
    /**
     * Should be able to create an user successfully
     */
    public function testCreateUserSuccessfully(): void
    {
        $headers = ['Accept' => 'application/json'];
        $userData = [
            "name" => "Leonardo Marques",
            "email" => "leomarques@gmail.com",
            "password" => bcrypt("123456")
        ];


        $this->json('POST', '/users', $userData, $headers)
        ->assertStatus(201)
        ->assertJson([
            "user" => [
                'name' => 'Leonardo Marques',
                'email' => "leomarques@gmail.com"
            ],
            "message" => "Created successfully"
        ]);

    }
    public function testRetrieveUserSuccessfully()
    {
        $headers = ['Accept' => 'application/json'];
        $user = User::factory()->create([
            "name" => "Leonardo Marques",
            "email" => "leomarques@gmail.com",
            "password" => bcrypt("123456")
        ]);

        $this->json('GET', "/users/$user->id", $headers)
            ->assertStatus(200)
            ->assertJson([
                "user" => [
                    "name" => "Leonardo Marques",
                    "email" => "leomarques@gmail.com",
                ],
                "message" => "Retrieved successfully"
            ]);
    }

    public function testRetrieveUsersSuccessfully()
    {
        $headers = ['Accept' => 'application/json'];

        User::factory()->create([
            "name" => "Leonardo Marques",
            "email" => "leomarques@gmail.com",
            "password" => bcrypt("123456")
        ]);

        User::factory()->create([
            "name" => "Talita Vital",
            "email" => "talita@gmail.com",
            "password" => bcrypt("1231dfgs")
        ]);

        $this->json('GET', "/users", $headers)
            ->assertStatus(200)
            ->assertJson([
                "users" => [
                    "data" =>
                    [
                        [
                            "name" => "Leonardo Marques",
                            "email" => "leomarques@gmail.com",
                        ],
                        [
                            "name" => "Talita Vital",
                            "email" => "talita@gmail.com",
                        ]
                    ]
                ],
                "message" => "Retrieved successfully"
            ]);
    }

    // response([ 'users' => UserResource::collection($users), 'message' => 'Retrieved successfully'], 200);

    public function testUserUpdatedSuccessfully()
    {
        $headers = ['Accept' => 'application/json'];
        $user = User::factory()->create([
            "name" => "Leonardo Marques",
            "email" => "leomarques@gmail.com",
            "password" => bcrypt("123456")
        ]);

        $incomingData = [
            "name" => "Leo Marques Updated",
            "email" => "leo@gmail.com",
            "password" => bcrypt("98s4da98")
        ];

        $this->json('PATCH', "/users/$user->id", $incomingData, $headers)
            ->assertStatus(200)
            ->assertJson([
                "user" => [
                    "name" => "Leo Marques Updated",
                    "email" => "leo@gmail.com",
                ],
                "message" => "Updated successfully"
            ]);
    }

    public function testDeleteUser()
    {
        $headers = ['Accept' => 'application/json'];
        $user = User::factory()->create([
            "name" => "Leonardo Marques",
            "email" => "leomarques@gmail.com",
            "password" => bcrypt("123456")
        ]);

        $this->json('DELETE', "/users/$user->id", $headers)
            ->assertStatus(Response::HTTP_NO_CONTENT);
    }
}
