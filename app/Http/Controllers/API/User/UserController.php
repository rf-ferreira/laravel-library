<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function profile(User $user)
    {
        if (!$user) {
            $response = [
                'status' => 404,
                'message' => 'not found',
            ];

            return response()->json($response, 404);
        }

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
        
        $response = [
            'status' => 200,
            'message' => 'success',
            'profile' => [
                'avatar' => $user->image,
                'name' => $user->name,
                'books' => [
                    'owned' => $booksOwned,
                    'rented' => []
                ],
            ]
        ];
        return response()->json($response);
    }
}
