@extends('layouts.app')

@section('content')
<h2>All Posts</h2>
<a href="{{ route('posts.create') }}" class="btn btn-success mb-3">+ Add Post</a>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered">
<tr>
    <th>Title</th><th>Author</th><th>Categories</th><th>Actions</th>
</tr>
@foreach($posts as $post)
<tr>
    <td>{{ $post->title }}</td>
    <td>{{ $post->user->name }}</td>
    <td>{{ implode(', ', $post->categories->pluck('name')->toArray()) }}</td>
    <td>
        <a href="{{ route('posts.show', $post->id) }}" class="btn btn-info btn-sm">View</a>
        <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-warning btn-sm">Edit</a>
        <form action="{{ route('posts.destroy', $post->id) }}" method="POST" class="d-inline">
            @csrf @method('DELETE')
            <button class="btn btn-danger btn-sm" onclick="return confirm('Delete?')">Delete</button>
        </form>
    </td>
</tr>
@endforeach
</table>
@endsection
