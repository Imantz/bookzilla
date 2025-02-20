<?php

namespace App\Repositories;

use App\Models\Purchase;

class BookPurchaseRepository implements BookPurchaseRepositoryInterface
{
    public function incrementBookPopularity($id)
    {
        Purchase::create(['book_id' => $id]);
    }
}
