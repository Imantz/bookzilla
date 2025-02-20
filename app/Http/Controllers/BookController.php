<?php

namespace App\Http\Controllers;

use App\Repositories\BookRepositoryInterface;
use Inertia\Inertia;
use App\Http\Requests\BookFilterRequest;
use Illuminate\Http\JsonResponse;
use Inertia\Response;

class BookController extends Controller
{
    public function __construct(protected BookRepositoryInterface $bookRepository) {}

    /**
     * Display the books for the frontend (Inertia)
     */
    public function index(BookFilterRequest $request): Response
    {
        return Inertia::render('Books/BookView', [
            'books' => $this->bookRepository->getBooks($request->filters()),
        ]);
    }
    /**
     * Display the books for the API (JSON)
     */
    public function apiIndex(BookFilterRequest $request): JsonResponse
    {
        return response()->json(
            $this->bookRepository->getBooks($request->filters())
        );
    }
}
