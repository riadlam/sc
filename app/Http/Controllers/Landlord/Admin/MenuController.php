<?php

namespace App\Http\Controllers\Landlord\Admin;

use App\Helpers\ResponseMessage;
use App\Helpers\SanitizeInput;
use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;
use function Clue\StreamFilter\register;
use function GuzzleHttp\Promise\all;

class MenuController extends Controller
{

    public function index()
    {
        $all_menu = Menu::all();
        return view('landlord.admin.menu.menu-index')->with([
            'all_menu' => $all_menu
        ]);
    }

    public function store_new_menu(Request $request)
    {
        $this->validate($request, [
            'content' => 'nullable',
            'title' => 'required',
        ]);

        Menu::create([
            'content' => $request->page_content,
            'title' => $request->title,
        ]);

        return response()->success(__('Menu Created Successfully..'));

    }
    public function edit_menu($id)
    {
        $page_post = Menu::find($id);

        return view('landlord.admin.menu.menu-edit')->with([
            'page_post' => $page_post
        ]);

    }
    public function update_menu(Request $request, $id)
    {
        $this->validate($request, [
            'content' => 'nullable',
            'title' => 'required',
        ]);

        $static_text = $request->validate([
            'default_login_text' => 'nullable|string|min:1',
            'default_logout_text' => 'nullable|string|min:1',
            'default_register_text' => 'nullable|string|min:1',
            'default_dashboard_text' => 'nullable|string|min:1',
            'default_menu_item' => 'nullable|string',
        ]);

        $authArray = [
            get_static_option('default_login_text') ?? 'Login',
            get_static_option('default_register_text') ?? 'Get Started'
        ];
        abort_if(!in_array($static_text['default_menu_item'], $authArray), 403);

        Menu::where('id', $id)->update([
            'content' => $request->menu_content,
            'title' => $request->title,
        ]);

        foreach ($static_text as $key => $item) {
            update_static_option($key, $item);
        }

        return redirect()->back()->with([
            'msg' => __('Menu updated...'),
            'type' => 'success'
        ]);
    }

    public function delete_menu(Request $request, $id)
    {
        Menu::find($id)->delete();
        return redirect()->back()->with([
            'msg' => __('Menu Delete Success...'),
            'type' => 'danger'
        ]);
    }

    public function set_default_menu(Request $request, $id)
    {
        $lang = Menu::find($id);
        Menu::where(['status' => 'default'])->update(['status' => '']);

        Menu::find($id)->update(['status' => 'default']);
        $lang->status = 'default';
        $lang->save();
        return redirect()->back()->with([
            'msg' => __('Default Menu Set To') .' '. SanitizeInput::esc_html($lang->title),
            'type' => 'success'
        ]);
    }


}
