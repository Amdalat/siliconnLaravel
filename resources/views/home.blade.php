@extends('layouts.app')

@section('content')
{{-- @section('page', "active") --}}
@section('title', 'Home')
    {{-- <h1>All Posts</h1> --}}
    <h2 class="text-center mt-5">All Posts</h2>
    {{-- @foreach ($posts as $post) --}}
    @forelse($posts as $post)
        <div class="card w-50 mx-auto my-3">
            <div class="card-header d-flex justify-content-between">
                <div>Hot gist</div>
                <div class="fst-italic">{{ $post->user->first_name }} {{ $post->user->last_name }} </div>
            </div>
            <div class="card-body">
                <img src="{{ asset('posts/'. $post->image) }}" alt="{{ $post->title }}" style="height: 50vh; width: 100%; margin-bottom: 10px;">
                <h5 class="card-title">{{ $post->title }}</h5>
                <p class="card-text"><i>Category: {{ $post->category }}</i></p>
                <a href="{{ route('single.post', $post->id) }}" class="btn btn-primary">read more...</a>
            </div>
            <p class="card-header text-end">{{ $post->created_at }}</p>
        </div>

        @empty
        <div class="text-center fs-italic">No post yet...</div>
    @endforelse

    <div class="d-flex justify-content-center">
        {{ $posts->links() }} {{-- paginate  --}}
    </div>
@endsection
