@extends('layouts.app')

@section('title', 'Book List')

@section('header', 'Book List')

@section('content')

<form method="GET" action="{{ route('books.index') }}">
    <label for="shown">Show:</label>
    <select name="shown" id="shown">
        <option value="100" {{ request('shown') == 100 ? 'selected' : '' }}>100</option>
        <option value="500" {{ request('shown') == 500 ? 'selected' : '' }}>500</option>
        <option value="1000" {{ request('shown') == 1000 ? 'selected' : '' }}>1000</option>
    </select>

    <label for="search">Search:</label>
    <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Cari buku" autocomplete="off">
    <button type="submit">Submit</button>
</form>

<table border="1" width="100%">
    <thead>
        <tr>
            <th>No</th>
            <th>Book Name</th>
            <th>Category Name</th>
            <th>Author</th>
            <th>Average Rating</th>
            <th>Voter</th>
        </tr>
    </thead>
    <tbody>
        @foreach($books as $book)
        <tr>
            <td>{{ $book['no'] }}</td>
            <td>{{ $book['title'] }}</td>
            <td>{{ $book['category'] }}</td>
            <td>{{ $book['author'] }}</td>
            <td>{{ $book['average_rating'] }}</td>
            <td>{{ $book['voter'] }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection
