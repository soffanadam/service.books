<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;
use App\Models\Book;

class ShowBookTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test can show a book.
     *
     * @return void
     */
    public function test_can_show_a_book()
    {
        $book = Book::factory()->create();

        $response = $this->getJson("/books/{$book->id}");

        $response
            ->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) =>
                $json
                    ->where('id', $book->id)
                    ->where('title', $book->title)
                    ->where('year', $book->year)
                    ->where('description', $book->description)
                    ->etc()
            );
    }
}
