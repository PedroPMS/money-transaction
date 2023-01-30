<?php

namespace Tests\Feature\User;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Str;
use MoneyTransaction\Infrastructure\Models\UserModel;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class DeleteTest extends TestCase
{
    use DatabaseTransactions;

    public function testItDeleteAUser()
    {
        /** @var UserModel $user */
        $user = UserModel::factory()->create();
        $response = $this->delete(route('users.delete', $user->getKey()));

        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }

    public function testItTryToDeleteAInexistentUser()
    {
        /** @var UserModel $user */
        UserModel::factory()->create();
        $response = $this->delete(route('users.delete', Str::orderedUuid()->toString()));

        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }
}
