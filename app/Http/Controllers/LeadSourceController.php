<?php

namespace App\Http\Controllers;

use App\LeadSource;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class LeadSourceController extends Controller
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
        $this->authorize('viewAny', LeadSource::class);

        $name = ($request->input('name')) ? $request->input('name') : '';
        $status = ($request->input('status') ? $request->input('status') : '');

        return $this->processResponse('success', 200, null,
            LeadSource::search('name',$name)
            ->searchStrict('status',$status)
            ->withCount('leads')
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
        $this->authorize('create', LeadSource::class);
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
        $this->authorize('create', LeadSource::class);

        $request->validate([
            'name' => 'required|unique:lead_sources,name',
        ]);

        $leadSource = new LeadSource;
        $leadSource->name = $request->input('name');
        $leadSource->status = 'active';
        $leadSource->created_id = Auth::user()->id;
        $leadSource->save();

        return $this->processResponse('success',200,'Lead Source created!',$leadSource);
    }

    /**
     * Display the specified resource.
     *
     * @param LeadSource $leadSource
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function show(LeadSource $leadSource)
    {
        $this->authorize('view', $leadSource);

        return $this->processResponse('success',200,null,$leadSource);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param LeadSource $leadSource
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function edit(LeadSource $leadSource)
    {
        $this->authorize('update', $leadSource);

        return $this->processResponse('success',200,null,$leadSource);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param LeadSource $leadSource
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function update(Request $request, LeadSource $leadSource)
    {
        $this->authorize('update', $leadSource);

        $request->validate([
            'name' => 'required|unique:lead_sources,name,'.$request->id,
        ]);

        $leadSource->name = $request->input('name');
        $leadSource->status = 'active';
        $leadSource->updated_id = Auth::user()->id;
        $leadSource->save();

        return $this->processResponse('success',200,'Lead Source created!',$leadSource);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param LeadSource $leadSource
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(LeadSource $leadSource)
    {
        $this->authorize('delete', $leadSource);

        if($leadSource->leads->count() > 0)
        {
            return $this->processResponse('error',404,'Lead Source has linked leads, cannot be deleted!',null);
        }

        $leadSource->delete();

        return $this->processResponse('success',200,'Lead Source deleted!',$leadSource);
    }
}
