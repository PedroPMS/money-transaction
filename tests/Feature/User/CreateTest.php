<?php

namespace Tests\Feature\User;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use MoneyTransaction\Infrastructure\Models\UserModel;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class CreateTest extends TestCase
{
    use DatabaseTransactions;

    public function testItCreateANewUserAndWallet()
    {
        $user = UserModel::factory()->make()->toArray();
        $response = $this->postJson(route('users.store'), $user);
        $userId = $response->json()['id'];

        $this->assertDatabaseHas('users', ['id' => $userId]);
        $this->assertDatabaseHas('wallet', ['user_id' => $userId]);

        $response->assertStatus(Response::HTTP_CREATED);
    }

    public function testItTryToCreateAAlreadyRegistredEmail()
    {
        UserModel::factory(['email' => 'test@gmail.com'])->create();
        $user = UserModel::factory(['email' => 'test@gmail.com'])->make()->toArray();
        $response = $this->postJson(route('users.store'), $user);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function testItTryToCreateAAlreadyRegistredCpf()
    {
        UserModel::factory(['cpf' => '111.222.333-44'])->create();
        $user = UserModel::factory(['cpf' => '111.222.333-44'])->make()->toArray();
        $response = $this->postJson(route('users.store'), $user);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
