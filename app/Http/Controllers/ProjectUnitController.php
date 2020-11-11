<?php

namespace App\Http\Controllers;

use App\ProjectUnit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class ProjectUnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $this->authorize('viewAny', ProjectUnit::class);

        $type = ($request->type) ? $request->type : '';
        $size = ($request->size) ? $request->size : '';
        $startPrice = ($request->startPrice) ? $request->startPrice : 0;
        $endPrice = ($request->endPrice) ? $request->endPrice : (ProjectUnit::max('price') ? ProjectUnit::max('price') : 0);
        $location = ($request->location ? $request->location : '');
        $status = ($request->status ? $request->status : '');
        $projectUnit = ProjectUnit::with(['project','project.projectLocation', 'project.nearby_location', 'project.projectBuilder'])
            ->searchStrict('type',$type)
            ->searchStrict('size',$size)
            ->searchManyStrict('location_id',$location,'project')
            ->searchStrict('status',$status)
            ->where('price', '>=', $startPrice)
            ->where('price', '<=', $endPrice)
            ->paginate(Config::get('settings.pagination'));

        return $this->processResponse('success',200,null, $projectUnit);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     * @throws AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', ProjectUnit::class);
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
       $this->authorize('create', ProjectUnit::class);

        $request->validate([
            'type' => 'required',
            'price' => 'required',
            'size' => 'required',
            'project_id' => 'required',

        ]);

        $projectUnit = new ProjectUnit;
        $projectUnit->type = $request->type;
        $projectUnit->size = $request->size;
        $projectUnit->price = $request->price;
        $projectUnit->project_id = $request->project_id;
        $projectUnit->sales_type = ($request->sales_type) ? ($request->sales_type): (null);
        $projectUnit->bedroom = ($request->bedroom) ? ($request->bedroom): (0);
        $projectUnit->bathroom = ($request->bathroom) ? ($request->bathroom): (0);
        $projectUnit->balcony = ($request->balcony) ? ($request->balcony): (0);
        $projectUnit->additional_room = ($request->additional_room) ? ($request->additional_room): (0);
        $projectUnit->status = 'active';
        $projectUnit->created_id = Auth::user()->id;
        $projectUnit->save();

        return $this->processResponse('success',200,'Project Unit created!',$projectUnit);
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
        $projectUnit = ProjectUnit::find($id);

        $this->authorize('view', $projectUnit);

        return $this->processResponse('success',200,null,$projectUnit);
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
        $projectUnit = ProjectUnit::find($id);

        $this->authorize('update', $projectUnit);

        return $this->processResponse('success',200,null,$projectUnit);
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
        $projectUnit = ProjectUnit::find($id);

        $this->authorize('update', $projectUnit);


        $request->validate([
            'type' => 'required',
            'price' => 'required',
            'size' => 'required',
            'project_id' => 'required',

        ]);

        $projectUnit->type = $request->type;
        $projectUnit->size = $request->size;
        $projectUnit->price = $request->price;
        $projectUnit->project_id = $request->project_id;
        $projectUnit->sales_type = ($request->sales_type) ? ($request->sales_type): (null);
        $projectUnit->bedroom = ($request->bedroom) ? ($request->bedroom): (0);
        $projectUnit->bathroom = ($request->bathroom) ? ($request->bathroom): (0);
        $projectUnit->balcony = ($request->balcony) ? ($request->balcony): (0);
        $projectUnit->additional_room = ($request->additional_room) ? ($request->additional_room): (0);
        $projectUnit->status = 'active';
        $projectUnit->created_id = Auth::user()->id;
        $projectUnit->save();

        return $this->processResponse('success',200,'Project updated!',$projectUnit);
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
        $projectUnit = ProjectUnit::find($id);

        $this->authorize('delete', $projectUnit);

//        if($project->leads->count() > 0)
//        {
//            return $this->processResponse('success',404,'Project has linked leads, cannot be deleted!',null);
//        }

        $projectUnit->delete();

        return $this->processResponse('success',200,'Project Unit deleted!',$projectUnit);
    }
}
