<?php

namespace Database\Seeders\Tenant;

use App\Helpers\ImageDataSeedingHelper;
use App\Helpers\SanitizeInput;
use App\Mail\TenantCredentialMail;
use App\Models\Admin;
use App\Models\Brand;
use App\Models\Language;
use App\Models\Menu;
use App\Models\Page;
use App\Models\PlanFeature;
use App\Models\PricePlan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class BrandSeed extends Seeder
{
    public function run()
    {
        if (session()->get('theme') == 'casual')
        {
            Brand::insert([
                [
                    'id' => 2,
                    'name' => 'Gucchi',
                    'slug' => 'gucci',
                    'image_id' => 545,
                    'banner_id' => 545,
                    'title' => 'Gucci',
                    'description' => 'Gucci is a Brand',
                    'created_at' => now(),
                    'updated_at' => now(),
                    'deleted_at' => null,
                    'url' => '#',
                    'status' => null
                ],
                [
                    'id' => 3,
                    'name' => 'Intel',
                    'slug' => 'intel',
                    'image_id' => 544,
                    'banner_id' => 544,
                    'title' => 'Gucci',
                    'description' => 'Gucci is a Brand',
                    'created_at' => now(),
                    'updated_at' => now(),
                    'deleted_at' => null,
                    'url' => '#',
                    'status' => null
                ],
                [
                    'id' => 4,
                    'name' => 'Mark',
                    'slug' => 'mark',
                    'image_id' => 543,
                    'banner_id' => 543,
                    'title' => 'Gucci',
                    'description' => 'Gucci is a Brand',
                    'created_at' => now(),
                    'updated_at' => now(),
                    'deleted_at' => null,
                    'url' => '#',
                    'status' => null
                ],
                [
                    'id' => 5,
                    'name' => 'Vagoda',
                    'slug' => 'vagoda',
                    'image_id' => 547,
                    'banner_id' => 547,
                    'title' => 'Gucci',
                    'description' => 'Gucci is a Brand',
                    'created_at' => now(),
                    'updated_at' => now(),
                    'deleted_at' => null,
                    'url' => '#',
                    'status' => null
                ],
                [
                    'id' => 6,
                    'name' => 'Quicker',
                    'slug' => 'quicker',
                    'image_id' => 545,
                    'banner_id' => 545,
                    'title' => 'Gucci',
                    'description' => 'Gucci is a Brand',
                    'created_at' => now(),
                    'updated_at' => now(),
                    'deleted_at' => null,
                    'url' => '#',
                    'status' => null
                ],
                [
                    'id' => 7,
                    'name' => 'Boogie',
                    'slug' => 'boogie',
                    'image_id' => 544,
                    'banner_id' => 544,
                    'title' => 'Gucci',
                    'description' => 'Gucci is a Brand',
                    'created_at' => now(),
                    'updated_at' => now(),
                    'deleted_at' => null,
                    'url' => '#',
                    'status' => null
                ],
                [
                    'id' => 8,
                    'name' => 'Ogivo',
                    'slug' => 'ogivo',
                    'image_id' => 543,
                    'banner_id' => 543,
                    'title' => 'Gucci',
                    'description' => 'Gucci is a Brand',
                    'created_at' => now(),
                    'updated_at' => now(),
                    'deleted_at' => null,
                    'url' => '#',
                    'status' => null
                ],
            ]);
        } else {
            Brand::insert([
                    [
                        'id' => 2,
                        'name' => 'Gucci',
                        'slug' => 'gucci',
                        'image_id' => 331,
                        'banner_id' => 331,
                        'title' => 'Gucci',
                        'description' => 'Gucci is a Brand',
                        'created_at' => '2022-08-24 04:41:51',
                        'updated_at' => '2022-10-31 11:28:59',
                        'deleted_at' => null,
                        'url' => '#',
                        'status' => null,
                    ],
                    [
                        'id' => 3,
                        'name' => 'Intel',
                        'slug' => 'intel',
                        'image_id' => 330,
                        'banner_id' => 330,
                        'title' => null,
                        'description' => 'Intel',
                        'created_at' => '2022-08-31 05:48:05',
                        'updated_at' => '2022-10-31 11:29:10',
                        'deleted_at' => null,
                        'url' => '#',
                        'status' => null,
                    ],
                    [
                        'id' => 4,
                        'name' => 'Mark',
                        'slug' => 'mark',
                        'image_id' => 329,
                        'banner_id' => 329,
                        'title' => null,
                        'description' => null,
                        'created_at' => '2022-09-10 04:21:04',
                        'updated_at' => '2022-10-31 11:29:19',
                        'deleted_at' => null,
                        'url' => '#',
                        'status' => null,
                    ],
                    [
                        'id' => 5,
                        'name' => 'Vagoda',
                        'slug' => 'vagoda',
                        'image_id' => 328,
                        'banner_id' => 328,
                        'title' => null,
                        'description' => null,
                        'created_at' => '2022-09-10 04:24:12',
                        'updated_at' => '2022-10-31 11:29:29',
                        'deleted_at' => null,
                        'url' => '#',
                        'status' => null,
                    ],
                    [
                        'id' => 6,
                        'name' => 'Quicker',
                        'slug' => 'quicker',
                        'image_id' => 327,
                        'banner_id' => 327,
                        'title' => null,
                        'description' => null,
                        'created_at' => '2022-09-10 04:24:43',
                        'updated_at' => '2022-10-31 11:29:40',
                        'deleted_at' => null,
                        'url' => '#',
                        'status' => null,
                    ],
                    [
                        'id' => 7,
                        'name' => 'boogie',
                        'slug' => 'boogie',
                        'image_id' => 330,
                        'banner_id' => 330,
                        'title' => null,
                        'description' => null,
                        'created_at' => '2022-09-10 04:25:07',
                        'updated_at' => '2022-10-31 11:29:51',
                        'deleted_at' => null,
                        'url' => '#',
                        'status' => null,
                    ],
                    [
                        'id' => 8,
                        'name' => 'Ogivo',
                        'slug' => 'ogivo',
                        'image_id' => 328,
                        'banner_id' => 328,
                        'title' => null,
                        'description' => null,
                        'created_at' => '2022-09-10 04:25:07',
                        'updated_at' => '2022-10-31 11:29:51',
                        'deleted_at' => null,
                        'url' => '#',
                        'status' => null,
                    ],
            ]);
        }
    }
}
