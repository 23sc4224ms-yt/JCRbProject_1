@extends('layouts.app')

@section('content')

<div class="card card-centered">
    <h2>Add New Degree</h2>
    
    <form action="/degree" method="POST">
        @csrf
        
        <div class="form-group">
            <label for="name" class="form-label">Degree Name</label>
            <input type="text" name="name" id="name" class="form-control" required placeholder="e.g., Bachelor of Science in Computer Science">
            @error('name')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>
        
        <div class="actions actions-center">
            <button type="submit" class="btn btn-primary">Save Degree</button>
            <a href="/degree" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>

@endsection
