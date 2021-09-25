<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;
use App\Models\Book;

class BrowseBookTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test can browse books.
     *
     * @return void
     */
    public function test_can_browse_books()
    {
        $count = 50;
        Book::factory()->count($count)->create();

        $response = $this->getJson('/books');

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
                            ->has('title')
                            ->whereType('title', 'string')
                            ->has('year')
                            ->whereType('year', 'integer')
                            ->etc()
                    )
                    ->etc()
            );
    }
}
