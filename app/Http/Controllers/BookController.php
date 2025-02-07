<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Author;
use App\Models\Rating;


class BookController extends Controller
{
    public function index(Request $request)
    {
        $shown = $request->input('shown', 100); 
        $search = $request->input('search');

        $query = Book::select('id', 'title', 'category_id', 'author_id')
            ->with([
                'author:id,name',
                'category:id,name',
                'ratings:id,book_id,rating'
            ])
            ->withSum('votes', 'vote_value');

       
        if ($search) {
            $query->where('title', 'LIKE', "%$search%");
        }

        $books = $query->paginate($shown)->through(function ($book, $index) use ($shown, $request) {
            $averageRating = $book->ratings->count() > 0
                ? $book->ratings->avg('rating')
                : 0;

            return [
                'no' => ($request->input('page', 1) - 1) * $shown + $index + 1,
                'title' => $book->title,
                'category' => $book->category->name ?? 'Unknown',
                'author' => $book->author->name ?? 'Unknown',
                'average_rating' => number_format($averageRating, 2),
                'voter' => $book->votes_sum_vote_value ?? 0
            ];
        });

            return view('books.index', compact('books'));
    }

    public function topAuthors()
    {
        $authors = Author::select('authors.id', 'authors.name')
            ->leftJoin('books', 'authors.id', '=', 'books.author_id')
            ->leftJoin('votes', 'books.id', '=', 'votes.book_id')
            ->groupBy('authors.id', 'authors.name')
            ->selectRaw('COUNT(DISTINCT books.id) as books_count, COALESCE(SUM(votes.vote_value), 0) as total_votes')
            ->orderByDesc('total_votes')
            ->limit(10)
            ->get();

        return view('authors.top', compact('authors'));
    }
    public function showRateForm(Request $request)
    {
        $authors = Author::with('books')->get();
        $books = collect(); 

        if ($request->has('author_id')) {
            $books = Book::where('author_id', $request->author_id)->get();
        }

        return view('books.rate', compact('authors', 'books'));
    }


    public function rateBook(Request $request)
    {
        $request->validate([
            'author_id' => 'required|exists:authors,id',
            'book_id' => 'required|exists:books,id',
            'rating' => 'required|integer|min:1|max:10',
        ]);

        $book = Book::where('id', $request->book_id)
                    ->where('author_id', $request->author_id)
                    ->first();

        if (!$book) {
            return redirect()->back()->withErrors(['book_id' => 'Invalid book selection!']);
        }

        Rating::create([
            'book_id' => $request->book_id,
            'rating' => $request->rating,
        ]);

        return redirect()->route('books.index')->with('success', 'Rating submitted!');
    }   
}
