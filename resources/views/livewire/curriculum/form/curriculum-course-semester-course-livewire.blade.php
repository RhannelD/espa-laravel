<tr id="r-{{ $curriculum_course_id }}">
    <td scope="row">
        {{ $curriculum_course_data->course->code }}
    </td>
    <td scope="row">
        {{ $curriculum_course_data->course->course }}
    </td>
    <td scope="row" class="text-center">
        {{ $curriculum_course_data->course->unit }}
    </td>
    <td scope="row" class="text-center">
        {{ $curriculum_course_data->course->lecture }}
    </td>
    <td scope="row" class="text-center">
        {{ $curriculum_course_data->course->laboratory }}
    </td>
    <td scope="row" class="text-center py-1">
        <input wire:model.lazy="curriculum_course.requisite_standing" type="text" class="form-control" id="requisite_standing_{{ $curriculum_course_id }}">
        @error("curriculum_course.requisite_standing") <small class="text-danger"> {{ $message }} </small> @enderror
    </td>
    <td scope="row" class="text-center">
        <button onclick="delete_curriculum_course({{ $curriculum_course_id }})" type="button"
            class="btn btn-sm my-0 btn-danger">
            <i class="bi bi-dash-circle-fill"></i>
        </button>
    </td>
</tr>