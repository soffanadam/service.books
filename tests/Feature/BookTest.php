<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;
use App\Models\Book;

class BookTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_index()
    {
        $count = 50;
        Book::factory()->count($count)->create();

        $response = $this->get('/books');

        $response->dump();

        $response
            ->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) =>
                $json
                    ->has('meta', fn ($json) =>
                        $json
                            ->has('current_page')
                            ->has('from')
                            ->has('to')
                            ->has('last_page')
                            ->has('per_page')
                            ->has('total')
                            ->where('total', $count)
                            ->etc()
                    )
                    ->has('data.0', fn ($json) =>
                        $json
                            ->has('name')
                            ->whereType('name', 'string')
                            ->has('year')
                            ->whereType('year', 'integer')
                            ->etc()
                    )
                    ->etc()
            );
    }
}
