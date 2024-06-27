<?php

namespace Modules\ThemeManage\Http\Controllers;

use App\Facades\ThemeDataFacade;
use App\Models\Tenant;
use App\Models\Themes;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class ThemeManageController extends Controller
{
    const BASE_PATH = 'thememanage::tenant.backend.';

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {;
        return view(self::BASE_PATH.'index');
    }
    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('thememanage::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('thememanage::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('thememanage::edit');
    }

    public function update(Request $request, $slug)
    {
        $all_theme_slugs = ThemeDataFacade::getAllThemeSlug();

        if (!in_array($slug, $all_theme_slugs))
        {
            return response()->json([
                'status' => false
            ]);
        }

        DB::beginTransaction();
        try {
            $tenant = \tenant();
            Tenant::where('id',$tenant->id)->update([
                'theme_slug' => $slug
            ]);

            DB::commit();
        } catch (\Exception $exception) {


            DB::rollBack();
        }

        return response()->json([
            'status' => true
        ]);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
