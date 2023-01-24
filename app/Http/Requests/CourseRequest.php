<?php

namespace App\Http\Requests;

use App\Models\Course;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class CourseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $course = $this->route('course');
        $this->course_id = $course->id ?? null;
        return $course ? Gate::allows('update', $course) : Gate::allows('create', Course::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'code' => "required|unique:courses,code,{$this->course_id},id",
            'course' => "required|unique:courses,course,{$this->course_id},id",
            'unit' => "required|numeric|min:1",
            'lecture' => "required|numeric|min:0",
            'laboratory' => "required|numeric|min:0",
        ];
    }
}
