<?php

namespace Database\Seeders\Tenant\Footer;

use App\Models\Widgets;
use Illuminate\Database\Seeder;

class WidgetSeed extends Seeder
{
    public function run()
    {
        if (session()->get('theme') == 'aromatic')
        {
            Widgets::insert([
                [
                    'id' => 15,
                    'widget_area' => NULL,
                    'widget_order' => 1,
                    'widget_location' => 'footer',
                    'widget_name' => 'ContactWidget',
                    'widget_content' => 'a:8:{s:2:"id";s:2:"15";s:11:"widget_name";s:13:"ContactWidget";s:11:"widget_type";s:6:"update";s:15:"widget_location";s:6:"footer";s:12:"widget_order";s:1:"1";s:9:"namespace";s:60:"Plugins\WidgetBuilder\Widgets\Tenants\Aromatic\ContactWidget";s:5:"title";s:7:"Contact";s:20:"footer_social_follow";a:1:{s:15:"repeater_title_";a:1:{i:0;s:14:"+00 123456 789";}}}',
                    'created_at' => '2023-05-25 17:10:40',
                    'updated_at' => '2023-05-25 17:10:40',
                    'widget_namespace' => 'Plugins\WidgetBuilder\Widgets\Tenants\Aromatic\ContactWidget'
                ],
                [
                    'id' => 16,
                    'widget_area' => NULL,
                    'widget_order' => 2,
                    'widget_location' => 'footer',
                    'widget_name' => 'TenantImageWidget',
                    'widget_content' => 'a:7:{s:2:"id";s:2:"16";s:11:"widget_name";s:17:"TenantImageWidget";s:11:"widget_type";s:6:"update";s:15:"widget_location";s:6:"footer";s:12:"widget_order";s:1:"2";s:9:"namespace";s:64:"Plugins\WidgetBuilder\Widgets\Tenants\Aromatic\TenantImageWidget";s:12:"image_widget";a:2:{s:15:"repeater_image_";a:1:{i:0;s:3:"494";}s:19:"repeater_image_url_";a:1:{i:0;s:1:"#";}}}',
                    'created_at' => '2023-05-25 17:10:40',
                    'updated_at' => '2023-05-25 17:10:40',
                    'widget_namespace' => 'Plugins\WidgetBuilder\Widgets\Tenants\Aromatic\TenantImageWidget'
                ],
                [
                    'id' => 17,
                    'widget_area' => NULL,
                    'widget_order' => 2,
                    'widget_location' => 'footer',
                    'widget_name' => 'SocialFollowWidget',
                    'widget_content' => 'a:7:{s:11:"widget_name";s:18:"SocialFollowWidget";s:11:"widget_type";s:3:"new";s:15:"widget_location";s:6:"footer";s:12:"widget_order";s:1:"3";s:9:"namespace";s:65:"Plugins\WidgetBuilder\Widgets\Tenants\Aromatic\SocialFollowWidget";s:5:"title";s:9:"Follow Me";s:20:"footer_social_follow";a:2:{s:14:"repeater_icon_";a:4:{i:0;s:17:"lab la-facebook-f";i:1;s:14:"lab la-twitter";i:2;s:16:"lab la-instagram";i:3;s:18:"lab la-linkedin-in";}s:18:"repeater_icon_url_";a:4:{i:0;s:1:"#";i:1;s:1:"#";i:2;s:1:"#";i:3;s:1:"#";}}}',
                    'created_at' => '2023-05-25 17:10:40',
                    'updated_at' => '2023-05-25 17:10:40',
                    'widget_namespace' => 'Plugins\WidgetBuilder\Widgets\Tenants\Aromatic\SocialFollowWidget'
                ],
                [
                    'id' => 18,
                    'widget_area' => NULL,
                    'widget_order' => 1,
                    'widget_location' => 'footer_bottom_left',
                    'widget_name' => 'BottomNavigationMenuWidget',
                    'widget_content' => 'a:8:{s:2:"id";s:2:"18";s:11:"widget_name";s:26:"BottomNavigationMenuWidget";s:11:"widget_type";s:6:"update";s:15:"widget_location";s:18:"footer_bottom_left";s:12:"widget_order";s:1:"1";s:9:"namespace";s:73:"Plugins\WidgetBuilder\Widgets\Tenants\Aromatic\BottomNavigationMenuWidget";s:12:"widget_title";s:5:"asdas";s:7:"menu_id";s:1:"2";}',
                    'created_at' => '2023-05-25 17:10:40',
                    'updated_at' => '2023-05-25 17:10:40',
                    'widget_namespace' => 'Plugins\WidgetBuilder\Widgets\Tenants\Aromatic\BottomNavigationMenuWidget'
                ],
                [
                    'id' => 19,
                    'widget_area' => NULL,
                    'widget_order' => 1,
                    'widget_location' => 'footer_bottom_right',
                    'widget_name' => 'BottomPaymentGatewayImage',
                    'widget_content' => 'a:7:{s:2:"id";s:2:"19";s:11:"widget_name";s:25:"BottomPaymentGatewayImage";s:11:"widget_type";s:6:"update";s:15:"widget_location";s:19:"footer_bottom_right";s:12:"widget_order";s:1:"1";s:9:"namespace";s:72:"Plugins\WidgetBuilder\Widgets\Tenants\Aromatic\BottomPaymentGatewayImage";s:22:"footer_payment_gateway";a:2:{s:15:"repeater_image_";a:6:{i:0;s:3:"445";i:1;s:3:"446";i:2;s:3:"447";i:3;s:3:"442";i:4;s:3:"315";i:5;s:3:"312";}s:19:"repeater_image_url_";a:6:{i:0;s:1:"#";i:1;s:1:"#";i:2;s:1:"#";i:3;s:1:"#";i:4;s:1:"#";i:5;s:1:"#";}}}',
                    'created_at' => '2023-05-25 17:10:40',
                    'updated_at' => '2023-05-25 17:10:40',
                    'widget_namespace' => 'Plugins\WidgetBuilder\Widgets\Tenants\Aromatic\BottomPaymentGatewayImage'
                ]
            ]);
        }
        elseif(session()->get('theme') == 'casual')
        {
            Widgets::insert([
                [
                    'id' => 11,
                    'widget_area' => NULL,
                    'widget_order' => 1,
                    'widget_location' => 'footer_bottom',
                    'widget_name' => 'FooterBottomLinksWidget',
                    'widget_content' => 'a:7:{s:2:"id";s:2:"11";s:11:"widget_name";s:23:"FooterBottomLinksWidget";s:11:"widget_type";s:6:"update";s:15:"widget_location";s:13:"footer_bottom";s:12:"widget_order";s:1:"1";s:9:"namespace";s:70:"Plugins\WidgetBuilder\Widgets\Tenants\ThemeOne\FooterBottomLinksWidget";s:11:"navbar_link";s:1:"1";}',
                    'created_at' => '2023-05-25 17:10:40',
                    'updated_at' => '2023-05-25 17:10:40',
                    'widget_namespace' => 'Plugins\WidgetBuilder\Widgets\Tenants\ThemeOne\FooterBottomLinksWidget'
                ],
                [
                    'id' => 13,
                    'widget_area' => NULL,
                    'widget_order' => 1,
                    'widget_location' => 'footer_bottom_right',
                    'widget_name' => 'FooterPaymentGatewaysWidget',
                    'widget_content' => 'a:7:{s:2:"id";s:2:"13";s:11:"widget_name";s:27:"FooterPaymentGatewaysWidget";s:11:"widget_type";s:6:"update";s:15:"widget_location";s:19:"footer_bottom_right";s:12:"widget_order";s:1:"1";s:9:"namespace";s:74:"Plugins\WidgetBuilder\Widgets\Tenants\ThemeOne\FooterPaymentGatewaysWidget";s:22:"footer_payment_gateway";a:2:{s:15:"repeater_image_";a:1:{i:0;s:3:"448";}s:19:"repeater_image_url_";a:1:{i:0;s:1:"#";}}}',
                    'created_at' => '2023-05-25 17:10:40',
                    'updated_at' => '2023-05-25 17:10:40',
                    'widget_namespace' => 'Plugins\WidgetBuilder\Widgets\Tenants\ThemeOne\FooterPaymentGatewaysWidget'
                ],
                [
                    'id' => 14,
                    'widget_area' => NULL,
                    'widget_order' => 1,
                    'widget_location' => 'shop_footer',
                    'widget_name' => 'ShopFooterWidget',
                    'widget_content' => 'a:7:{s:2:"id";s:2:"14";s:11:"widget_name";s:16:"ShopFooterWidget";s:11:"widget_type";s:6:"update";s:15:"widget_location";s:11:"shop_footer";s:12:"widget_order";s:1:"1";s:9:"namespace";s:46:"Plugins\WidgetBuilder\Widgets\ShopFooterWidget";s:17:"services_repeater";a:3:{s:14:"repeater_icon_";a:4:{i:0;s:12:"las la-truck";i:1;s:15:"las la-redo-alt";i:2;s:11:"las la-lock";i:3;s:11:"las la-gift";}s:15:"repeater_title_";a:4:{i:0;s:13:"Free Shipping";i:1;s:11:"Easy Return";i:2;s:14:"Secure payment";i:3;s:10:"Best Offer";}s:18:"repeater_subtitle_";a:4:{i:0;s:14:"Order Over $90";i:1;s:14:"Within 15 Days";i:2;s:15:"Online Shopping";i:3;s:10:"Guaranteed";}}}',
                    'created_at' => '2023-05-25 17:10:40',
                    'updated_at' => '2023-05-25 17:10:40',
                    'widget_namespace' => 'Plugins\WidgetBuilder\Widgets\ShopFooterWidget'
                ],
                [
                    'id' => 18,
                    'widget_area' => NULL,
                    'widget_order' => 1,
                    'widget_location' => 'footer',
                    'widget_name' => 'TenantNavigationMenuWidgetThree',
                    'widget_content' => 'a:8:{s:2:"id";s:2:"18";s:11:"widget_name";s:31:"TenantNavigationMenuWidgetThree";s:11:"widget_type";s:6:"update";s:15:"widget_location";s:6:"footer";s:12:"widget_order";s:1:"1";s:9:"namespace";s:61:"Plugins\WidgetBuilder\Widgets\TenantNavigationMenuWidgetThree";s:5:"title";s:11:"Quick Links";s:7:"menu_id";s:1:"1";}',
                    'created_at' => '2023-05-25 17:10:40',
                    'updated_at' => '2023-05-25 17:10:40',
                    'widget_namespace' => 'Plugins\WidgetBuilder\Widgets\Tenants\Casual\TenantNavigationMenuWidgetThree'
                ],
                [
                    'id' => 19,
                    'widget_area' => NULL,
                    'widget_order' => 1,
                    'widget_location' => 'footer',
                    'widget_name' => 'TenantNavigationMenuWidgetThree',
                    'widget_content' => 'a:7:{s:11:"widget_name";s:31:"TenantNavigationMenuWidgetThree";s:11:"widget_type";s:3:"new";s:15:"widget_location";s:6:"footer";s:12:"widget_order";s:1:"2";s:9:"namespace";s:61:"Plugins\WidgetBuilder\Widgets\TenantNavigationMenuWidgetThree";s:5:"title";s:13:"Helpful Links";s:7:"menu_id";s:1:"1";}',
                    'created_at' => '2023-05-25 17:10:40',
                    'updated_at' => '2023-05-25 17:10:40',
                    'widget_namespace' => 'Plugins\WidgetBuilder\Widgets\Tenants\Casual\TenantNavigationMenuWidgetThree'
                ],
                [
                    'id' => 20,
                    'widget_area' => NULL,
                    'widget_order' => 1,
                    'widget_location' => 'footer',
                    'widget_name' => 'TenantAboutUsWidgetThree',
                    'widget_content' => 'a:8:{s:2:"id";s:2:"20";s:11:"widget_name";s:24:"TenantAboutUsWidgetThree";s:11:"widget_type";s:6:"update";s:15:"widget_location";s:6:"footer";s:12:"widget_order";s:1:"3";s:9:"namespace";s:54:"Plugins\WidgetBuilder\Widgets\TenantAboutUsWidgetThree";s:5:"title";s:15:"Our Information";s:19:"about_us_two_widget";a:3:{s:14:"repeater_text_";a:3:{i:0;s:26:"41/1, Hilton Mall, NY City";i:1;s:13:"+012-78901234";i:2;s:13:"help@mail.com";}s:18:"repeater_icon_url_";a:3:{i:0;s:1:"#";i:1;s:1:"#";i:2;s:1:"#";}s:14:"repeater_icon_";a:3:{i:0;s:21:"las la-location-arrow";i:1;s:19:"las la-phone-volume";i:2;s:15:"las la-envelope";}}}',
                    'created_at' => '2023-05-25 17:10:40',
                    'updated_at' => '2023-05-25 17:10:40',
                    'widget_namespace' => 'Plugins\WidgetBuilder\Widgets\Tenants\Casual\TenantAboutUsWidgetThree'
                ],
                [
                    'id' => 22,
                    'widget_area' => NULL,
                    'widget_order' => 1,
                    'widget_location' => 'footer',
                    'widget_name' => 'NewsletterBookpoint',
                    'widget_content' => 'a:9:{s:2:"id";s:2:"22";s:11:"widget_name";s:19:"NewsletterBookpoint";s:11:"widget_type";s:6:"update";s:15:"widget_location";s:6:"footer";s:12:"widget_order";s:1:"4";s:9:"namespace";s:67:"Plugins\WidgetBuilder\Widgets\Tenants\Bookpoint\NewsletterBookpoint";s:5:"title";s:12:"Get In Touch";s:8:"subtitle";s:32:"Sign up to our mailing list now!";s:22:"tenant_social_repeater";a:2:{s:14:"repeater_icon_";a:4:{i:0;s:17:"lab la-facebook-f";i:1;s:16:"lab la-instagram";i:2;s:14:"lab la-youtube";i:3;s:14:"lab la-twitter";}s:13:"repeater_url_";a:4:{i:0;s:1:"#";i:1;s:1:"#";i:2;s:1:"#";i:3;s:1:"#";}}}',
                    'created_at' => '2023-05-25 17:10:40',
                    'updated_at' => '2023-05-25 17:10:40',
                    'widget_namespace' => 'Plugins\WidgetBuilder\Widgets\Tenants\Bookpoint\NewsletterBookpoint'
                ],
                [
                    'id' => 23,
                    'widget_area' => NULL,
                    'widget_order' => 1,
                    'widget_location' => 'footer_bottom_left',
                    'widget_name' => 'BottomNavigationMenuWidget',
                    'widget_content' => 'a:6:{s:11:"widget_name";s:26:"BottomNavigationMenuWidget";s:11:"widget_type";s:3:"new";s:15:"widget_location";s:18:"footer_bottom_left";s:12:"widget_order";s:1:"1";s:9:"namespace";s:73:"Plugins\WidgetBuilder\Widgets\Tenants\Aromatic\BottomNavigationMenuWidget";s:7:"menu_id";s:1:"2";}',
                    'created_at' => '2023-05-25 17:10:40',
                    'updated_at' => '2023-05-25 17:10:40',
                    'widget_namespace' => 'Plugins\WidgetBuilder\Widgets\Tenants\Aromatic\BottomNavigationMenuWidget'
                ],
            ]);
        }
        else
        {
            Widgets::insert([
                [
                    'id' => 8,
                    'widget_area' => NULL,
                    'widget_order' => 3,
                    'widget_location' => 'footer',
                    'widget_name' => 'FooterContact',
                    'widget_content' => 'a:8:{s:2:"id";s:1:"8";s:11:"widget_name";s:13:"FooterContact";s:11:"widget_type";s:6:"update";s:15:"widget_location";s:6:"footer";s:12:"widget_order";s:1:"1";s:9:"namespace";s:60:"Plugins\WidgetBuilder\Widgets\Tenants\ThemeOne\FooterContact";s:5:"title";s:10:"Contact Us";s:23:"footer_contact_repeater";a:2:{s:11:"field_type_";a:2:{i:0;s:5:"email";i:1;s:6:"number";}s:12:"field_value_";a:2:{i:0;s:19:"misujom01@gmail.com";i:1;s:11:"02083483945";}}}',
                    'created_at' => '2023-05-25 17:10:40',
                    'updated_at' => '2023-05-25 17:10:40',
                    'widget_namespace' => 'Plugins\WidgetBuilder\Widgets\Tenants\ThemeOne\FooterContact'
                ],
                [
                    'id' => 9,
                    'widget_area' => NULL,
                    'widget_order' => 1,
                    'widget_location' => 'footer',
                    'widget_name' => 'SocialFollowWidget',
                    'widget_content' => 'a:7:{s:11:"widget_name";s:18:"SocialFollowWidget";s:11:"widget_type";s:3:"new";s:15:"widget_location";s:6:"footer";s:12:"widget_order";s:1:"1";s:9:"namespace";s:65:"Plugins\WidgetBuilder\Widgets\Tenants\ThemeOne\SocialFollowWidget";s:5:"title";s:9:"Follow Us";s:20:"footer_social_follow";a:2:{s:14:"repeater_icon_";a:4:{i:0;s:17:"lab la-facebook-f";i:1;s:14:"lab la-twitter";i:2;s:16:"lab la-instagram";i:3;s:14:"lab la-youtube";}s:18:"repeater_icon_url_";a:4:{i:0;s:1:"#";i:1;s:1:"#";i:2;s:1:"#";i:3;s:1:"#";}}}',
                    'created_at' => '2023-05-25 17:10:40',
                    'updated_at' => '2023-05-25 17:10:40',
                    'widget_namespace' => 'Plugins\WidgetBuilder\Widgets\Tenants\ThemeOne\SocialFollowWidget'
                ],
                [
                    'id' => 10,
                    'widget_area' => NULL,
                    'widget_order' => 2,
                    'widget_location' => 'footer',
                    'widget_name' => 'FooterAbout',
                    'widget_content' => 'a:8:{s:2:"id";s:2:"10";s:11:"widget_name";s:11:"FooterAbout";s:11:"widget_type";s:6:"update";s:15:"widget_location";s:6:"footer";s:12:"widget_order";s:1:"2";s:9:"namespace";s:58:"Plugins\WidgetBuilder\Widgets\Tenants\ThemeOne\FooterAbout";s:5:"image";s:3:"324";s:11:"description";s:153:"There’s a voice that keeps on calling me. Down the road, that’s where I’ll always be. Every stop I make, I make a new friend. Can’t stay for long";}',
                    'created_at' => '2023-05-25 17:10:40',
                    'updated_at' => '2023-05-25 17:10:40',
                    'widget_namespace' => 'Plugins\WidgetBuilder\Widgets\Tenants\ThemeOne\FooterAbout'
                ],
                [
                    'id' => 11,
                    'widget_area' => NULL,
                    'widget_order' => 1,
                    'widget_location' => 'footer_bottom',
                    'widget_name' => 'FooterBottomLinksWidget',
                    'widget_content' => 'a:7:{s:2:"id";s:2:"11";s:11:"widget_name";s:23:"FooterBottomLinksWidget";s:11:"widget_type";s:6:"update";s:15:"widget_location";s:13:"footer_bottom";s:12:"widget_order";s:1:"1";s:9:"namespace";s:70:"Plugins\WidgetBuilder\Widgets\Tenants\ThemeOne\FooterBottomLinksWidget";s:11:"navbar_link";s:1:"1";}',
                    'created_at' => '2023-05-25 17:10:40',
                    'updated_at' => '2023-05-25 17:10:40',
                    'widget_namespace' => 'Plugins\WidgetBuilder\Widgets\Tenants\ThemeOne\FooterBottomLinksWidget'
                ],
                [
                    'id' => 12,
                    'widget_area' => NULL,
                    'widget_order' => 1,
                    'widget_location' => 'footer_bottom_left',
                    'widget_name' => 'FooterBottomLinksWidget',
                    'widget_content' => 'a:7:{s:2:"id";s:2:"12";s:11:"widget_name";s:23:"FooterBottomLinksWidget";s:11:"widget_type";s:6:"update";s:15:"widget_location";s:18:"footer_bottom_left";s:12:"widget_order";s:1:"1";s:9:"namespace";s:70:"Plugins\WidgetBuilder\Widgets\Tenants\ThemeOne\FooterBottomLinksWidget";s:11:"navbar_link";s:1:"1";}',
                    'created_at' => '2023-05-25 17:10:40',
                    'updated_at' => '2023-05-25 17:10:40',
                    'widget_namespace' => 'Plugins\WidgetBuilder\Widgets\Tenants\ThemeOne\FooterBottomLinksWidget'
                ],
                [
                    'id' => 13,
                    'widget_area' => NULL,
                    'widget_order' => 1,
                    'widget_location' => 'footer_bottom_right',
                    'widget_name' => 'FooterPaymentGatewaysWidget',
                    'widget_content' => 'a:7:{s:2:"id";s:2:"13";s:11:"widget_name";s:27:"FooterPaymentGatewaysWidget";s:11:"widget_type";s:6:"update";s:15:"widget_location";s:19:"footer_bottom_right";s:12:"widget_order";s:1:"1";s:9:"namespace";s:74:"Plugins\WidgetBuilder\Widgets\Tenants\ThemeOne\FooterPaymentGatewaysWidget";s:22:"footer_payment_gateway";a:2:{s:15:"repeater_image_";a:1:{i:0;s:3:"448";}s:19:"repeater_image_url_";a:1:{i:0;s:1:"#";}}}',
                    'created_at' => '2023-05-25 17:10:40',
                    'updated_at' => '2023-05-25 17:10:40',
                    'widget_namespace' => 'Plugins\WidgetBuilder\Widgets\Tenants\ThemeOne\FooterPaymentGatewaysWidget'
                ],
                [
                    'id' => 14,
                    'widget_area' => NULL,
                    'widget_order' => 1,
                    'widget_location' => 'shop_footer',
                    'widget_name' => 'ShopFooterWidget',
                    'widget_content' => 'a:7:{s:2:"id";s:2:"14";s:11:"widget_name";s:16:"ShopFooterWidget";s:11:"widget_type";s:6:"update";s:15:"widget_location";s:11:"shop_footer";s:12:"widget_order";s:1:"1";s:9:"namespace";s:46:"Plugins\WidgetBuilder\Widgets\ShopFooterWidget";s:17:"services_repeater";a:3:{s:14:"repeater_icon_";a:4:{i:0;s:12:"las la-truck";i:1;s:15:"las la-redo-alt";i:2;s:11:"las la-lock";i:3;s:11:"las la-gift";}s:15:"repeater_title_";a:4:{i:0;s:13:"Free Shipping";i:1;s:11:"Easy Return";i:2;s:14:"Secure payment";i:3;s:10:"Best Offer";}s:18:"repeater_subtitle_";a:4:{i:0;s:14:"Order Over $90";i:1;s:14:"Within 15 Days";i:2;s:15:"Online Shopping";i:3;s:10:"Guaranteed";}}}',
                    'created_at' => '2023-05-25 17:10:40',
                    'updated_at' => '2023-05-25 17:10:40',
                    'widget_namespace' => 'Plugins\WidgetBuilder\Widgets\ShopFooterWidget'
                ]
            ]);
        }
    }
}
