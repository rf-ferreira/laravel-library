<?php

namespace Tests\Feature\API\Book;

use App\Models\Book;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BookControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_store_a_book()
    {
        $user = User::factory()->create();
        $book = Book::factory()->for($user)->make()->toArray();

        $this->actingAs($user);
        $response = $this->post(route('api.book.store'), $book);

        $this->assertEquals(1, Book::count());
        $response->assertOk();
        $response->assertSee('success');
    }

    public function test_user_can_update_a_book()
    {
        $user = User::factory()->has(Book::factory())->create();
        $book = $user->books()->first();
        $payload = [
            'title' => 'this is a new title'
        ];
        
        $this->actingAs($user);
        $response = $this->put(route('api.book.update', $book->id), $payload);

        $this->assertDatabaseHas('books', [
            'title' => $payload['title']
        ]);
        $response->assertOk();
        $response->assertSee('success');
    }

    public function test_user_can_rent_a_book()
    {
        $user = User::factory()->has(Book::factory())->create();
        $book = $user->books()->first();

        $this->actingAs($user);
        $response = $this->post(route('api.book.rent', $book->id));

        $this->assertDatabaseHas('books_rented', [
            'book_id' => $book->id,
            'renter_id' => $user->id
        ]);
        $response->assertOk();
        $response->assertSee('success');
    }

    public function test_user_can_return_a_book()
    {
        $user = User::factory()->has(Book::factory())->create();
        $book = $user->books()->first();
        $user->booksRented()->attach($book);

        $this->actingAs($user);
        $response = $this->post(route('api.book.return', $book->id));

        $this->assertDatabaseEmpty('books_rented');
        $response->assertOk();
        $response->assertSee('returned');
    }

    public function test_user_can_get_a_book()
    {
        $user = User::factory()->has(Book::factory())->create();
        $book = $user->books()->first();
        $json = [
            'status' => 200,
            'message' => 'success',
            'book' => $book->toArray()
        ];

        $response = $this->get(route('api.book.show', $book->id));

        $response->assertOk();
        $response->assertExactJson($json);
    }

    public function test_user_can_get_all_books()
    {
        Book::factory(3)->for(User::factory())->create();
        $books = Book::get();

        $json = [
            'status' => 200,
            'message' => 'success',
            'books' => $books->toArray()
        ];

        $response = $this->get(route('api.book.books'));

        $response->assertOk();
        $response->assertExactJson($json);
    }
}
