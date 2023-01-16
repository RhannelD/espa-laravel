<?php

namespace App\Http\Livewire\Request;

use App\Models\Comment;
use App\Models\Request;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class RequestViewCommentLivewire extends Component
{
    public $request_id;

    public $show_row = 4;

    protected $listeners = [
        'refresh' => '$refresh',
        'new_comment' => 'newComment',
    ];

    protected $queryString = [];

    public function mount($request_id)
    {
        $this->request_id = $request_id;
    }

    public function render()
    {
        return view('livewire.request.request-view-comment-livewire', [
            'comments' => $this->getComments(),
        ]);
    }

    protected function getComments()
    {
        $request_id = $this->request_id;
        return Comment::query()
            ->whereHasMorph('commentable', [Request::class], function ($query) use ($request_id) {
                $query->where('id', $request_id);
            })
            ->latest()
            ->paginate($this->show_row);
    }

    public function seeMore()
    {
        $this->show_row += 5;
    }

    public function newComment()
    {
        $this->show_row += 1;
    }

    public function deleteComment($comment_id)
    {
        $comment = Comment::find($comment_id);
        if (Gate::allows('delete', $comment) && $comment->delete()) {
            $this->show_row = $this->show_row <= 4 ? 4 : ($this->show_row - 1);
        }
    }
}
