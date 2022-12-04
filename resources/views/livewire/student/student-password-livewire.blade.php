<div wire:ignore.self class="modal fade" id="{{ $modal }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form wire:submit.prevent="save" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Password Change</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-12">
                        <label for="studentname" class="form-label">Student Name</label>
                        <input type="text" class="form-control" id="studentname" disabled value="{{ $student_name }}">
                    </div>
                    <div class="col-12" x-data="{show_password: false}">
                        <label for="password" class="form-label">New Password</label>
                        <div class="input-group">
                            <input wire:model.lazy="password" :type="show_password? 'text': 'password'" class="form-control" placeholder="********" aria-label="Password" id="password">
                            <button class="btn btn-primary" type="button" id="password_see" @click="show_password=!show_password">
                                <i class="bi bi-eye-fill"></i>
                            </button>
                        </div>
                        @error('password') <small class="text-danger"> {{ $message }} </small> @enderror
                    </div>
                    <div class="col-12">
                        <hr class="my-0">
                    </div>
                    <div class="col-12" x-data="{show_password: false}">
                        <label for="user_password" class="form-label">Confirm your Password</label>
                        <div class="input-group">
                            <input wire:model.lazy="user_password" :type="show_password? 'text': 'password'" class="form-control" placeholder="********" aria-label="Password" id="user_password">
                            <button class="btn btn-primary" type="button" id="user_password_see" @click="show_password=!show_password">
                                <i class="bi bi-eye-fill"></i>
                            </button>
                        </div>
                        @error('user_password') <small class="text-danger"> {{ $message }} </small> @enderror
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
        </form>
    </div>
</div>