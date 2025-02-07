@extends('layouts.app')

@section('title', 'Top 10 Most Famous Authors')

@section('header', 'Top 10 Most Famous Authors')

@section('content')

<style>
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
        background: white;
    }

    th, td {
        border: 1px solid #ddd;
        padding: 10px;
        text-align: left;
    }

    th {
        background-color: #f4f4f4;
    }

    tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    .container {
        max-width: 600px;
        margin: auto;
        text-align: center;
    }
</style>

<div class="container">

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Author Name</th>    
                <th>Total Votes</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($authors as $index => $author)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $author->name }}</td>
                <td>{{ $author->total_votes }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
