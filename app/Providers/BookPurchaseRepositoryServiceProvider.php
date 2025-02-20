<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\BookPurchaseRepositoryInterface;
use App\Repositories\BookPurchaseRepository;

class BookPurchaseRepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(BookPurchaseRepositoryInterface::class, BookPurchaseRepository::class);
    }
}
