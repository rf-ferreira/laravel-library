<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Book;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $user = User::factory()->has(Book::factory(3))->create();
        $user->booksRented()->attach(1);


        User::factory()->create([
            'name' => 'User',
            'email' => 'user@email.com',
        ]);
    }
}
