<?php

namespace App\Repositories;

use App\Models\Book;
use App\Repositories\BookRepositoryInterface;
use App\Repositories\BookPurchaseRepositoryInterface;

class BookRepository implements BookRepositoryInterface
{
    protected $purchaseRepo;

    public function __construct(BookPurchaseRepositoryInterface $purchaseRepo)
    {
        $this->purchaseRepo = $purchaseRepo;
    }

    public function getBooks($filters)
    {
        return Book::query()
            ->with('authors:id,name')
            ->leftJoin('purchases', 'books.id', '=', 'purchases.book_id')
            ->groupBy('books.id')
            ->select('books.id', 'books.title')
            ->selectRaw('COUNT(purchases.id) AS purchases')
            ->selectRaw('(SELECT COUNT(*) FROM purchases WHERE purchases.book_id = books.id) AS total_purchases')
            ->filter($filters)
            ->get();
    }
}
