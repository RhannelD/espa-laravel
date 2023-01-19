<?php

namespace App\Http\Requests;

use App\Models\Program;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class ProgramRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $program = $this->route('program');
        $this->program_id = $program->id ?? null;
        return $program ? Gate::allows('update', $program) : Gate::allows('create', Program::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'college_id' => "required|exists:colleges,id",
            'abbreviation' => "required|unique:programs,abbreviation,{$this->program_id},id",
            'program' => "required|unique:programs,program,{$this->program_id},id",
        ];
    }

    /**
     * Change validation attribute name upon error message.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'college_id' => 'college',
        ];
    }
}
