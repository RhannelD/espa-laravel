<tr>
    <td scope="row" class="py-1">
        <select wire:model="grade.grade" class="form-select">
            <option value="" selected>Select</option>
            <option value="1.00">1.00</option>
            <option value="1.25">1.25</option>
            <option value="1.50">1.50</option>
            <option value="1.75">1.75</option>
            <option value="2.00">2.00</option>
            <option value="2.25">2.25</option>
            <option value="2.50">2.50</option>
            <option value="2.75">2.75</option>
            <option value="3.00">3.00</option>
            <option value="INC">INC</option>
            <option value="5.00">5.00</option>
        </select>
        @error('grade.grade') <small class="text-danger"> {{ $message }} </small> @enderror
    </td>
    <td scope="row">
        {{ $course->code }}
    </td>
    <td scope="row">
        {{ $course->course }}
    </td>
    <td scope="row" class="text-center">
        {{ $course->unit }}
    </td>
    <td scope="row" class="text-center">
        {{ $course->lecture }}
    </td>
    <td scope="row" class="text-center">
        {{ $course->laboratory }}
    </td>
    <td class="text-center py-1">
        @if (!empty($grade->grade))
            <button onclick="swal({
                    title: 'Add Grade',
                    text: '',
                    icon: 'warning',
                    buttons: true,
                    dangerMode: false,
                    buttons: ['Cancel', 'Save'],
                }).then((agree) => {
                    if (agree) {
                        @this.save();
                    }
                })"
                type="button" 
                class="btn btn-sm my-0 btn-success">
                <i class="bi bi-save2-fill"></i>
            </button>
        @endif
    </td>
</tr>