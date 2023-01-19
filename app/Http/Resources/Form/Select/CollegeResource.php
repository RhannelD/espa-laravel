<?php

namespace App\Http\Resources\Form\Select;

use App\Http\Resources\Form\Select\ProgramResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;

class CollegeResource extends JsonResource
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
            'college',
            'abbreviation',
        ]) + [
            'programs' => ProgramResource::collection($this->whenLoaded('programs')),
        ];
    }
}
