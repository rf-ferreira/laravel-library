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
}
