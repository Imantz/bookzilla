<?php

namespace App\Http\Controllers;

use App\Repositories\BookPurchaseRepositoryInterface;

class BookPurchaseController extends Controller
{
    public function __construct(protected BookPurchaseRepositoryInterface $bookPurchaseRepository) {}

    public function incrementPopularity($id)
    {
        return $this->bookPurchaseRepository->incrementBookPopularity($id);
    }
}
