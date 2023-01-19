<?php

namespace App\Http\Controllers\Api\Form;

use App\Http\Controllers\Controller;
use App\Http\Resources\Form\Select\CollegeResource;
use App\Http\Resources\Form\Select\ProgramResource;
use App\Models\College;
use App\Models\Program;
use Illuminate\Http\Request;

class SelectController extends Controller
{
    /**
     * Get college for form selection.
     * api param with[array] - to load associate relationships: [programs]
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function college(Request $request)
    {
        $colleges = College::query()
            ->when($request->has('with') && is_array($request->query('with')), function ($query) use ($request) {
                $query->with(array_intersect($request->query('with'), ['programs']));
            })
            ->get();

        return CollegeResource::collection($colleges);
    }

    /**
     * Get program for form selection.
     * api param with[array] - to load associate relationships: [college]
     * api param college_id -  to load all programs under a college.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function program(Request $request)
    {
        $programs = Program::query()
            ->when($request->has('with') && is_array($request->query('with')), function ($query) use ($request) {
                $query->with(array_intersect($request->query('with'), ['college']));
            })
            ->when($request->has('college_id'), function ($query) use ($request) {
                $query->where('college_id', $request->query('college_id'));
            })
            ->get();

        return ProgramResource::collection($programs);
    }
}
