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
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Modules\DigitalProduct\Entities\DigitalProductType;
use Modules\DigitalProduct\Http\Services\DigitalType;

class DigitalProductSeed extends Seeder
{
    public function run()
    {
        $this->seedProductType();
        $this->seedCategories();
        $this->seedSubCategories();
        $this->seedChildCategories();
        $this->seedLanguage();
        $this->seedAuthor();
        $this->seedTax();
        $this->seedProduct();
        $this->seedProductAdditionalFiled();
        $this->seedProductCustomAdditionalFiled();
        $this->seedProductCategory();
        $this->seedProductSubCategories();
        $this->seedProductChildCategories();
        $this->seedProductTags();
        $this->seedProductGalleries();;
        $this->seedProductReturnPolicies();
    }

    private function seedProductType()
    {
        $types = [
            [
                'id' => 1,
                'name' => 'Image',
                'slug' => 'image',
                'product_type' => 'd_image',
                'image_id' => NULL,
                'status' => 1,
                'extensions' => json_encode(["jpeg", "jpg", "png"])
            ],
            [
                'id' => 2,
                'name' => 'Video',
                'slug' => 'video',
                'product_type' => 'd_video',
                'image_id' => NULL,
                'status' => 1,
                'extensions' => json_encode(["mp4", "avi", "mov"])
            ],
            [
                'id' => 3,
                'name' => 'Audio',
                'slug' => 'audio',
                'product_type' => 'd_audio',
                'image_id' => NULL,
                'status' => 1,
                'extensions' => json_encode(["m4a", "mp3", "wav"])
            ],
            [
                'id' => 4,
                'name' => 'Software',
                'slug' => 'software',
                'product_type' => 'd_software',
                'image_id' => NULL,
                'status' => 1,
                'extensions' => json_encode(["zip"])
            ]
        ];

        DigitalProductType::insert($types);
    }

