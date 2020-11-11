<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Project::class);

        $name = ($request->name) ? $request->name : '';
        $builder = ($request->builder) ? $request->builder : '';
        $city = ($request->city) ? $request->city : '';
        $status = ($request->status ? $request->status : '');

        $project = Project::with(['builder', 'location', 'nearby_location' ])
            ->search('name',$name)
            ->search('builder_id',$builder)
            ->search('city',$city)
            ->searchStrict('status',$status)
            ->withCount('leadhistories')
            ->paginate(Config::get('settings.pagination'));

        return $this->processResponse('success',200,null, $project);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     * @throws AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', Project::class);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function store(Request $request)
    {
        $this->authorize('create', Project::class);

        $request->validate([
            'name' => 'required|unique:projects,name',
            'builder_id' => 'required',
            'completion_status' => 'required',
            'address' => 'required',
            'location_id' => 'required',
            'city' => 'required',
            'state' => 'required',
            'pincode' => 'required',
        ]);

        $project = new Project;
        $project->name = $request->name;
        $project->builder_id = $request->builder_id;
        $project->completion_status = $request->completion_status;
        $project->address = $request->address;
        $project->location_id = $request->location_id;
        $project->city = $request->city;
        $project->state = $request->state;
        $project->pincode = $request->pincode;
        $project->possession = ($request->possession) ? ($request->possession):(null);
        $project->distance_in_kms = ($request->distance_in_kms) ? ($request->distance_in_kms):(null);
        $project->nearby_location_id = ($request->nearby_location_id) ? ($request->nearby_location_id):(null);
        $project->status = 'active';
        $project->created_id = Auth::user()->id;
        $project->save();

        return $this->processResponse('success',200,'Project created!',$project);
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function show($id)
    {
        $project = Project::find($id);

        $this->authorize('view', $project);

        return $this->processResponse('success',200,null,$project);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Project $project
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function edit($id)
    {
        $project = Project::find($id);

        $this->authorize('update', $project);

        return $this->processResponse('success',200,null,$project);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param $id
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function update(Request $request, $id)
    {
        $project = Project::find($id);

        $this->authorize('update', $project);

        $request->validate([
            'name' => 'required|unique:projects,name,' . $id,
            'builder_id' => 'required',
            'completion_status' => 'required',
            'address' => 'required',
            'location_id' => 'required',
            'city' => 'required',
            'state' => 'required',
            'pincode' => 'required',
        ]);

        $project->name = $request->name;
        $project->builder_id = $request->builder_id;
        $project->completion_status = $request->completion_status;
        $project->address = $request->address;
        $project->location_id = $request->location_id;
        $project->city = $request->city;
        $project->state = $request->state;
        $project->pincode = $request->pincode;
        $project->possession = ($request->possession) ? ($request->possession):(null);
        $project->distance_in_kms = ($request->distance_in_kms) ? ($request->distance_in_kms):(null);
        $project->nearby_location_id = ($request->nearby_location_id) ? ($request->nearby_location_id):(null);
        $project->status = 'active';
        $project->created_id = Auth::user()->id;
        $project->save();

        return $this->processResponse('success',200,'Project updated!',$project);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function destroy($id)
    {
        $project = Project::find($id);

        $this->authorize('delete', $project);

    //    if($project->leads->count() > 0)
    //    {
    //        return $this->processResponse('success',404,'Project has linked leads, cannot be deleted!',null);
    //    }

        $project->delete();

        return $this->processResponse('success',200,'Project deleted!',$project);
    }
}
