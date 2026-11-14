<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Qikchat Feed') }}
        </h2>
    </x-slot>

    py-12
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Success Message -->
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Post Chat Form -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6 p-6">
                <form action="{{ route('chats.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="category_id" class="block font-medium text-sm text-gray-700">Category</label>
                        <select name="category_id" id="category_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            <option value="">-- Select Category --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="content" class="block font-medium text-sm text-gray-700">What's on your mind?</label>
                        <textarea name="content" id="content" rows="3" maxlength="280" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Share a quick thought..." required></textarea>
                    </div>

                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500">
                        Post Chat
                    </button>
                </form>
            </div>

            <!-- Chat Feed List -->
            <div class="space-y-4">
                @forelse($chats as $chat)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <div class="flex justify-between items-center mb-2">
                            <div>
                                <span class="font-bold text-gray-900">{{ $chat->user->name }}</span>
                                <span class="text-xs bg-indigo-100 text-indigo-800 px-2 py-1 rounded ml-2">{{ $chat->category->name }}</span>
                            </div>
                            <span class="text-xs text-gray-500">{{ $chat->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="text-gray-800 mb-4">{{ $chat->content }}</p>

                        @if($chat->user_id === Auth::id())
                            <div class="flex space-x-2">
                                <a href="{{ route('chats.edit', $chat->id) }}" class="text-sm text-blue-600 hover:underline">Edit</a>
                                <form action="{{ route('chats.destroy', $chat->id) }}" method="POST" onsubmit="return confirm('Delete this chat?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-sm text-red-600 hover:underline">Delete</button>
                                </form>
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-center text-gray-500">
                        No chats posted yet. Be the first to share something!
                    </div>
                @endforelse

                <div class="mt-4">
                    {{ $chats->links() }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>