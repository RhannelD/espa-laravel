<tr @class([
        'table-danger' => $grade->is_failed,
        'table-success' => $grade->is_passed,
    ])> 
    <td scope="row" class="text-center">
        @if ($grade->is_failed)
            <span class="text-danger">{{ $grade->grade }}</span>
        @else
            {{ $grade->grade }}
        @endif
    </td>
    <td scope="row">
        {{ $grade->course->code }}
    </td>
    <td scope="row">
        {{ $grade->course->course }}
    </td>
    <td scope="row" class="text-center">
        {{ $grade->course->unit }}
    </td>
    <td scope="row" class="text-center">
        {{ $grade->course->lecture }}
    </td>
    <td scope="row" class="text-center">
        {{ $grade->course->laboratory }}
    </td>
    <td class="text-center py-1">
        @can('deleteStudentGrade', $grade->user)
            <button onclick="delete_grade({{ $grade_id }})" type="button" class="btn btn-sm my-0 btn-danger">
                <i class="bi bi-trash-fill"></i>
            </button>
        @endcan
    </td>
</tr>