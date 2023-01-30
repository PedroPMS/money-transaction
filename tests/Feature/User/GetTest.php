<?php

namespace Tests\Feature\User;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use MoneyTransaction\Infrastructure\Models\UserModel;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class GetTest extends TestCase
{
    use DatabaseTransactions;

    public function testItGetAllUser()
    {
        UserModel::factory()->create();
        $response = $this->getJson(route('users.index'));

        $response->assertJsonStructure([
            0 => [
                'id',
                'name',
                'email',
                'cpf',
                'type',
            ],
        ]);

        $response->assertStatus(Response::HTTP_OK);
    }
}
