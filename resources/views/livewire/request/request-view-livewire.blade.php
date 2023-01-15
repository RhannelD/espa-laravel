<div>
    <x-card.card>
        <h4 class="card-title pt-0 pb-0">
            <a href="{{ route('student.curriculum', ['user' => $request->user_id]) }}">
                {{ $request->user->flname }}
            </a>
        </h4>
        <div class="row">
            <div>
                {{ $request->user->sr_code }}
            </div>
            <div>
                {{ $request->user->email }}
            </div>
            <div class="text-capitalize">
                {{ $request->user->sex }}
            </div>
        </div>
    </x-card.card>

    <div class="row">
        <div class="col-md-6">
            <x-card.card>
                <h4 class="card-title pt-0 pb-0">
                    Request Info
                </h4>
                <hr>
                <div class="row">
                    <div class="col-12">
                        <div>
                            <label class="form-label">Message</label>
                            <p class="border rounded p-2">
                                {{ $request->message }}
                            </p>
                        </div>
                        <div>
                            <label class="form-label">Attached File/s</label>
                            <div>
                                @foreach ($request->files as $file)
                                    <div class="input-group mb-1">
                                        <span class="input-group-text bg-white pe-2">
                                            @switch($file->extension)
                                                @case('gif')
                                                @case('jpeg')
                                                @case('img')
                                                @case('jpg')
                                                    <i class="bi bi-file-earmark-image"></i>
                                                    @break
                                                @case('pdf')
                                                    <i class="bi bi-file-earmark-pdf-fill"></i>
                                                    @break
                                                @default
                                                    <i class="bi bi-file-earmark-fill"></i>
                                            @endswitch
                                        </span>
                                        @if ($file->if_exists)
                                            <div class="form-control border-start-0 overflow-hidden text-nowrap ps-0">
                                                <a href="{{ route('file', ['file' => $file->id]) }}" target="_blank">
                                                    {{ $file->origname }}
                                                </a>
                                            </div>
                                            <a class="btn btn-secondary" type="button" href="{{ route('file.download', ['file' => $file->id]) }}" target="_blank">
                                                <i class="bi bi-file-earmark-arrow-down-fill"></i>
                                            </a>
                                        @else
                                            <div class="form-control border-start-0 overflow-hidden text-nowrap ps-0">
                                                {{ $file->origname }}
                                            </div>
                                            <span class="btn btn-danger disabled">
                                                <i class="bi bi-file-earmark-x-fill"></i>
                                            </span>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </x-card.card>
            <x-card.card>
                <h4 class="card-title pt-0 pb-0">
                    Response
                </h4>
                <hr>
                <div class="row">
                </div>
            </x-card.card>
        </div>
        <div class="col-md-6">
            @livewire('request.request-view-comment-livewire', ['request_id' => $request_id], key('request-view-comment-livewire'))
        </div>
    </div>
</div>
