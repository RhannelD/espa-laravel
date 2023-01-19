<?php

namespace App\Http\Resources\Form\Select;

use App\Http\Resources\Form\Select\CollegeResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;

class ProgramResource extends JsonResource
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
            'college_id',
            'program',
            'abbreviation',
        ]) + [
            'college' => new CollegeResource($this->whenLoaded('college')),
        ];
    }
}
