<?php

namespace App\Http\Livewire\Course;

use App\Models\Course;
use App\Traits\AlertTrait;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class CourseFormLivewire extends Component
{
    use AuthorizesRequests;
    use AlertTrait;

    public $course_id;
    public $course;

    protected function rules()
    {
        return [
            'course.code' => "required|unique:courses,code,{$this->course_id},id",
            'course.course' => "required|unique:courses,course,{$this->course_id},id",
            'course.unit' => "required|numeric|min:1",
            'course.lecture' => "required|numeric|min:0",
            'course.laboratory' => "required|numeric|min:0",
        ];
    }

    public function mount($course_id=null)
    {
        $this->course_id = $course_id;
        $course = Course::find($course_id);
        
        abort_if(isset($course_id) && is_null($course), 404);
        $this->authorize(is_null($course_id)? 'create': 'update', is_null($course_id)? Course::class: $course);

        $this->course = $course? $course->replicate(): new Course;
    }

    public function render()
    {
        return view('livewire.course.course-form-livewire')->extends('layouts.app', [
            'active_nav' => 'course',
            'title' => (is_null($this->course_id)? 'Create': 'Update').' Course',
            'breadcrumbs' => [
                [
                    'link' => route('course'),
                    'label' => 'Course',
                ], [
                    'label' => is_null($this->course_id)? 'Create': 'Update',
                    'active' => true,
                ],
            ],
        ]);
    }

    public function updated($property)
    {
        $this->validateOnly($property);
    }

    public function save()
    {
        $data = $this->validate();

        $redirect = isset($this->course_id)
            ? $this->update($data)
            : $this->store($data);

        if ($redirect) {
            return redirect()->route('course');
        }
    }

    protected function store($data)
    {
        if ( Gate::denies('create', Course::class) ) {
            return;
        }
        
        $course = Course::create($data['course']);
    
        if ( $course->wasRecentlyCreated ) {
            $this->session_flash_alert_info('Success!', 'Record has been successfully added');
            return true;
        }
    }

    protected function update($data)
    {
        $course = Course::find($this->course_id);
        if ( Gate::allows('update', $course) && $course->update($data['course']) ) {
            $this->session_flash_alert_info('Success!', 'Record has been successfully updated');
            return true;
        }
    }
}
