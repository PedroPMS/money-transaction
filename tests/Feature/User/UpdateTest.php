<?php

namespace Tests\Feature\User;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Str;
use MoneyTransaction\Infrastructure\Models\UserModel;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    use DatabaseTransactions;

    public function testItUpdateAUser()
    {
        /** @var UserModel $user */
        $user = UserModel::factory()->create();
        $response = $this->putJson(route('users.update', $user->getKey()), [...$user->toArray(), 'name' => 'teste']);

        $response->assertJson([
            'id' => $user->getKey(),
            'name' => 'teste',
            'email' => $user->email,
            'cpf' => $user->cpf,
            'type' => $user->type,
        ]);

        $response->assertStatus(Response::HTTP_OK);
    }

    public function testItTryToUpdateAInexistentUser()
    {
        /** @var UserModel $user */
        $user = UserModel::factory()->create();
        $response = $this->putJson(route('users.update', Str::orderedUuid()->toString()), $user->toArray());

        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }
}
