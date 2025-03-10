<?php

namespace App\Console\Commands;

use App\Models\Product;
use App\Services\GoogleBooksService;
use Illuminate\Console\Command;

class ImportApiBooksCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'books:import {query?} {--count=30}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import books from Google Books API based on search query';

    protected $googleBooksService;
    public function __construct(GoogleBooksService $googleBooksService)
    {
        parent::__construct();
        $this->googleBooksService = $googleBooksService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Get the search query from command argument or use a default/predefined list
        $query = $this->argument('query');
        $count = $this->option('count');

        if (!$query) {
            // If no query provided, use a list of popular categories/topics
            $queries = ['fiction', 'science', 'history', 'programming', 'business'];
            $query = $queries[array_rand($queries)];
            $this->info("No query provided. Using random category: {$query}");
        }

        $this->info("Searching for '{$query}' books...");
        $results = $this->googleBooksService->searchBooks($query, $count);

        $imported = 0;
        $skipped = 0;

        if (isset($results['items']) && count($results['items']) > 0) {
            foreach ($results['items'] as $item) {
                $volumeInfo = $item['volumeInfo'] ?? [];
                $title = $volumeInfo['title'] ?? '';
                $authors = implode(', ', $volumeInfo['authors'] ?? []);

                // Check if book already exists
                $exists = Product::where('name', $title)
                    ->where('authors', $authors)
                    ->exists();

                if ($exists) {
                    $this->warn("Skipped: '{$title}' already exists in database.");
                    $skipped++;
                    continue;
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

                $this->info("Imported: '{$title}'");
                $imported++;
            }
        } else {
            $this->error("No books found for query: {$query}");
        }

        $this->info("Import completed. {$imported} books imported, {$skipped} books skipped.");
    }
}
