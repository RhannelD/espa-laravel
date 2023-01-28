<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Gate;

class OfficerResource extends JsonResource
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
            'firstname',
            'lastname',
            'email',
            'sex',
        ]) + [
            'can_delete' => Gate::allows('deleteOfficer', $this->resource),
            'can_update' => Gate::allows('updateOfficer', $this->resource),
            'can_update_password' => Gate::allows('updateOfficerPassword', $this->resource),
            'can_update_access' => Gate::allows('updateOfficerRoleAccess', $this->resource),
        ];
    }
}
