<?php

namespace App\Http\Controllers\Tenant\Admin;

use App\Helpers\FlashMsg;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SectionTitleManageController extends Controller
{
    public function index()
    {
        return view('tenant.admin.appearance-settings.section-title-settings');
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'title_shape_image' => 'nullable|integer',
        ]);

        foreach ($data as $key => $item) {
            update_static_option($key, $item);
        }

        return back()->with(FlashMsg::update_succeed('Section Title Shape Image'));
    }
}
