<?php

namespace App\Http\Controllers\Tenant\Admin;

use App\Helpers\FlashMsg;
use App\Helpers\SanitizeInput;
use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\TopbarInfo;
use Illuminate\Http\Request;

class TopbarController extends Controller
{
    public function index(){
        $topbar_menu = get_static_option('topbar_menu');
        return view('tenant.admin.pages.topbar-settings')->with([
            'topbar_menu' => $topbar_menu,
        ]);
    }

    public function update_topbar(Request $request)
    {
        $request->validate([
            'topbar_menu' => 'required'
        ]);

        update_static_option('topbar_menu', $request->topbar_menu);

        return redirect()->back()->with(FlashMsg::update_succeed(__('Topbar')));
    }

    public function new_social_item(Request $request){
        $data = $this->validate($request,[
            'icon' => 'required|string',
            'url' => 'required|string',
        ]);

        $data['url'] = SanitizeInput::esc_html($data['url']);

        TopbarInfo::create($data);

        return redirect()->back()->with([
            'msg' => __('New Social Item Added...'),
            'type' => 'success'
        ]);
    }
    public function update_social_item(Request $request){
        $data = $this->validate($request,[
            'icon' => 'required|string',
            'url' => 'required|string',
        ]);

        $data['url'] = SanitizeInput::esc_html($data['url']);

        TopbarInfo::find($request->id)->update($data);
        return redirect()->back()->with([
            'msg' => __('Social Item Updated...'),
            'type' => 'success'
        ]);
    }
    public function delete_social_item(Request $request,$id){
        TopbarInfo::find($id)->delete();
        return redirect()->back()->with([
            'msg' => __('Social Item Deleted...'),
            'type' => 'danger'
        ]);
    }
}
