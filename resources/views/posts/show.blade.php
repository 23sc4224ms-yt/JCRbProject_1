@extends('layouts.app')

@section('title', 'Post Details')

@section('content')
    <div class="page-header">
        <div class="header-content">
            <h1>Post Details</h1>
            <p class="header-subtitle">View post content and author information</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-warning">
                <i class="fas fa-pen"></i> Edit
            </a>
            <a href="{{ route('posts.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>

    <div class="card card-centered">
        <div class="card-body">
            <div class="detail-row">
                <div class="detail-label">Title</div>
                <div class="detail-value">{{ $post->title }}</div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Author</div>
                <div class="detail-value">{{ $post->user?->name ?? 'N/A' }}</div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Email</div>
                <div class="detail-value">{{ $post->user?->email ?? 'N/A' }}</div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Created At</div>
                <div class="detail-value">{{ $post->created_at->format('M d, Y h:i A') }}</div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Content</div>
                <div class="detail-value">{{ $post->content }}</div>
            </div>
        </div>
    </div>
@endsection
