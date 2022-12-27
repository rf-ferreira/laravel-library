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

        $booksOwned = [];
        foreach ($user->books()->get() as $book) {
            $booksOwned[] = [
                "id" => $book->id,
                "title" => $book->title,
                "author" => $book->author,
                "image" => $book->image,
                "publish_date" => $book->publish_date,
                "type" => $book->type,
                "description" => $book->description,
                "editor" => $book->editor,
                "language" => $book->language,
                "copys" => $book->copys,
            ];
        }

        $json = [
            'status' => 200,
            'message' => 'success',
            'profile' => [
                'avatar' => $user->image,
                'name' => $user->name,
                'books' => [
                    'owned' => $booksOwned,
                    'rented' => []
                ]
            ]
        ];

        $response = $this->get(route('api.user.profile', $user->id));

        $response->assertOk();
        $response->assertExactJson($json);
    }
}
