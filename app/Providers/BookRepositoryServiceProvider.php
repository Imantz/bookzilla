<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\BookRepositoryInterface;
use App\Repositories\BookRepository;

class BookRepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(BookRepositoryInterface::class, BookRepository::class);
    }
}

