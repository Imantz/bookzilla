<?php

namespace App\Http\Controllers;

use App\Repositories\BookRepositoryInterface;
use Inertia\Inertia;
use App\Http\Requests\BookFilterRequest;

class BookController extends Controller
{
    protected $bookRepository;

    public function __construct(BookRepositoryInterface $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }

    /**
     * Display the books for the frontend (Inertia)
     *
     * @param  BookFilterRequest  $request
     * @return \Inertia\Response
     */
    public function index(BookFilterRequest $request)
    {
        $books = $this->bookRepository->getBooks($request->filters());

        return Inertia::render('Books/BookView', compact('books'));
    }

    /**
     * Display the books for the API (JSON)
     *
     * @param  BookFilterRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function apiIndex(BookFilterRequest $request)
    {
        $books = $this->bookRepository->getBooks($request->filters());

        return response()->json($books);
    }
}
