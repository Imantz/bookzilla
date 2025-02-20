<?php

namespace App\Repositories;

interface BookPurchaseRepositoryInterface
{
    public function incrementBookPopularity($id);
}
