<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Http\Resources\BookCollection;
use App\Http\Resources\BookResource;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;

class BookController extends Controller
{
    /**
     * Browse
     *
     * Display a paginated listing of the books collection.
     *
     * @group Books Management
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new BookCollection(
            Book::paginate()
        );
    }

    /**
     * Create
     *
     * Store a newly created book.
     *
     * @group Books Management
     *
     * @param  \App\Http\Requests\StoreBookRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBookRequest $request)
    {
        return new BookResource(
            Book::create(
                $request->validated()
            )
        );
    }

    /**
     * Display the specified book.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified book.
     *
     * @param  \App\Http\Requests\UpdateBookRequest  $request
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBookRequest $request, Book $book)
    {
        $book->fill($request->validated());
        $book->save();

        return new BookResource($book);
    }

    /**
     * Remove the specified book.
     *
     * @param  \App\Models\Book  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
        $book->delete();
    }
}
