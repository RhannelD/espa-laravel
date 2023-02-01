<?php

namespace App\Http\Requests;

use App\Models\User;
use App\Rules\SrCodeRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class StudentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = $this->route('student');
        $this->user_id = $user->id ?? null;
        return $user ? Gate::allows('updateStudent', $user) : Gate::allows('createStudent', User::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'sr_code' => ["required", "unique:users,sr_code,{$this->user_id},id", new SrCodeRule],
            'firstname' => "required",
            'lastname' => "required",
            'email' => "required|email|unique:users,email,{$this->user_id},id",
            'sex' => "required|in:male,female",
        ];
    }
}
