<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;
use App\Models\Book;

class UpdateBookTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * Test can update a book.
     *
     * @return void
     */
    public function test_can_update_a_book()
    {
        $book = Book::factory()->create();
        $newBook = Book::factory()->make();

        $response = $this->putJson("/books/{$book->id}", [
            'title' => $newBook->title,
            'year' => $newBook->year,
            'description' => $newBook->description,
        ]);

        $response
            ->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) =>
                $json
                    ->has('id')
                    ->where('title', $newBook->title)
                    ->where('year', $newBook->year)
                    ->where('description', $newBook->description)
                    ->etc()
            );
    }

    /**
     * Test cannot create a new book with empty data.
     *
     * @return void
     */
    public function test_cannot_update_a_book_with_empty_data()
    {
        $book = Book::factory()->create();

        $response = $this->putJson("/books/{$book->id}");

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
     * Test cannot create a update book with invalid data.
     *
     * @return void
     */
    public function test_cannot_create_a_book_with_invalid_data()
    {
        $book = Book::factory()->create();

        $response = $this->putJson("/books/{$book->id}", [
            // test too long
            'title' => $this->faker->realTextBetween(256, 300),

            // invalid year
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
