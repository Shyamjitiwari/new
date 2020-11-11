<?php

namespace App\Http\Controllers;

use App\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;


class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //$this->authorize('viewAny', Location::class);

        $name = ($request->name) ? $request->name : '';
        $pincode = ($request->pincode) ? $request->pincode : '';
        $parent = ($request->parent) ? $request->parent : '';
        $status = ($request->status ? $request->status : '');

        $location = Location::search('name',$name)
            ->search('pincode',$pincode)
            ->search('parent_id',$parent)
            ->searchStrict('status',$status)
            ->paginate(Config::get('settings.pagination'));

        return $this->processResponse('success',200,null, $location);
    }

    public function getParentLocations(Request $request)
    {
        $parentLocations = Location::where('status', '!=', 'inactive')->where('parent_id', null)->orderBy('name', 'asc')->get();

        return $this->processResponse('success', 200, null, $parentLocations);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Location::class);
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
        $this->authorize('create', Location::class);

        $request->validate([
            'name' => 'required|unique:locations,name',
       ]);

        $location = new Location;
        $location->name = $request->name;
        $location->parent_id = ($request->parent_id != "") ? $request->parent_id : null;
        $location->address = $request->address;
        $location->pincode = $request->pincode;
        $location->status = 'active';
        $location->created_id = Auth::user()->id;
        $location->save();

        return $this->processResponse('success',200,'Location created!',$location);
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
        $location = Location::find($id);

        $this->authorize('view', $location);

        return $this->processResponse('success',200,null,$location);
    }

    /**
     * Show the form for editing the specified resource.
     *
     *
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function edit($id)
    {
        $location = Location::find($id);

        $this->authorize('update', $location);

        return $this->processResponse('success',200,null,$location);
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
        $location = Location::find($id);

        $this->authorize('update', $location);

        $request->validate([
            'name' => 'required|unique:locations,name,' . $id,

        ]);

        $location->name = $request->name;
        $location->parent_id = ($request->parent_id != "") ? $request->parent_id : null;
        $location->address = $request->address;
        $location->pincode = $request->pincode;
        $location->status = 'active';
        $location->created_id = Auth::user()->id;
        $location->save();

        return $this->processResponse('success',200,'Location updated!',$location);
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
        $location = Location::find($id);

        $this->authorize('delete', $location);

        if($location->projects->count() > 0)
        {
            return $this->processResponse('error',404,'Location has linked projects, cannot be deleted!',null);
        }
        elseif($location->children->count() > 0)
        {
            return $this->processResponse('error',404,'Location has linked child locations, cannot be deleted!',null);
        }
        $location->delete();

        return $this->processResponse('success',200,'Locaton deleted!',$location);
    }
}

