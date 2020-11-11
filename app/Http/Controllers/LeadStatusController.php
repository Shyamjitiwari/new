<?php

namespace App\Http\Controllers;

use App\Lead;
use App\LeadStatus;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class LeadStatusController extends Controller
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
        $this->authorize('viewAny', LeadStatus::class);

        $name = ($request->input('name')) ? $request->input('name') : '';
        $parent = ($request->input('parent')) ? $request->input('parent') : '';
        $status = ($request->input('status') ? $request->input('status') : '');

        $leadStatus = LeadStatus::search('name',$name)
            ->searchStrict('status',$status)
            ->searchMany('name',$parent, 'parent')
            ->with('parent')
            ->withCount('leads')
            ->paginate(Config::get('settings.pagination'));

        return $this->processResponse('success', 200, null,$leadStatus);

    }

    public function getActiveLeadStatuses()
    {
        $leadStatuses = LeadStatus::where('status', 'active')->get();

        return $this->processResponse('success', 200, null, $leadStatuses);
    }

    public function getParentLeadStatus(Request $request)
    {
        $parentLeadStatuses = LeadStatus::where('status', '!=', 'inactive')->where('parent_id', null)->orderBy('name', 'asc')->get();

        return $this->processResponse('success', 200, null, $parentLeadStatuses);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     * @throws AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', LeadStatus::class);
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
        $this->authorize('create', LeadStatus::class);

        $request->validate([
            'name' => 'required|unique:lead_sources,name',
            'bg' => 'required',
            'text' => 'required',
        ]);

        $leadStatus = new LeadStatus;
        $leadStatus->name = $request->input('name');
        $leadStatus->parent_id = $request->input('parent_id');
        $leadStatus->bg = $request->input('bg');
        $leadStatus->text = $request->input('text');
        $leadStatus->status = 'active';
        $leadStatus->created_id = Auth::user()->id;
        $leadStatus->save();

        return $this->processResponse('success',200,'Lead Status created!',$leadStatus);
    }

    /**
     * Display the specified resource.
     *
     * @param LeadStatus $leadStatus
     * @return LeadStatus
     * @throws AuthorizationException
     */
    public function show(LeadStatus $leadStatus)
    {
        $this->authorize('view', $leadStatus);

        return $this->processResponse('success',200,null,$leadStatus);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param LeadStatus $leadStatus
     * @return LeadStatus
     * @throws AuthorizationException
     */
    public function edit(LeadStatus $leadStatus)
    {
        $this->authorize('update', $leadStatus);

        return $this->processResponse('success',200,null,$leadStatus);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param LeadStatus $leadStatus
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function update(Request $request, LeadStatus $leadStatus)
    {
        $this->authorize('update', $leadStatus);

        $request->validate([
            'name' => 'required|unique:lead_sources,name,'.$request->id,
            'bg' => 'required',
            'text' => 'required',
        ]);

        $leadStatus->name = $request->input('name');
        $leadStatus->parent_id = $request->input('parent_id');
        $leadStatus->bg = $request->input('bg');
        $leadStatus->text = $request->input('text');
        $leadStatus->status = 'active';
        $leadStatus->updated_id = Auth::user()->id;
        $leadStatus->save();

        return $this->processResponse('success',200,'Lead Status updated!',$leadStatus);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param LeadStatus $leadStatus
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy(LeadStatus $leadStatus)
    {
        $this->authorize('delete', $leadStatus);

        if($leadStatus->children->count() > 0)
        {
            return $this->processResponse('error',404,'Lead Status has linked children, cannot be deleted!',null);
        }
        if($leadStatus->leads->count() > 0)
        {
            return $this->processResponse('error',404,'Lead Status has linked leads, cannot be deleted!',null);
        }

        $leadStatus->delete();

        return $this->processResponse('success',200,'Lead Status deleted!',$leadStatus);
    }
}
