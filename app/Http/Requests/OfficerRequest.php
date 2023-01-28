<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class OfficerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = $this->route('officer');
        $this->user_id = $user->id ?? null;
        return $user ? Gate::allows('updateOfficer', $user) : Gate::allows('createOfficer', User::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'firstname' => "required",
            'lastname' => "required",
            'email' => "required|email|unique:users,email,{$this->user_id},id",
            'sex' => "required|in:male,female",
        ];
    }
}
