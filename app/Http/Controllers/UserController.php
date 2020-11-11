<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function users()
    {
        return view('cp.users');
    }
    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        $users = User::with('role')->paginate(10);

        return $this->processResponse('users', $users,null,'success', 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        if(!$request->input('id')) {
            $request->validate([
                'name' => 'required',
                'email' => 'required|unique:users,email',
                'role_id' => 'required',
                'password' => 'required',
            ]);
            $message = 'User created!';
        } else {
            $request->validate([
                'name' => 'required',
                'email' => 'required|unique:users,email,'.$request->input('id'),
                'role_id' => 'required',
            ]);
            $message = 'User updated!';
        }

        DB::beginTransaction();

        $user = User::updateOrCreate(
            ['id' => $request->input('id')],
            [
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'mobile' => $request->input('mobile'),
                'password' => bcrypt($request->input('password')),
                'role_id' => $request->input('role_id'),
            ]);

        DB::commit();

        return $this->processResponse('user', $user, $message, 'success', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return JsonResponse
     */
    public function destroy(User $user)
    {
        if($user->role_id == 1)
        {
            return $this->processResponse('data', null, 'User is a Super Admin, cannot be deleted!', 'error', 404);
        }
        else if($user->categories_created()->count())
        {
            return $this->processResponse('data', null, 'User has created categories, cannot be deleted!', 'error', 404);
        }
        else if($user->categories_updated()->count())
        {
            return $this->processResponse('data', null, 'User has updated categories, cannot be deleted!', 'error', 404);
        }
        else if($user->tags_created()->count())
        {
            return $this->processResponse('data', null, 'User has created tags, cannot be deleted!', 'error', 404);
        }
        else if($user->tags_updated()->count())
        {
            return $this->processResponse('data', null, 'User has updated tags, cannot be deleted!', 'error', 404);
        }
        else if($user->blogs_created()->count())
        {
            return $this->processResponse('data', null, 'User has created blogs, cannot be deleted!', 'error', 404);
        }
        else if($user->blogs_updated()->count())
        {
            return $this->processResponse('data', null, 'User has updated blogs, cannot be deleted!', 'error', 404);
        }

        $user->delete();

        return $this->processResponse('data', null, 'User delete successfully!', 'success', 200);

    }
}
