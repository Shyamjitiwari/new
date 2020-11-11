<?php

namespace App\Http\Controllers;

use App\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class BuilderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Builder::class);

        $name = ($request->input('name')) ? $request->input('name') : '';
        $status = ($request->input('status') ? $request->input('status') : '');

        return $this->processResponse('success', 200, null,
            Builder::search('name',$name)
            ->searchStrict('status',$status)
            ->withCount('projects')
            ->paginate(Config::get('settings.pagination')));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     * @throws AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', Builder::class);
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
        $this->authorize('create', Builder::class);

        $request->validate([
            'name' => 'required|unique:builders,name',
        ]);

        $builder = new Builder;
        $builder->name = $request->input('name');
        $builder->status = 'active';
        $builder->created_id = Auth::user()->id;
        $builder->save();

        return $this->processResponse('success',200,'Builder created!',$builder);
    }

    /**
     * Display the specified resource.
     *
     * @param Builder $builder
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function show(Builder $builder)
    {
        $this->authorize('view', $builder);

        return $this->processResponse('success',200,null,$builder);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Builder $builder
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function edit(Builder $builder)
    {
        $this->authorize('update', $builder);

        return $this->processResponse('success',200,null,$builder);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Builder $builder
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function update(Request $request, Builder $builder)
    {
        $this->authorize('update', $builder);

        $request->validate([
            'name' => 'required|unique:builders,name,'.$request->id,
        ]);

        $builder->name = $request->input('name');
        $builder->status = 'active';
        $builder->updated_id = Auth::user()->id;
        $builder->save();

        return $this->processResponse('success',200,'Builder updated!',$builder);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Builder $builder
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Builder $builder)
    {
        $this->authorize('delete', $builder);

        if($builder->projects->count() > 0)
        {
            return $this->processResponse('error',404,'Builder has linked projects, cannot be deleted!',null);
        }

        $builder->delete();

        return $this->processResponse('success',200,'Builder deleted!',$builder);
    }
}
