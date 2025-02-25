<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\GoogleBooksService;
use Illuminate\Http\Request;
use App\Models\Product;

class BookController extends Controller
{
    protected $googleBooksService;

    public function __construct(GoogleBooksService $googleBooksService)
    {
        $this->googleBooksService = $googleBooksService;
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $results = $this->googleBooksService->searchBooks($query);

        // dd($results);

        return view('admin.books.search', compact('results', 'query'));
    }

    public function import($volumeId)
    {
        $bookData = $this->googleBooksService->getBook($volumeId);

        if (isset($bookData['volumeInfo'])) {
            $volumeInfo = $bookData['volumeInfo'];
            $book = new Product();
            $book->name = $volumeInfo['title'] ?? null;
            $book->authors = implode(', ', $volumeInfo['authors'] ?? []);
            $categories = $volumeInfo['categories'] ?? [];
            $categoryString = implode(', ', $categories);
            $book->category = substr($categoryString, 0, 250);
            $book->language = $volumeInfo['language'] ?? null;
            $book->price = rand(1, 3000);
            $book->details = $volumeInfo['description'] ?? null;

            
            $book->image = $volumeInfo['imageLinks']['thumbnail'] ?? null;
            $book->save();

            return redirect()->route('admin.books.search')->with('success', 'Book imported successfully.');
        }
        return redirect()->route('admin.books.search')->with('error', 'Failed to import book.');
    }

    public function searchForm()
    {
        return view('admin.books.search');
    }
}