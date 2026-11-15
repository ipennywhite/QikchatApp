@extends('layouts.master')

@section('title', 'Qikchat Feed')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        
        <!-- Post Form Card -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-white fw-bold text-primary">What's on your mind?</div>
            <div class="card-body">
                <form action="{{ route('chats.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="category_id" class="form-label">Category</label>
                        <select name="category_id" id="category_id" class="form-select" required>
                            <option value="">-- Choose Category --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <textarea name="content" rows="3" maxlength="280" class="form-control" placeholder="Share your thoughts..." required></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary px-4">Post Chat</button>
                </form>
            </div>
        </div>

        <!-- Feed List -->
        <h4 class="mb-3 text-secondary">Recent Chats</h4>
        @forelse($chats as $chat)
            <div class="card shadow-sm mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div>
                            <span class="fw-bold text-dark">{{ $chat->user->name }}</span>
                            <span class="badge bg-secondary ms-2">{{ $chat->category->name }}</span>
                        </div>
                        <small class="text-muted">{{ $chat->created_at->diffForHumans() }}</small>
                    </div>
                    <p class="card-text text-break mb-3">{{ $chat->content }}</p>

                    @if($chat->user_id === Auth::id())
                        <div class="d-flex gap-2">
                            <a href="{{ route('chats.edit', $chat->id) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                            <form action="{{ route('chats.destroy', $chat->id) }}" method="POST" onsubmit="return confirm('Delete this chat?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="card shadow-sm p-4 text-center text-muted">
                No chats posted yet. Be the first to share something!
            </div>
        @endforelse

        <div class="d-flex justify-content-center mt-4">
            {{ $chats->links() }}
        </div>

    </div>
</div>
@endsection