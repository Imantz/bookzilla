<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Author;
use App\Models\Book;
use Illuminate\Support\Facades\DB;

class AuthorBookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $authors = Author::all();
        $books = Book::take(70)->get();

        foreach ($books as $book) {

            $randomAuthors = $authors->random(rand(0, 2));

            foreach ($randomAuthors as $author) {

                DB::table('author_book')->insert([
                    'author_id' => $author->id,
                    'book_id' => $book->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