    private function seedLanguage()
    {
        DB::statement("INSERT INTO `digital_languages` (`id`, `name`, `slug`, `status`, `image_id`, `created_at`, `updated_at`) VALUES
        (1,'Bengali','bengali',1,NULL,'2023-04-17 02:25:20','2023-04-17 02:25:20'),
        (2,'English','english',1,NULL,'2023-04-17 02:25:50','2023-04-17 02:25:50'),
        (4,'French','french',1,NULL,'2023-04-17 02:26:17','2023-04-17 02:26:17'),
        (5,'German','german',1,NULL,'2023-04-17 02:26:21','2023-04-17 02:26:21'),
        (6,'Arabic','arabic',1,NULL,'2023-04-17 02:26:29','2023-04-17 02:26:29'),
        (7,'Hindi','hindi',1,NULL,'2023-04-17 02:26:53','2023-04-17 02:26:53')");
    }

    private function seedAuthor()
    {
        DB::statement("INSERT INTO `digital_authors` (`id`, `name`, `slug`, `status`, `image_id`, `created_at`, `updated_at`) VALUES
        (1,'Mazharul Islam Suzon','mazharul-islam-suzon',1,485,'2023-04-15 19:18:52','2023-04-16 21:30:12'),
        (2,'John Abraham','john-abraham',1,484,'2023-04-16 21:27:59','2023-04-16 21:30:06'),
        (3,'Runa Mack','runa-mack',1,486,'2023-04-16 21:28:22','2023-04-16 21:29:59'),
        (4,'Hoo Su Wang','hoo-su-wang',1,487,'2023-04-16 21:39:57','2023-04-16 21:39:57'),
        (5,'Yasin Abrar','yasin-abrar',1,485,'2023-04-16 21:40:53','2023-04-16 21:40:53')");
    }

    private function seedCategories()
    {
        DB::statement("INSERT INTO `digital_categories` (`id`, `name`, `slug`, `description`, `digital_product_type`, `image_id`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
        (1,'Art','art',NULL,1,NULL,1,'2023-04-15 19:17:53','2023-04-15 19:17:53',NULL),
        (2,'Course','course',NULL,2,NULL,1,'2023-04-15 19:18:02','2023-04-15 19:18:02',NULL),
        (3,'Music','music',NULL,1,NULL,1,'2023-04-15 19:19:40','2023-04-15 19:19:40',NULL),
        (4,'E-Book','e-book',NULL,3,NULL,1,'2023-04-15 19:19:51','2023-04-15 19:19:51',NULL),
        (5,'Web Series','web-series',NULL,2,NULL,1,'2023-04-15 19:20:06','2023-04-15 19:20:06',NULL),
        (6,'Software','software',NULL,4,NULL,1,'2023-04-15 19:20:39','2023-04-15 19:20:39',NULL)");
    }

    private function seedSubCategories()
    {
        DB::statement("INSERT INTO `digital_sub_categories` (`id`, `category_id`, `name`, `slug`, `description`, `image_id`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
        (1,2,'PHP Course','php-course',NULL,NULL,1,'2023-04-15 19:18:14','2023-04-15 19:18:14',NULL)");
    }

    private function seedChildCategories()
    {
        DB::statement("INSERT INTO `digital_child_categories` (`id`, `category_id`, `sub_category_id`, `name`, `slug`, `description`, `image_id`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
	    (1,2,1,'OOP PHP Course','oop-php-course',NULL,NULL,1,'2023-04-15 19:18:45','2023-04-15 19:18:45',NULL)");
    }

    private function seedTax()
    {
        DB::statement("INSERT INTO `digital_product_taxes` (`id`, `name`, `tax_percentage`, `status`, `created_at`, `updated_at`) VALUES
	    (1,'EU',10,1,'2023-04-15 19:19:04','2023-04-15 19:19:04')");
    }

    private function seedProduct()
    {
        DB::statement("INSERT INTO `digital_products` (`id`, `name`, `slug`, `summary`, `description`, `product_type`, `image_id`, `status_id`, `included_files`, `version`, `release_date`, `update_date`, `preview_link`, `quantity`, `accessibility`, `is_licensable`, `tax`, `file`, `regular_price`, `sale_price`, `free_date`, `promotional_date`, `promotional_price`, `created_at`, `updated_at`, `deleted_at`) VALUES
        (1,'Malik Jacobs','malik-jacobs','Sunt magna ut adipis','Nemo qui blanditiis . Nemo qui blanditiis . Nemo qui blanditiis . Nemo qui blanditiis',2,474,1,'','',NULL,NULL,'',NULL,'paid',0,NULL,'1681565481.jpg',200,150,NULL,NULL,NULL,'2023-04-15 19:31:21','2023-04-15 22:30:53',NULL),
        (2,'Jeanette Stevens','odit-totam-nostrud-e','Quos eius est conse','Optio, officia fugia.',2,473,1,'Ipsam consectetur su','Aliqua Aut id illu',NULL,NULL,'Liberoassumendatem',NULL,'paid',0,NULL,'1681816858.mp4',300,NULL,NULL,NULL,NULL,'2023-04-15 19:34:36','2023-04-18 17:20:58',NULL),
        (4,'Nell Charles','odit-totam-nostrud-e-1','Quos eius est conse','Optio, officia fugia.',2,475,1,'Ipsam consectetur su','Aliqua Aut id illu',NULL,NULL,'Liberoassumendatem',NULL,'paid',0,NULL,'1681816864.mp4',300,NULL,NULL,'2023-10-31 00:00:00',280,'2023-04-15 22:48:28','2023-04-18 17:21:04',NULL),
        (15,'Malik Jacobs','malik-jacobs-1','Sunt magna ut adipis','Nemo qui blanditiis . Nemo qui blanditiis . Nemo qui blanditiis . Nemo qui blanditiis',2,477,1,'','',NULL,NULL,'',NULL,'paid',0,NULL,'no file added',200,150,NULL,NULL,NULL,'2023-04-15 22:53:03','2023-04-15 22:53:44',NULL),
        (16,'Kristen Grimes','laboris-vero-quis-do','Incidunt assumenda','Nemo qui blanditiis . Nemo qui blanditiis . Nemo qui blanditiis . Nemo qui blanditiis',2,478,1,'Officiis eos iure i','Et suscipit labore r',NULL,NULL,'Velitdoloresanimi',433,'paid',0,NULL,'no file added',200,150,NULL,'2023-10-28 00:00:00',100,'2023-04-15 22:53:53','2023-04-17 00:14:38',NULL),
        (17,'Mariam Luna','malik-jacobs-3','Sunt magna ut adipis','Nemo qui blanditiis . Nemo qui blanditiis . Nemo qui blanditiis . Nemo qui blanditiis',2,476,1,'','',NULL,NULL,'',NULL,'paid',0,NULL,'1681814174.jpg',200,150,NULL,'2023-04-29 00:00:00',50,'2023-04-15 22:54:19','2023-04-18 16:36:14',NULL),
        (18,'Mariam Luna','malik-jacobs-4','Sunt magna ut adipis','Nemo qui blanditiis . Nemo qui blanditiis . Nemo qui blanditiis . Nemo qui blanditiis',2,476,1,'','',NULL,NULL,'',NULL,'paid',0,NULL,'1681814120.jpg',200,150,NULL,'2023-04-29 00:00:00',50,'2023-04-17 00:56:22','2023-04-18 16:35:20',NULL),
        (19,'Malik Jacobs','malik-jacobs-2','Sunt magna ut adipis','Nemo qui blanditiis . Nemo qui blanditiis . Nemo qui blanditiis . Nemo qui blanditiis',2,474,1,'','',NULL,NULL,'',NULL,'paid',0,NULL,'no file added',200,150,NULL,NULL,NULL,'2023-04-17 00:56:24','2023-04-17 00:56:35',NULL),
        (20,'Malik Jacobs','malik-jacobs-5','Sunt magna ut adipis','Nemo qui blanditiis . Nemo qui blanditiis . Nemo qui blanditiis . Nemo qui blanditiis',2,477,1,'','',NULL,NULL,'',NULL,'paid',0,NULL,'no file added',200,150,NULL,NULL,NULL,'2023-04-17 00:56:27','2023-04-17 00:56:33',NULL),
        (21,'Nell Charles','odit-totam-nostrud-e-2','Quos eius est conse','Optio, officia fugia.',2,475,1,'Ipsam consectetur su','Aliqua Aut id illu',NULL,NULL,'Liberoassumendatem',NULL,'paid',0,NULL,'1681816846.mp4',300,NULL,NULL,'2023-10-31 00:00:00',280,'2023-04-17 00:56:29','2023-04-18 17:20:46',NULL),
        (22,'Malik Jacobs','malik-jacobs-6','Sunt magna ut adipis','Nemo qui blanditiis . Nemo qui blanditiis . Nemo qui blanditiis . Nemo qui blanditiis',2,474,1,'','',NULL,NULL,'',NULL,'paid',0,NULL,'no file added',200,150,NULL,NULL,NULL,'2023-04-17 01:17:51','2023-04-17 01:18:02',NULL),
        (23,'Nell Charles','odit-totam-nostrud-e-3','Quos eius est conse','Optio, officia fugia.',2,475,1,'Ipsam consectetur su','Aliqua Aut id illu',NULL,NULL,'Liberoassumendatem',NULL,'paid',0,1,'1681816838.mp4',300,NULL,NULL,'2023-10-31 00:00:00',280,'2023-04-17 01:17:53','2023-04-18 17:20:38',NULL),
        (24,'Malik Jacobs','malik-jacobs-7','Sunt magna ut adipis','Nemo qui blanditiis . Nemo qui blanditiis . Nemo qui blanditiis . Nemo qui blanditiis',2,477,1,'','',NULL,NULL,'',NULL,'paid',0,NULL,'no file added',200,150,NULL,NULL,NULL,'2023-04-17 01:17:56','2023-04-17 01:18:05',NULL),
        (25,'Kristen Grimes','laboris-vero-quis-do-1','Incidunt assumenda','Nemo qui blanditiis . Nemo qui blanditiis . Nemo qui blanditiis . Nemo qui blanditiis',2,478,1,'Officiis eos iure i','Et suscipit labore r',NULL,NULL,'Velitdoloresanimi',NULL,'paid',0,1,'no file added',200,150,NULL,'2023-10-28 00:00:00',100,'2023-04-17 01:17:58','2023-04-17 19:59:28',NULL),
        (26,'Lynn Cooper','pariatur-excepteur','Ullam ea possimus e','Qui facilis nisi qui.',2,489,1,'Esse sequi beatae l','Molestiae sint harum',NULL,NULL,'UteumconsequatCo',326,'free',0,NULL,'1681677870.jpg',0,NULL,NULL,NULL,NULL,'2023-04-17 02:44:30','2023-04-17 02:59:18','2023-04-17 02:59:18'),
        (27,'Hayley Delaney','facere-sed-sunt-amet','Veritatis cillum rer','Iste vero deserunt i.',2,473,1,'Sunt ipsa qui exerc','Duis reprehenderit n','2023-04-17','2023-04-18','Quiarerumidnona',974,'paid',0,NULL,'1681713297.jpg',200,NULL,NULL,NULL,NULL,'2023-04-17 12:34:57','2023-04-17 12:47:48',NULL)");
    }

    private function seedProductAdditionalFiled()
    {
        DB::statement("INSERT INTO `additional_fields` (`id`, `product_id`, `badge_id`, `pages`, `language`, `formats`, `words`, `tool_used`, `database_used`, `compatible_browsers`, `compatible_os`, `high_resolution`, `author_id`, `created_at`, `updated_at`) VALUES
        (19,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
        (36,15,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,4,NULL,NULL),
        (41,16,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,3,NULL,NULL),
        (45,19,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
        (46,20,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,4,NULL,NULL),
        (54,26,NULL,NULL,5,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL),
        (56,24,NULL,NULL,2,NULL,NULL,NULL,NULL,NULL,NULL,NULL,4,NULL,NULL),
        (58,22,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
        (63,27,NULL,NULL,2,NULL,NULL,NULL,NULL,NULL,NULL,'yes',3,NULL,NULL),
        (69,25,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,3,NULL,NULL),
        (72,18,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,2,NULL,NULL),
        (73,17,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,2,NULL,NULL),
        (74,23,NULL,NULL,4,NULL,NULL,NULL,NULL,NULL,NULL,NULL,5,NULL,NULL),
        (75,21,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,5,NULL,NULL),
        (76,2,NULL,15,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL),
        (77,4,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,5,NULL,NULL)");
    }

    private function seedProductCustomAdditionalFiled()
    {
        DB::statement("INSERT INTO `additional_custom_fields` (`id`, `additional_field_id`, `option_name`, `option_value`, `created_at`, `updated_at`) VALUES
        (61,63,'name','suzon',NULL,NULL),
        (62,63,'publisher','Apex',NULL,NULL),
        (65,74,'IBM','159124',NULL,NULL),
        (66,74,'TIN','65756',NULL,NULL),
        (67,75,'publisher','Apex',NULL,NULL),
        (68,75,'IBM','65756',NULL,NULL),
        (69,76,'CB Name','Mania',NULL,NULL),
        (70,76,'new','65756',NULL,NULL),
        (71,77,'zxc','123',NULL,NULL),
        (72,77,'new','65756',NULL,NULL)");
    }

    private function seedProductCategory()
    {
        DB::statement("INSERT INTO `digital_product_categories` (`id`, `product_id`, `category_id`, `created_at`, `updated_at`) VALUES
        (1,1,1,'2023-04-15 19:31:21','2023-04-15 19:31:21'),
        (2,2,2,'2023-04-15 19:34:36','2023-04-15 19:34:36'),
        (4,4,2,'2023-04-15 22:48:28','2023-04-15 22:48:28'),
        (9,15,1,'2023-04-15 22:53:03','2023-04-15 22:53:03'),
        (10,16,4,'2023-04-15 22:53:53','2023-04-15 22:54:10'),
        (11,17,1,'2023-04-15 22:54:19','2023-04-18 16:36:14'),
        (12,18,1,'2023-04-17 00:56:22','2023-04-18 16:34:11'),
        (13,19,1,'2023-04-17 00:56:24','2023-04-17 00:56:24'),
        (14,20,1,'2023-04-17 00:56:27','2023-04-17 00:56:27'),
        (15,21,2,'2023-04-17 00:56:29','2023-04-17 00:56:29'),
        (16,22,1,'2023-04-17 01:17:51','2023-04-17 01:17:51'),
        (17,23,2,'2023-04-17 01:17:53','2023-04-17 01:17:53'),
        (18,24,1,'2023-04-17 01:17:56','2023-04-17 01:17:56'),
        (19,25,4,'2023-04-17 01:17:58','2023-04-17 01:17:58'),
        (20,26,1,'2023-04-17 02:44:30','2023-04-17 02:44:30'),
        (21,27,1,'2023-04-17 12:34:57','2023-04-17 12:34:57')");
    }

    private function seedProductSubCategories()
    {
        DB::statement("INSERT INTO `digital_product_sub_categories` (`id`, `product_id`, `sub_category_id`, `created_at`, `updated_at`) VALUES
        (1,2,1,'2023-04-15 19:34:36','2023-04-15 19:34:36'),
        (3,4,1,'2023-04-15 22:48:28','2023-04-15 22:48:28'),
        (4,21,1,'2023-04-17 00:56:29','2023-04-17 00:56:29'),
        (5,23,1,'2023-04-17 01:17:53','2023-04-17 01:17:53')");
    }

    private function seedProductChildCategories()
    {
        DB::statement("INSERT INTO `digital_product_child_categories` (`id`, `product_id`, `child_category_id`, `created_at`, `updated_at`) VALUES
	    (3,23,1,NULL,NULL)");
    }

    private function seedProductTags()
    {
        DB::statement("INSERT INTO `digital_product_tags` (`id`, `tag_name`, `product_id`, `type`) VALUES
        (20,'asd',1,'digital'),
        (21,'xcv',1,'digital'),
        (51,'asd',15,'digital'),
        (52,'xcv',15,'digital'),
        (59,'asd',16,'digital'),
        (60,'xcv',16,'digital'),
        (66,'asd',19,'digital'),
        (67,'xcv',19,'digital'),
        (68,'asd',20,'digital'),
        (69,'xcv',20,'digital'),
        (80,'asd',26,'digital'),
        (83,'asd',24,'digital'),
        (84,'xcv',24,'digital'),
        (86,'asd',22,'digital'),
        (87,'xcv',22,'digital'),
        (92,'asd',27,'digital'),
        (103,'asd',25,'digital'),
        (104,'xcv',25,'digital'),
        (108,'asd',18,'digital'),
        (109,'xcv',18,'digital'),
        (110,'asd',17,'digital'),
        (111,'xcv',17,'digital'),
        (112,'cxvb',23,'digital'),
        (113,'cxvb',21,'digital'),
        (114,'cxvb',2,'digital'),
        (115,'cxvb',4,'digital')");
    }

    private function seedProductGalleries()
    {

    }

    private function seedProductReturnPolicies()
    {
        DB::statement("INSERT INTO `digital_product_refund_policies` (`id`, `product_id`, `refund_description`, `created_at`, `updated_at`) VALUES
        (1,1,'Praesentium dolor ad. Praesentium dolor ad. Praesentium dolor ad.','2023-04-15 19:31:21','2023-04-15 22:30:53'),
        (2,2,'Ducimus, id fugiat e.','2023-04-15 19:34:36','2023-04-15 20:22:31'),
        (4,4,'Ducimus, id fugiat e.','2023-04-15 22:48:28','2023-04-15 22:48:28'),
        (6,15,'Praesentium dolor ad. Praesentium dolor ad. Praesentium dolor ad.','2023-04-15 22:53:03','2023-04-15 22:53:03'),
        (7,16,'Praesentium dolor ad. Praesentium dolor ad. Praesentium dolor ad.','2023-04-15 22:53:53','2023-04-15 22:53:53'),
        (8,17,'Praesentium dolor ad. Praesentium dolor ad. Praesentium dolor ad.','2023-04-15 22:54:19','2023-04-15 22:54:19'),
        (9,18,'Praesentium dolor ad. Praesentium dolor ad. Praesentium dolor ad.','2023-04-17 00:56:22','2023-04-17 00:56:22'),
        (10,19,'Praesentium dolor ad. Praesentium dolor ad. Praesentium dolor ad.','2023-04-17 00:56:24','2023-04-17 00:56:24'),
        (11,20,'Praesentium dolor ad. Praesentium dolor ad. Praesentium dolor ad.','2023-04-17 00:56:27','2023-04-17 00:56:27'),
        (12,21,'Ducimus, id fugiat e.','2023-04-17 00:56:29','2023-04-17 00:56:29'),
        (13,22,'Praesentium dolor ad. Praesentium dolor ad. Praesentium dolor ad.','2023-04-17 01:17:51','2023-04-17 01:17:51'),
        (14,23,'Ducimus, id fugiat e.','2023-04-17 01:17:53','2023-04-17 01:17:53'),
        (15,24,'Praesentium dolor ad. Praesentium dolor ad. Praesentium dolor ad.','2023-04-17 01:17:56','2023-04-17 01:17:56'),
        (16,25,'Praesentium dolor ad. Praesentium dolor ad. Praesentium dolor ad.','2023-04-17 01:17:58','2023-04-17 01:17:58'),
        (17,26,'Explicabo. Sed aut o.','2023-04-17 02:44:30','2023-04-17 02:47:57'),
        (18,27,'Culpa, maiores dolor.','2023-04-17 12:34:57','2023-04-17 12:47:48')");
    }
}
