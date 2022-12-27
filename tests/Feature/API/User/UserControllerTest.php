<?php

namespace Tests\Feature\API\User;

use App\Models\Book;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_get_user_profile()
    {
        $user = User::factory()->has(Book::factory(3))->create();
        $book = $user->books()->first();
        $user->booksRented()->attach($book);

        $booksOwned = $user->books()->get()->map(fn (Book $book) => $book)->toArray();
        $booksRented = $user->booksRented()->get()->map(fn (Book $book) => $book)->toArray();

        $json = [
            'status' => 200,
            'message' => 'success',
            'profile' => [
                'avatar' => $user->image,
                'name' => $user->name,
                'books' => [
                    'owned' => $booksOwned,
                    'rented' => $booksRented
                ]
            ]
        ];

        $response = $this->get(route('api.user.profile', $user->id));

        $response->assertOk();
        $response->assertExactJson($json);
    }
}
