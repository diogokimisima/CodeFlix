<?php

namespace Tests\Feature\Api;

use App\Models\CastMember;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class CastMemberApiTest extends TestCase
{
    protected $endpoint = '/api/cast_members';

    public function test_get_all_empty()
    {
        $response = $this->get($this->endpoint);

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonCount(0, 'data');
    }

    public function test_pagination()
    {
        $castMembers = CastMember::factory()->count(50)->create();

        $response = $this->get($this->endpoint);

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonCount(15, 'data');
        $response->assertJsonStructure([
            'meta' => [
                'total',
                'current_page',
                'last_page',
                'first_page',
                'per_page',
                'to',
                'from',
            ]
        ]);
    }

    public function test_pagination_page_two()
    {
        $castMembers = CastMember::factory()->count(20)->create();

        $response = $this->get("$this->endpoint?page=2");

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonCount(5, 'data');
        $this->assertEquals(20, $response['meta']['total']);
        $this->assertEquals(2, $response['meta']['current_page']);
    }

    public function test_pagination_with_filters()
    {
        CastMember::factory()->count(10)->create();
        CastMember::factory()->count(10)->create([
            'name' => 'teste'
        ]);

        $response = $this->getJson("$this->endpoint?filter=teste");

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonCount(10, 'data');
    }

    public function test_show_not_found()
    {
        $response = $this->getJson("{$this->endpoint}/fake_id");

        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    public function test_show()
    {
        $castMember = CastMember::factory()->create();

        $response = $this->getJson("{$this->endpoint}/{$castMember->id}");
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'type',
                'created_at',
            ]
        ]);
    }

    public function test_store_validations()
    {
        $response = $this->postJson($this->endpoint, []);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonStructure([
            'message',
            'errors' => [
                'name',
                'type'
            ],
        ]);
    }

    public function test_store()
    {
        $response = $this->postJson($this->endpoint, [
            'name' => 'New Name',
            'type' => 1
        ]);

        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'type',
                'created_at'
            ],
        ]);
        $this->assertDatabaseHas('cast_members', [
            'name' => 'New Name',
            'type' => 1,
        ]);
    }
}
