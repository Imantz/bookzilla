<?php

namespace App\Http\Controllers;

use App\Repositories\BookPurchaseRepositoryInterface;

class BookPurchaseController extends Controller
{
    protected $bookPurchaseRepository;

    public function __construct(BookPurchaseRepositoryInterface $bookPurchaseRepository)
    {
        $this->bookPurchaseRepository = $bookPurchaseRepository;
    }

    public function incrementPopularity($id)
    {
        $this->bookPurchaseRepository->incrementBookPopularity($id);
    }
}
