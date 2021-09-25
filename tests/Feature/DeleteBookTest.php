<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Book;

class DeleteBookTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test can delete a book.
     *
     * @return void
     */
    public function test_can_delete_a_book()
    {
        $book = Book::factory()->create();

        $response = $this->deleteJson("/books/{$book->id}");

        $response->assertStatus(200);
        $this->assertDeleted($book);
    }
}
