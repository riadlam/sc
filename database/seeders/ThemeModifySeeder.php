<?php

namespace Database\Seeders;

use App\Models\StaticOption;
use App\Models\Tenant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Plugins\PageBuilder\Addons\Landlord\Common\Themes;

class ThemeModifySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $themes = \App\Models\Themes::all();
        foreach ($themes as $theme)
        {
            if ($theme->slug == 'theme-1')
            {
                $theme->update([
                    'slug' => 'hexfashion'
                ]);
            }

            if ($theme->slug == 'theme-2')
            {
                $theme->update([
                    'slug' => 'furnito'
                ]);
            }

            if ($theme->slug == 'theme-3')
            {
                $theme->update([
                    'slug' => 'medicom'
                ]);
            }
        }

        Tenant::where('theme_slug', 'theme-1')->update([
            'theme_slug' => 'hexfashion'
        ]);
        Tenant::where('theme_slug', 'theme-2')->update([
            'theme_slug' => 'furnito'
        ]);
        Tenant::where('theme_slug', 'theme-3')->update([
            'theme_slug' => 'medicom'
        ]);

        $static_option = StaticOption::all();
        foreach ($static_option as $option)
        {
            if ($option->option_value == 'theme-1')
            {
                $option->option_value = 'hexfashion';
                $option->save();
            }
            if ($option->option_value == 'theme-2')
            {
                $option->option_value = 'furnito';
                $option->save();
            }
        }
    }
}
