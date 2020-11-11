<?php

namespace App\Http\Controllers;

use App\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class MenuController extends Controller
{
    public function menus(){

        return view('cp.menus');
    }

    public function index()
    {
        
        //$this->authorize('viewAny', Menu::class);

        if(Auth::user()->isSuperAdmin() || Auth::user()->isAdmin())
        {
            
            $menus = Menu::with(['image'])->paginate(Config::get('settings.pagination'));
        } else {
            $menus = Menu::with(['image'])
                ->where('created_id', Auth::id())
                ->paginate(Config::get('settings.pagination'));
        }

        return $this->processResponse('menus', $menus,null,'success', 200);
    }

    public function store(Request $request, CRUDController $controller)
    {
        if(!$request->input('id')) {
           // $this->authorize('create', Page::class);

            $request->validate([
                'name' => 'required|unique:menus,name',
                'created_id' => 'required'
            ]);
        } else {
           // $this->authorize('update', Page::find($request->input('id')));

            $request->validate([
                'name' => 'required|unique:menus,name,'.$request->input('id'),
                'created_id' => 'required'
            ]);
        }

        DB::beginTransaction();

        $menu = Page::updateOrCreate(
            ['id' => $request->input('id')],
            [
                'name' => $request->input('name'),
                'slug' => !$request->input('id')
                    ? $this->slugify($request->input('name'),'menus')
                    : $this->slugify($request->input('slug'),'menus', $request->input('id')),
                'page_id' => $request->input('page_id'),
                'target' => $request->input('target'),
                'created_id' => $request->input('created_id'),
                'updated_id' => Auth::id(),
            ]);

            //Uploading & linking image here
            $request->input('image_name')
                ? $controller->storeImage($request->get('image_name'), $menu, 'menus', true, true, true)
                : null;

        DB::commit();

        return $this->processResponse('menu', $menu, null, 'success', 200);
    }

    public function deleteImage(Menu $menu, CRUDController $controller)
    {
        $controller->detachImageForSingleImageModels($menu);

        return $this->processResponse(null, null, 'Image deleted!', 'success', 200);
    }

    public function destroy(Menu $menu)
    {
       // $this->authorize('delete', $page);

        $menu->delete();

        return $this->processResponse('data', null, 'Menu delete successfully!', 'success', 200);
    }


}
