<x-card.card>
    <h4 class="card-title pt-0 pb-0">
        Comments
    </h4>
    <hr>
    <div class="row">
        @if ($comments->lastPage() != 1)
            <div class="col-12 mb-2 d-grid gap-2">
                <button wire:click="seeMore" class="btn btn-primary btn-sm" type="button">
                    See more..
                </button>
            </div>
        @endif
        <div class="col-12">
            @foreach ($comments->sortBy('id') as $comment)
                <div class="border rounded px-2 pt-1 pb-2 mb-1" id="comment-{{ $comment->id }}">
                    <small class="flex-grow-1 d-flex">
                        <span class="fw-bolder">
                            {{ $comment->user->flname }}
                        </span>
                        <span class="ms-auto me-0">
                            {{ $comment->created_at->shortRelativeDiffForHumans() }}
                        </span>
                        @can('delete', $comment)
                            <span class="dropdown ms-1 me-0" id="dropdown-for-comment-{{ $comment->id }}">
                                <a class="" href="#" role="button" id="comment-dropdown-{{ $comment->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-three-dots"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="comment-dropdown-{{ $comment->id }}">
                                    <li><a wire:click="deleteComment({{ $comment->id }})" class="dropdown-item">Delete</a></li>
                                </ul>
                            </span>
                        @endcan
                    </small>
                    <p class="m-0">
                        {{ $comment->comment }}
                    </p>
                </div>
            @endforeach
        </div>
    </div>
    <hr class="my-2">
    <div class="row">
        @livewire('request.request-view-comment-form-livewire', ['request_id' => $request_id], key('request-view-comment-form-livewire'))
    </div>
</x-card.card>