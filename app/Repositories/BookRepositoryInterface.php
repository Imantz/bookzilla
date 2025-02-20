<?php

namespace App\Repositories;

interface BookRepositoryInterface
{
    public function getBooks($filters);
}
