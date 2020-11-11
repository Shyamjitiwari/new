<?php

namespace App\Http\Controllers;

use App\Attribute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class AttributeController extends Controller
{
    public function attributes()
    {
        //$this->authorize('viewAny', Attribute::class);

        return view('cp.attributes');
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
            $attributes = Attribute::with(['attribute_group'])->paginate(Config::get('settings.pagination'));
        } else {
            $attributes = Attribute::with(['attribute_group'])
                ->where('created_id', Auth::id())
                ->paginate(Config::get('settings.pagination'));
        }

        return $this->processResponse('attribute', $attributes,null,'success', 200);
        
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
            //$this->authorize('create', Attribute::class);

            $request->validate([
                'name' => 'required|unique:attributes,name',
                'description' => 'required',
                'attribute_group_id' => 'required',
                'sort' => 'required',
                'created_id' => 'required'
            ]);
        } else {
            //$this->authorize('update', Attribute::find($request->input('id')));

            $request->validate([
                'name' => 'required|unique:attributes,name,'.$request->input('id'),
                'description' => 'required',
                'attribute_group_id' => 'required',
                'sort' => 'required',
                'created_id' => 'required'
            ]);
        }

        DB::beginTransaction();

        $attribute = Attribute::updateOrCreate(
            ['id' => $request->input('id')],
            [
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'attribute_group_id' => $request->input('attribute_group_id'),
                'sort' => $request->input('sort'),
                'created_id' => $request->input('created_id'),
                'updated_id' => Auth::id(),
            ]);


        DB::commit();

        return $this->processResponse('attribute', $attribute, null, 'success', 200);
    }

    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Attributes  $attributes
     * @return \Illuminate\Http\Response
     */
    public function destroy(Attribute $attribute)
    {
        
       // $this->authorize('delete', $attribute);

        $attribute->delete();

        return $this->processResponse('data', null, 'Attribute deleted successfully!', 'success', 200);
    }
}
