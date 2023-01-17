<?php

namespace App\Http\Requests;

use App\Models\College;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class CollegeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $college = $this->route('college');
        $this->college_id = $college->id ?? null;
        return $college ? Gate::allows('update', $college) : Gate::allows('create', College::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'abbreviation' => "required|unique:colleges,abbreviation,{$this->college_id},id",
            'college' => "required|unique:colleges,college,{$this->college_id},id",
        ];
    }
}
