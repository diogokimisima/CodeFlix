<?php

namespace Tests\Feature\Api;

use App\Models\Genre as Model;
use App\Models\Category as ModelCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class GenreApiTest extends TestCase
{
    protected $endpoint = '/api/genres';

    public function test_list_all_empty()
    {
        $response = $this->getJson($this->endpoint);

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonCount(0, 'data');
    }

    
    public function test_list_all()
    {
        Model::factory()->count(20)->create();

        $response = $this->getJson($this->endpoint);

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonCount(15, 'data');
    }

    public function test_store()
    {
        $categories = ModelCategory::factory()->count(10)->create();

        $response = $this->postJson($this->endpoint, [
            'name' => 'new genre',
            'is_active' => true,
            'categories_ids' => $categories->pluck('id')->toArray(),
        ]);

        $response->assertStatus(Response::HTTP_CREATED);
    }
}
