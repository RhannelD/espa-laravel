<?php

namespace App\Http\Livewire\Request;

use App\Models\Comment;
use App\Models\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class RequestViewCommentFormLivewire extends Component
{
    public $request_id;
    public $comment;

    protected $rules = [
        'comment.comment' => 'required|max:255',
    ];

    public function mount($request_id)
    {
        $this->request_id = $request_id;
        $this->comment = new Comment;
    }

    public function render()
    {
        return view('livewire.request.request-view-comment-form-livewire');
    }

    protected function getRequest()
    {
        return Request::find($this->request_id);
    }

    public function comment()
    {
        $data = $this->validate();

        $request = $this->getRequest();
        
        if (Gate::denies('comment', $request)) {
            return;
        }

        $comment = $request->comments()->create($data['comment'] + [
            'user_id' => Auth::id(),
        ]);

        if ($comment->wasRecentlyCreated) {
            $this->emitUp('new_comment');
            $this->comment = new Comment;
        }
    }
}
