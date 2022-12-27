<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use App\Models\Book;
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

        $booksOwned = $user->books()->get()->map(fn (Book $book) => $book)->toArray();
        $booksRented = $user->booksRented()->get()->map(fn (Book $book) => $book)->toArray();

        $response = [
            'status' => 200,
            'message' => 'success',
            'profile' => [
                'avatar' => $user->image,
                'name' => $user->name,
                'books' => [
                    'owned' => $booksOwned,
                    'rented' => $booksRented
                ],
            ]
        ];
        return response()->json($response);
    }
}
