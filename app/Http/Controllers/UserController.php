<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Traits\ProcessResponse;

/**
 * Class UserController
 * @package App\Http\Controllers
 */
class UserController extends Controller
{
    use ProcessResponse;

    public function getUsersForTeamSelection()
    {
        $this->authorize('create', User::class);

        $users = User::whereNotIn('role_id', [1,2, Auth::user()->id])->get();

        return $this->processResponse('success',200,null, $users);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', User::class);

        $name = ($request->name) ? $request->name : '';
        $email = ($request->email) ? $request->email : '';
        $group = ($request->group) ? $request->group : '';
        $status = ($request->status ? $request->status : '');

        $user = User::search('name',$name)
            ->search('email',$email)
            ->searchStrict('user_group_id',$group)
            ->searchStrict('status',$status)
            ->with(['role', 'team', 'user_group'])
            ->paginate(Config::get('settings.pagination'));

        return $this->processResponse('success',200,null, $user);
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
        $this->authorize('create', User::class);

            $request->validate([
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'role_id' => 'required',
                'password' => 'required|min:6',
                'confirm_password' => 'required|same:password',
            ]);

            DB::beginTransaction();

            $user = new User;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->mobile = $request->mobile;
            $user->password = bcrypt($request->password);
            $user->role_id = $request->role_id;
            $user->user_group_id = $request->user_group_id;
            $user->status = 'active';
            $user->created_id = Auth::user()->id;
            $user->save();

            if($request->has('team'))
            {
                User::whereIn('id', $request->team)->update([
                   'parent_id' => $user->id
                ]);
            }

            if($request->get('image_name'))
            {
                //Saving image here
                $file_name = $this->uploadImage($request->get('image_name'), 'users', false, true);

                $user->image_name = $file_name['filename'];
                $user->save();
            }

            DB::commit();

            return $this->processResponse('success',200,'User created!',$user);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function show($id)
    {
        $user = User::with(['role', 'team'])->find($id);

        $this->authorize('view', $user);

        return $this->processResponse('success',200,null,$user);
    }

    /**
     * @param $id
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function edit($id)
    {
        $user = User::with(['role','team'])->find($id);

        $this->authorize('update', $user);

        return $this->processResponse('success',200,null,$user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);

        $this->authorize('update', $user);

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'role_id' => 'required',
        ]);

        DB::beginTransaction();

        $user->name = $request->name;
        $user->email = $request->email;
        $user->mobile = $request->mobile;
        $user->role_id = $request->role_id;
        $user->user_group_id = $request->user_group_id;
        $user->updated_id = Auth::user()->id;
        $user->save();

        User::where('parent_id', $user->id)->update(['parent_id'=> null]);

        if($request->has('team'))
        {
            User::whereIn('id', collect($request->team)->pluck('id')->flatten())->update([
                'parent_id' => $user->id
            ]);
        }

        //get current image if any;
        $current_image = $user->image_name;

        // if old image exists and a new one has been uploaded
        if($current_image && $request->get('image_name'))
        {
            $this->deleteExistingImage('users', $current_image);
            $user->image_name = null;
            $user->save();
        }

        if($request->get('image_name'))
        {
            //Saving image here
            $file_name = $this->uploadImage($request->get('image_name'), 'users', false, true);
            $user->image_name = $file_name['filename'];
            $user->save();
        }

        DB::commit();

        return $this->processResponse('success',200,'User updated!',$user);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function profileupdate(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $request->id,
        ]);

        $user = User::find($request->id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->mobile = $request->mobile;
        $user->save();

        //get current image is any;
        $current_image = $user->image_name;

        // if old image exists and a new one has been uploaded
        if($current_image && $request->get('image_name')) {
            $this->deleteExistingImage('users', $current_image);
            $user->image_name = null;
            $user->save();
        }

        if($request->get('image_name'))
        {
            //Saving image here
            $file_name = $this->uploadImage($request->get('image_name'), 'users', false, true);
            $user->image_name = $file_name['filename'];
            $user->save();
        }

        return $this->processResponse('success',200,'Profile updated!',$user);
    }

    /**
     * @param Request $request
     * @param $id
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function changepassword(Request $request, $id)
    {
        $user = User::find($id);

        $this->authorize('update', $user);

        $request->validate([
            'password' => 'required|min:6'
        ]);

        $user->password = bcrypt($request->password);
        $user->save();

        return $this->processResponse('success',200,'Password updated!',$user);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function changeprofilepassword(Request $request)
    {
        $user = User::find($request->id);

        $request->validate([
            'old_password' => 'required',
            'password' => 'required|min:6',
            'confirm_password' => 'required|same:password',
        ]);

        if (Hash::check($request->old_password, $user->password)) {
            $user->password = bcrypt($request->password);
            $user->save();
            return $user;
        } else {
            $message['old_password'] = "Password does not match!";
            return $message;
        }

        return $this->processResponse('success',200,'Password updated!',null);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function destroy($id)
    {
        $user = User::find($id);

        $this->authorize('delete', $user);

        if($user->assignedLeads->count() > 0)
        {
            return $this->processResponse('success',404,'User has assigned leads, cannot be deleted!',null);
        }
        elseif($user->created_leads->count() > 0)
        {
            return $this->processResponse('success',404,'User has created leads, cannot be deleted!',null);
        }
        elseif($user->created_lead_sources->count() > 0)
        {
            return $this->processResponse('success',404,'User has created leads sources, cannot be deleted!',null);
        }
        elseif($user->created_lead_statuses->count() > 0)
        {
            return $this->processResponse('success',404,'User has created leads statuses, cannot be deleted!',null);
        }
        elseif($user->updated_lead_statuses->count() > 0)
        {
            return $this->processResponse('success',404,'User has updated leads statuses, cannot be deleted!',null);
        }
        elseif($user->updated_lead_sources->count() > 0)
        {
            return $this->processResponse('success',404,'User has updated leads sources, cannot be deleted!',null);
        }
        elseif($user->updated_leads->count() > 0)
        {
            return $this->processResponse('success',404,'User has updated leads, cannot be deleted!',null);
        }
        elseif($user->created_comments->count() > 0)
        {
            return $this->processResponse('success',404,'User has posted comments, cannot be deleted!',null);
        }
        elseif($user->updated_comments->count() > 0)
        {
            return $this->processResponse('success',404,'User has updated comments, cannot be deleted!',null);
        }

        //get current image is any;
        $current_image = $user->image_name;

        // if old image exists
        if ($current_image)
        {
            $this->deleteExistingImage('users', $current_image);
        }

        $user->delete();

        return $this->processResponse('success',200,'User deleted!',$user);
    }
}
