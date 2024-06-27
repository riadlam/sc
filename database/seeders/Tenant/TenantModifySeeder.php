<?php

namespace Database\Seeders\Tenant;

use App\Helpers\ImageDataSeedingHelper;
use App\Helpers\SanitizeInput;
use App\Mail\TenantCredentialMail;
use App\Models\Admin;
use App\Models\Language;
use App\Models\Menu;
use App\Models\Page;
use App\Models\PlanFeature;
use App\Models\PricePlan;
use App\Models\StaticOption;
use App\Models\Testimonial;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class TenantModifySeeder extends Seeder
{
    public function run()
    {
        $static_option = StaticOption::where('option_name', 'LIKE', '%theme_one%')->get();
        foreach ($static_option ?? [] as $option)
        {
            $replaced = str_replace('theme_one', 'hexfashion', $option->option_name);
            $option->option_name = $replaced;
            $option->save();
        }

        $static_option = StaticOption::where('option_name', 'LIKE', '%theme_two%')->get();
        foreach ($static_option ?? [] as $option)
        {
            $replaced = str_replace('theme_two', 'furnito', $option->option_name);
            $option->option_name = $replaced;
            $option->save();
        }

        $static_option = StaticOption::where('option_name', 'LIKE', '%theme_three%')->get();
        foreach ($static_option ?? [] as $option)
        {
            $replaced = str_replace('theme_three', 'medicom', $option->option_name);
            $option->option_name = $replaced;
            $option->save();
        }
    }
}
