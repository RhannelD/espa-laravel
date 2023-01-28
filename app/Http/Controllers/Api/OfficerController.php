<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\OfficerRequest;
use App\Http\Resources\OfficerResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class OfficerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $officers = User::query()
            ->search(request()->search)
            ->isOfficer()
            ->paginate(request()->row ?? 10);

        return OfficerResource::collection($officers)->additional([
            'can_create' => Gate::allows('createOfficer', User::class),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OfficerRequest $request)
    {
        $officer = User::create($request->validated());

        return new OfficerResource($officer);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $officer)
    {
        $this->authorize('viewOfficer', $officer);

        return new OfficerResource($officer);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(OfficerRequest $request, User $officer)
    {
        $officer->update($request->validated());

        return new OfficerResource($officer);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $officer)
    {
        $this->authorize('deleteOfficer', $officer);

        $officer->delete();
    }
}
