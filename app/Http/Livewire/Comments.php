<?php

namespace App\Http\Livewire;

use App\Models\Comment;
use App\Models\Post;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;

class Comments extends Component
{
    use WithPagination;

    public $newComment;
    public $image;
    public $ticketId ;
    public  $post;
    public  $count;

    protected $listeners = [
        'fileUpload'     => 'handleFileUpload',
        'ticketSelected',
    ];

    public function mount(Post $post)
    {
        $this->post = $post;
        $this->count = $post->likes_count;
    }

    public function like($post_id): void

    {

        if ($this->post->isLiked()) {

            $this->post->removeLike();

            $this->count--;

        } elseif (auth()->user()) {

            $this->post->likes()->create([
                'post_id' => $post_id,
                'user_id' => auth()->id()
            ]);
            $this->count++;

        } elseif (($ip = request()->ip()) && ($userAgent = request()->userAgent())) {
            $this->post->likes()->create([
                'ip' => $ip,
                'user_agent' => $userAgent,
                'post_id' => $post_id
            ]);

            $this->count++;
        }
    }


    public function ticketSelected($ticketId)
    {
        $this->ticketId = $ticketId;
    }

    public function handleFileUpload($imageData)
    {
        $this->image = $imageData;
    }

    public function updated($field)
    {
        $this->validateOnly($field, ['newComment' => 'required|max:255']);
    }

    public function addComment($post_id)
    {
        $this->validate(['newComment' => 'required|max:255']);

        $createdComment = Comment::create([
            'body'              => $this->newComment,
            'post_id'           => $post_id,
            'user_id' => auth()->user()->id,
            'support_ticket_id' => $this->ticketId,
        ]);
        $this->newComment = '';
        session()->flash('message', 'Comment added successfully 😁');
    }


    public function remove($commentId)
    {
        $comment = Comment::find($commentId);
        $comment->delete();
        session()->flash('message', 'Comment deleted successfully 😊');
    }

    public function render()
    {


        $posts = Post::with('comments')
            ->where('user_id','<>',auth()->user()->id)
            ->latest()
             ->paginate(2);

        return view('livewire.comments', [
            'posts' => $posts,
        ]);
    }
}
