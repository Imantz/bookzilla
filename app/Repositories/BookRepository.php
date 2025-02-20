<?php

namespace App\Repositories;

use App\Models\Book;
use App\Repositories\BookRepositoryInterface;
use App\Repositories\BookPurchaseRepositoryInterface;
use Illuminate\Support\Facades\DB;

class BookRepository implements BookRepositoryInterface
{
    public function __construct(protected BookPurchaseRepositoryInterface $purchaseRepo) {}

    public function getBooks($filters)
    {
        return Book::query()
            ->with('authors:id,name')
            ->leftJoin('purchases', 'books.id', '=', 'purchases.book_id')
            ->groupBy('books.id')
            ->select([
                'books.id',
                'books.title',
                DB::raw('COUNT(purchases.id) AS purchases'),
                DB::raw('(SELECT COUNT(*) FROM purchases WHERE purchases.book_id = books.id) AS total_purchases')
            ])
            ->filter($filters)
            ->get();
    }
}
