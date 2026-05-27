@extends('layouts.app')

@section('title', 'Edit Post')

@section('content')
    <div class="page-header mb-4">
        <div>
            <h1 class="page-header-title">Edit Post</h1>
            <p class="page-header-subtitle">Update post details</p>
        </div>
    </div>

    <div class="card card-centered">
        <div class="card-header">
            <h2 class="card-title">Post Information</h2>
        </div>
        <div class="card-body">
            <form action="{{ route('posts.update', $post->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="title" class="form-label">Title</label>
                    <input
                        type="text"
                        class="form-control @error('title') is-invalid @enderror"
                        name="title"
                        id="title"
                        value="{{ old('title', $post->title) }}"
                        placeholder="Enter post title"
                        required>
                    @error('title')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="content" class="form-label">Content</label>
                    <textarea
                        class="form-control @error('content') is-invalid @enderror"
                        name="content"
                        id="content"
                        rows="6"
                        placeholder="Write the post content"
                        required>{{ old('content', $post->content) }}</textarea>
                    @error('content')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="user_id" class="form-label">Author</label>
                    <select name="user_id" id="user_id" class="form-control @error('user_id') is-invalid @enderror" required>
                        <option value="">Select user...</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" {{ old('user_id', $post->user_id) == $user->id ? 'selected' : '' }}>
                                {{ $user->name }} ({{ $user->email }})
                            </option>
                        @endforeach
                    </select>
                    @error('user_id')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="actions actions-center mt-4">
                    <button type="submit" class="btn btn-primary btn-block">
                        <i class="fas fa-save"></i> Update Post
                    </button>
                    <a href="{{ route('posts.index') }}" class="btn btn-secondary btn-block">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
