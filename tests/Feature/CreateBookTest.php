<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;
use App\Models\Book;

class CreateBookTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * Test can create a new book.
     *
     * @return void
     */
    public function test_can_create_a_book()
    {
        $book = Book::factory()->make();

        $response = $this->postJson('/books', $book->toArray());

        $response
            ->assertStatus(201)
            ->assertJson(fn (AssertableJson $json) =>
                $json
                    ->has('id')
                    ->where('title', $book->title)
                    ->where('year', $book->year)
                    ->where('description', $book->description)
                    ->etc()
            );

        $this->assertModelExists(Book::first());
    }

    /**
     * Test cannot create a new book with empty data.
     *
     * @return void
     */
    public function test_cannot_create_a_book_with_empty_data()
    {
        $response = $this->postJson('/books');

        $response
            ->assertStatus(422)
            ->assertJson(fn (AssertableJson $json) =>
                $json
                    ->has('message')
                    ->has('errors', fn ($json) =>
                        $json
                            ->has('title')
                            ->has('year')
                    )
            );
    }

    /**
     * Test cannot create a new book with invalid data.
     *
     * @return void
     */
    public function test_cannot_create_a_book_with_invalid_data()
    {
        $response = $this->postJson('/books', [
            'title' => $this->faker->realTextBetween(256, 300),
            'year' => $this->faker->word(),
        ]);

        $response
            ->assertStatus(422)
            ->assertJson(fn (AssertableJson $json) =>
                $json
                    ->has('message')
                    ->has('errors', fn ($json) =>
                        $json
                            ->has('title')
                            ->has('year')
                    )
            );
    }
}
