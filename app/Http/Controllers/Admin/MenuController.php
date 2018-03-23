<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMenu;
use Illuminate\Http\Request;
use App\Setting;
use App\Menu;
use Auth;

class MenuController extends Controller
{

    public function api($all = null)
    {
        if($all){
            return Menu::with('sm')->where('primary_menu', null)->orderBy('position')->get()->transform(function($item){
                return ['sm' => collect($item->sm)->sortBy('position')->values() ] + collect($item)->toArray();
            }); 
        }
        $menu = Menu::with('sm')->where('primary_menu', null)->orderBy('position')->get()->transform(function($item){
            if(Auth::user()){
                return ['sm' => collect($item->sm)->sortBy('position')->values() ] + collect($item)->toArray();
            }
            return ['sm' => collect($item->sm)->where('user_login', '0')->sortBy('position')->values() ] + collect($item)->toArray();
        });
        if(Auth::user()){
            return $menu;
        }
        return $menu->where('user_login', '0');
    }

    public function fontType()
    {
        return Setting::where('key', 'font')->first()->value;
    }

    public function index()
    {
    	$oper = [
    		'data' => Menu::with('sm')->where('primary_menu', null)->orderBy('position')->get(),
    		'i' => 1,
            'font_type' => Setting::where('key', 'font')->first()->value
        ];
        return view('admin.menus.index', $oper);
    }

    public function store(StoreMenu $r)
    {
    	$menu = Menu::where('primary_menu', null)->orderBy('position', 'desc')->first();
    	$position = $menu ? $menu->position+1 : 1;
    	Menu::create([
    		'name' => $r->name,
    		'url' => $r->url,
    		'position' => $position,
            'user_login' => $r->user_login
        ]);
    	return response('Menu berhasil ditambahkan');
    }

    public function update($id, StoreMenu $r)
    {
    	Menu::find($id)->update([
    		'name' => $r->name,
    		'url' => $r->url,
            'user_login' => $r->user_login
        ]);
    	return response('Menu berhasil diperbarui');
    }

    public function delete($id)
    {
    	$menu = Menu::find($id);
        $res = 'Sub Menu berhasil dihapus';
        $prim = $menu->primary_menu;
        $menu->delete();
        if(!$prim){
            $res = 'Menu berhasil dihapus';
            $i = 1;
            foreach(Menu::utama() as $m){
                Menu::find($m->id)->update([
                    'position' => $i++
                ]); 
            }   
        }else{
            $i = 1;
            foreach(Menu::subMenu($prim) as $m){
                Menu::find($m->id)->update([
                    'position' => $i++
                ]); 
            }   
        }
        return response($res);
    }

    public function storeSubMenu($id, StoreMenu $r)
    {
    	$menu = Menu::with('sm')->where('id', $id)->first();
    	$position = count($menu->sm) ? collect($menu->sm)->sortByDesc('position')->first()->position+1 : 1;
    	Menu::create([
    		'name' => $r->name,
    		'url' => $r->url,
    		'position' => $position,
    		'primary_menu' => $id,
            'user_login' => $r->user_login
        ]);
    	return response('Sub Menu berhasil ditambahkan');
    }

    public function updateSubMenu($id, StoreMenu $r)
    {
        Menu::find($id)->update([
            'name' => $r->name,
            'url' => $r->url,
            'user_login' => $r->user_login
        ]);
        return response('Sub Menu berhasil diperbarui');
    }

    public function geser($id, $arah, $prim = null)
    {
        $res = 'Sub Menu berhasil digeser';
        if(!$prim){
            $res = 'Menu berhasil digeser';
        }
        $menu = Menu::find($id);
        $pos = $arah == 'bawah' ? $menu->position+1 : $menu->position-1;
        Menu::where('position', $pos)->where('primary_menu', $prim)->update([
            'position' => $menu->position
        ]);
        $menu->update([
            'position' => $pos
        ]);
        return $res;
    }

    public function changeFont(Request $r)
    {
        Setting::updateOrCreate([
            'key' => 'font'
        ], [
            'value' => $r->font_type
        ]);
        return 'Jenis Font berhasil diperbarui';
    }
}
