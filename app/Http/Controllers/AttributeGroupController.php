<?php

namespace App\Http\Controllers;

use App\AttributeGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class AttributeGroupController extends Controller
{
    public function attributeGroups()
    {
        //$this->authorize('viewAny', Attribute::class);

        return view('cp.attribute_groups');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       // $this->authorize('viewAny', Attribute::class);

        if(Auth::user()->isSuperAdmin() || Auth::user()->isAdmin())
        {
            $attributeGroups = AttributeGroup::paginate(Config::get('settings.pagination'));
        } else {
            $attributeGroups = AttributeGroup::where('created_id', Auth::id())
                ->paginate(Config::get('settings.pagination'));
        }

        return $this->processResponse('attributeGroup', $attributeGroups,null,'success', 200);
        
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!$request->input('id')) {
            //$this->authorize('create', AttributeGroup::class);

            $request->validate([
                'name' => 'required|unique:attribute_groups,name',
                'description' => 'required',
                'sort' => 'required',
                'created_id' => 'required'
            ]);
        } else {
            //$this->authorize('update', AttributeGroup::find($request->input('id')));

            $request->validate([
                'name' => 'required|unique:attribute_groups,name,'.$request->input('id'),
                'description' => 'required',
                'sort' => 'required',
                'created_id' => 'required'
            ]);
        }

        DB::beginTransaction();

        $attributeGroup = AttributeGroup::updateOrCreate(
            ['id' => $request->input('id')],
            [
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'sort' => $request->input('sort'),
                'created_id' => $request->input('created_id'),
                'updated_id' => Auth::id(),
            ]);


        DB::commit();

        return $this->processResponse('attributeGroup', $attributeGroup, null, 'success', 200);
    }

    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Attributes  $attributes
     * @return \Illuminate\Http\Response
     */
    public function destroy(AttributeGroup $attributeGroup)
    {
        
       // $this->authorize('delete', $attribute);

        $attributeGroup->delete();

        return $this->processResponse('data', null, 'Attribute Group deleted successfully!', 'success', 200);
    }
}
