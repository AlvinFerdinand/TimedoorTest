@extends('layouts.app')

@section('title', 'Insert Rating')

@section('content')
<div class="container">
    <h2 class="text-center mb-4">Insert Rating</h2>

    <form method="GET" action="{{ route('books.rate.form') }}" class="mb-4">
        <div class="form-group">
            <label for="author"><strong>Author:</strong></label>
            <select id="author" name="author_id" class="form-control" required onchange="this.form.submit()">
                <option value="">Select Author</option>
                @foreach($authors as $author)
                    <option value="{{ $author->id }}" {{ request('author_id') == $author->id ? 'selected' : '' }}>
                        {{ $author->name }}
                    </option>
                @endforeach
            </select>
        </div>
    </form>

    @if(request('author_id'))
    <form method="POST" action="{{ route('books.rate') }}" class="p-4 border rounded shadow bg-light">
        @csrf

        <input type="hidden" name="author_id" value="{{ request('author_id') }}">

        <div class="form-group mb-3">
            <label for="book"><strong>Book:</strong></label>
            <select id="book" name="book_id" class="form-control" required>
                <option value="">Select Book</option>
                @foreach($books as $book)
                    <option value="{{ $book->id }}" {{ old('book_id') == $book->id ? 'selected' : '' }}>
                        {{ $book->title }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group mb-3">
            <label for="rating"><strong>Rating:</strong></label>
            <select id="rating" name="rating" class="form-control" required>
                @for ($i = 1; $i <= 10; $i++)
                    <option value="{{ $i }}" {{ old('rating') == $i ? 'selected' : '' }}>{{ $i }}</option>
                @endfor
            </select>
        </div>

        <button type="submit" class="btn btn-primary w-100">Submit Rating</button>
    </form>
    @endif
</div>
@endsection
