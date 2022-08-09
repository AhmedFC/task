<div>
    <h1 class="text-3xl">Posts</h1>
    @error('newComment') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
    <div>
        @if (session()->has('message'))
            <div class="p-3 bg-green-300 text-green-800 rounded shadow-sm">
                {{ session('message') }}
            </div>
        @endif
    </div>
    @foreach($posts as $post)
<div class="card-title">
    {{$post->title}}
</div>
        <div class="card">
            {{$post->body}}
        </div>
        <span class="inline-flex items-center text-sm">
  <button wire:click="like( {{ $post->id }} )" class="inline-flex space-x-2 {{ $post->isLiked() ? 'text-green-400 hover:text-green-500' : 'text-gray-400 hover:text-gray-500' }} focus:outline-none focus:ring-0">
    <svg class="h-5 w-5" x-description="solid/thumb-up" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
        <path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z"></path>
    </svg>

    <span class="font-medium text-gray-900">{{  $count  }}</span>
    <span class="sr-only">likes</span>
  </button>
</span>

    <form class="my-4 flex" wire:submit.prevent="addComment( {{ $post->id }} )">
        <input type="text" class="w-full rounded border shadow p-2 mr-2 my-2" placeholder="What's in your mind."
               wire:model.debounce.500ms="newComment">
        <div class="py-2">
            <button type="submit" class="p-2 bg-blue-500 w-20 rounded shadow text-white btn btn-primary">Add</button>
        </div>
    </form>

    @foreach($post->comments as $comment)
        <div class="rounded border shadow p-3 my-2">
            <div class="flex justify-between my-2">
                <div class="flex">
                    <p class="font-bold text-lg">{{$comment->creator->name}}</p>
                    <p class="mx-3 py-1 text-xs text-gray-500 font-semibold">{{$comment->created_at->diffForHumans()}}
                    </p>
                </div>
                <i class="fas fa-times text-red-200 hover:text-red-600 cursor-pointer"
                   wire:click="remove({{$comment->id}})"></i>
            </div>
            <p class="text-gray-800">{{$comment->body}}</p>
            @if($comment->image)
                <img src="{{$comment->imagePath}}" />
            @endif
        </div>
    @endforeach
    @endforeach

    {{$posts->links('pagination-links')}}
</div>
