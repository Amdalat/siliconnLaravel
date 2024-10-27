@extends('layouts.app')
@section('content')
@section('title', 'Single Post')
@if (session()->has('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>{{ session()->get('error') }}</strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="close"></button>
</div>
@endif

@if (session()->has('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>{{ session()->get('success') }}</strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="close"></button>
</div>
@endif

    <div class="container">
        <h2 class="text-center mt-5">Single Posts</h2>
        <div class="card w-50 mx-auto my-3">
            <div class="card-header d-flex justify-content-between">
                <div>Hot gist</div>
                @if (auth()->check())
                    <div class="fst-italic">Author: {{ $post->user->first_name }} {{ $post->user->last_name }} </div>
                @endif
            </div>
            <div class="card-body">
                <img src="{{ asset('posts/'. $post->image) }}" alt="{{ $post->title }}" style="height: 50vh; width: 100%; margin-bottom: 10px;">
                <h5 class="card-title">{{ $post->title }}</h5>
                <p class="card-text">{{ $post->body }}</p>
                <p class="card-text"><i>Category: {{ $post->category }}</i></p>

                @if (auth()->check())
                @if ($post->user_id == auth()->id())
                {{-- <hr> --}}
                <div class='d-flex gap-2'>
                    <a href="{{ route('edit.post', $post->id) }}" class="btn btn-primary">Edit</a>
                    <form action="{{ route('delete.post', $post->id) }}" method="post">
                        @csrf
                        @method('delete')
                        <button class="btn btn-danger" onclick="return confirm('Are you sure you want to delete?');">Delete</button>
                        {{-- <button class="btn btn-danger" onclick="return confirmDelete()">Delete</button> --}}
                        {{-- <a href="#" class="btn btn-danger">Delete</a> --}}
                    </form>
                </div>
                @endif
                {{-- @else
                <h3>not logged</h3> --}}
                @endif
            </div>
            <p class="card-header text-end">{{ $post->created_at }}</p>
        </div>

        <div class="mt-5 w-50 mx-auto">
            <hr>
            <form action="{{ route('comment', $post->id) }}" method="post">
                @csrf
                <div class="mb-3">
                    <textarea class="form-control @error('comment') is-invalid @enderror" name="comment" id="comment" rows="3" placeholder="comment..."></textarea>
                </div>
                <input type="submit" class="btn btn-dark">
            </form>
        </div>

        <div class="mt-5 w-70 mx-auto">
            <h3 class="text-center">All Comments</h3>
            <hr>
            @forelse ($comments as $comment)
                @if ($post->id === $comment->post_id)
                    <div class="my-2 p-2" style="margin-bottom:2px; box-shadow: 2px 2px 2px #000000"><strong>{{ $comment->user->first_name }} {{ $comment->user->last_name }}</strong> : {{ $comment->comment }} <br>
                    <p class="card-header text-end">{{ $post->created_at }}</p>
                    </div>
                {{-- @else
                    <div>No comment yet...</div> --}}
                @endif
                @empty
                <div>No comment yet...</div>
            @endforelse
        </div>

    </div>

    {{-- <script src="{{ asset('js/app.js') }}"></script> --}}
@endsection
