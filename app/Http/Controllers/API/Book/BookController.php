<?php

namespace App\Http\Controllers\API\Book;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'author' => 'required|string',
            'image' => 'nullable',
            'publish_date' => 'required|date',
            'type' => 'required|string',
            'description'=> 'required|string',
            'editor' => 'required|string',
            'language' => 'required|string',
            'owner_id' => 'required|integer',
            'copys' => 'required|integer',
        ]);

        if (Book::create($validated)) {
            $response = [
                'status' => 200,
                'message' => 'success'
            ];
            return response()->json($response);
        }

        $response = [
            'status' => 401,
            'message' => 'not authorized',
        ];
        return response()->json($response, 401);
    }

    public function update(Book $book, Request $request): JsonResponse
    {
        if (auth()->user()->id != $book->owner_id) {
            $response = [
                'status' => 401,
                'message' => 'not authorized',
            ];

            return response()->json($response, 401);
        }

        $validated = $request->validate([
            'title' => 'string',
            'author' => 'string',
            'image' => 'nullable',
            'publish_date' => 'date',
            'type' => 'string',
            'description'=> 'string',
            'editor' => 'string',
            'language' => 'string',
            'copys' => 'integer',
        ]);

        $book->update($validated);
        
        $response = [
            'status' => 200,
            'message' => 'success'
        ];
        return response()->json($response);
    }
}
