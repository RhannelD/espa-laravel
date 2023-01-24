<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Gate;

class CourseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return Arr::only(parent::toArray($request), [
            'id',
            'code',
            'course',
            'unit',
            'lecture',
            'laboratory',
        ]) + [
            'can_delete' => Gate::allows('delete', $this->resource),
            'can_update' => Gate::allows('update', $this->resource),
        ];
    }
}
