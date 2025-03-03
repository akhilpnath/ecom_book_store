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

        $results = [];

        if ($query) {
            $results = $this->googleBooksService->searchBooks($query);
            // dd($results);
            // Check if books are already in database
            if (isset($results['items']) && count($results['items']) > 0) {
                foreach ($results['items'] as $key => $item) {
                    $exists = Product::where('name', $item['volumeInfo']['title'] ?? '')
                        ->where('authors', implode(', ', $item['volumeInfo']['authors'] ?? []))
                        ->exists();

                    $results['items'][$key]['exists'] = $exists;
                }
            }
        }

        return view('admin.books.search', compact('results', 'query'));
    }

    public function import($volumeId)
    {
        $bookData = $this->googleBooksService->getBook($volumeId);

        if (isset($bookData['volumeInfo'])) {
            $volumeInfo = $bookData['volumeInfo'];
            $title = $volumeInfo['title'] ?? '';
            $authors = implode(', ', $volumeInfo['authors'] ?? []);

            // Check if book already exists
            $exists = Product::where('name', $title)
                ->where('authors', $authors)
                ->exists();

            if ($exists) {
                return redirect()->route('admin.books.search')->with('warning', 'Book "' . $title . '" already exists in the database.');
            }

            // Create new book
            $book = new Product();
            $book->name = $title;
            $book->authors = $authors;
            $categories = $volumeInfo['categories'] ?? [];
            $firstCategory = is_array($categories) ? ($categories[0] ?? null) : $categories;
            $book->category = $firstCategory ? explode(' / ', $firstCategory)[0] : null;
            $book->language = $volumeInfo['language'] ?? null;
            $book->price = rand(1, 3000);
            $book->details = $volumeInfo['description'] ?? null;
            $book->image = $volumeInfo['imageLinks']['thumbnail'] ?? null;
            $book->save();

            return redirect()->route('admin.books.search')->with('success', 'Book "' . $title . '" imported successfully.');
        }
        return redirect()->route('admin.books.search')->with('error', 'Failed to import book.');
    }

    public function searchForm()
    {
        return view('admin.books.search');
    }
}