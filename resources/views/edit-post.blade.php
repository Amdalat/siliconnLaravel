@extends('layouts.app')
@section('content')
    <div class="mt-5">
        <h3 class="text-center">Create A Post</h3>
        <form action="{{ route('update.post', $post->id) }}" method="post" class= "w-50 mx-auto card p-5 mt-5">
            @csrf
            {{-- @method('put') --}}
            <div class="mb-3">
                <label for="title" class="form-label">Post Title</label>
                <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" id="title" placeholder="enter post title..." value="{{ $post->title }}">

                @error('title')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="category" class="form-label">Category</label>
                <input type="text" class="form-control @error('category') is-invalid @enderror" name="category" id="category" placeholder="ex: Finance..." value="{{ $post->category }}"></input>

                @error('category')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="body" class="form-label">Body</label>
                <textarea class="form-control @error('body') is-invalid @enderror" name="body" id="body" rows="3">{{ $post->body }}</textarea>

                @error('body')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <input type="submit" class="btn btn-dark" value="Update">
        </form>
    </div>

@endsection
