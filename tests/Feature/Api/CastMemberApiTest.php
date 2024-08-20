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
}
