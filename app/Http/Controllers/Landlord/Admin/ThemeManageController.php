<?php

namespace App\Http\Controllers\Landlord\Admin;

use App\Facades\ThemeDataFacade;
use App\Helpers\ResponseMessage;
use App\Helpers\SanitizeInput;
use App\Http\Controllers\Controller;
use App\Models\Themes;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;

class ThemeManageController extends Controller
{
    public function __construct()
    {

    }

    public function all_theme()
    {
        $all_themes = Themes::orderBy('id', 'asc')->get();
        return view('landlord.admin.themes.index', compact('all_themes'));
    }

    public function update_status(Request $request)
    {
        $data = $request->validate([
            'slug' => 'required'
        ]);

        $theme_file = '';
        $filePath =  theme_path($data['slug']).'/theme.json';
        if (file_exists($filePath) && !is_dir($filePath)){
            //cache data for 10days
            $theme_file = json_decode(file_get_contents($filePath), false);

            if (!empty($theme_file))
            {
                $theme_file->status = !$theme_file->status;
                file_put_contents($filePath ,json_encode($theme_file));
            }
        }

        $status = $theme_file->status ? 'inactive' : 'active';
        return response()->json([
            'status' => $theme_file->status,
            'msg' => __('The theme is '.$status.' successfully')
        ]);
    }

    public function update_theme(Request $request)
    {
        $theme_data = [
            'theme_slug' => 'required',
            'theme_name' => 'nullable',
            'theme_description' => 'nullable',
            'theme_url' => 'nullable',
            'theme_image' => 'nullable'
        ];
        $this->validate($request, $theme_data);
        $image_id = $request->theme_image;

        $image = get_attachment_image_by_id($request->theme_image);
        $image_url = !empty($image) ? $image['img_url'] : '';

        unset($theme_data['theme_slug']);
        $request['theme_image'] = $image_url;

        foreach ($theme_data as $field_name => $rules){
            update_static_option_central($request->theme_slug.'_'.$field_name, $request->$field_name);
        }
        update_static_option_central($request->theme_slug.'_theme_image_id', $image_id);

        return response()->success(ResponseMessage::SettingsSaved());
    }

    public function theme_settings()
    {
        return view('landlord.admin.themes.settings');
    }

    public function theme_settings_update(Request $request)
    {
            $this->validate($request, [
                'up_coming_themes_backend' => 'nullable|string',
                'up_coming_themes_frontend' => 'nullable|string',
            ]);

            update_static_option('up_coming_themes_backend', $request->up_coming_themes_backend);
            update_static_option('up_coming_themes_frontend', $request->up_coming_themes_frontend);

        return redirect()->back()->with([
            'msg' => __('Theme Settings Updated ...'),
            'type' => 'success'
        ]);
    }
}
