<?php

namespace Tests\Feature\User;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Str;
use MoneyTransaction\Infrastructure\Models\UserModel;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class FindTest extends TestCase
{
    use DatabaseTransactions;

    public function testItFindAUser()
    {
        /** @var UserModel $user */
        $user = UserModel::factory()->create();
        $response = $this->getJson(route('users.show', $user->getKey()));

        $response->assertJson([
            'id' => $user->getKey(),
            'name' => $user->name,
            'email' => $user->email,
            'cpf' => $user->cpf,
            'type' => $user->type,
        ]);

        $response->assertStatus(Response::HTTP_OK);
    }

    public function testItTryToFindAInexistentUser()
    {
        /** @var UserModel $user */
        UserModel::factory()->create();
        $response = $this->getJson(route('users.show', Str::orderedUuid()->toString()));

        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }
}
