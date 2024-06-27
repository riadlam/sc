<?php


namespace App\Helpers;


use App\Facades\ModuleDataFacade;
use App\Models\PaymentLogs;
use App\Models\PricePlan;
use App\Models\TenantException;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use function __;

class SidebarMenuHelper
{
    public function render_sidebar_menus(): string
    {
        $menu_instance = new \App\Helpers\MenuWithPermission();

        $menu_instance->add_menu_item('dashboard-menu', [
            'route' => 'landlord.admin.home',
            'label' => __('Dashboard'),
            'parent' => null,
            'permissions' => [],
            'icon' => 'mdi mdi-view-dashboard',
        ]);

        $admin = \Auth::guard('admin')->user();

        if ($admin->hasRole('Super Admin')) {
            $this->admin_manage_menus($menu_instance);
            $this->users_manage_menus($menu_instance);
        }

        if (isPluginActive('Blog'))
        {
            $this->blog_settings_menus($menu_instance);
        }

        $this->pages_settings_menus($menu_instance);

        if (isPluginActive('ThemeManage'))
        {
            $this->themes_settings_menus($menu_instance);
        }

        $this->price_plan_settings_menus($menu_instance);
        $this->order_manage_settings_menus($menu_instance);

        if (isPluginActive('Wallet'))
        {
            $this->wallet_manage_settings_menus($menu_instance);
        }

        $this->custom_domain_settings_menus($menu_instance);

        if (isPluginActive('SupportTicket'))
        {
            $this->support_ticket_settings_menus($menu_instance);
        }

        if (isPluginActive('NewsLetter'))
        {
            $this->newsletter_settings_menus($menu_instance);
        }

        $this->testimonial_settings_menus($menu_instance);
        $this->form_builder_settings_menus($menu_instance);
        $this->appearance_settings_menus($menu_instance);

        $this->users_website_issues_manage_menus($menu_instance);

        // External Menu Render
        foreach (getAllExternalMenu() as $externalMenu)
        {
            foreach ($externalMenu as $individual_menu_item){
                $convert_to_array = (array) $individual_menu_item;
                $routeName = $convert_to_array['route'];
                if (isset($routeName) && !empty($routeName) && Route::has($routeName)){
                    $menu_instance->add_menu_item($convert_to_array['id'], $convert_to_array);
                }
            }
        }

        $this->general_settings_menus($menu_instance);

        $this->payment_settings_menus($menu_instance);

        $menu_instance->add_menu_item('languages', [
            'route' => 'landlord.admin.languages',
            'label' => __('Languages'),
            'parent' => null,
            'permissions' => ['language-list', 'language-create', 'language-edit', 'language-delete'],
            'icon' => 'mdi mdi-language-css3',
        ]);
        return $menu_instance->render_menu_items();
    }

    private function pages_settings_menus(MenuWithPermission $menu_instance): void
    {
        $menu_instance->add_menu_item('pages-settings-menu-items', [
            'route' => '#',
            'label' => __('Pages'),
            'parent' => null,
            'permissions' => ['page-list', 'page-create', 'page-edit', 'page-delete'],
            'icon' => 'mdi mdi-file',
        ]);
        $menu_instance->add_menu_item('pages-settings-all-page-settings', [
            'route' => 'landlord.admin.pages',
            'label' => __('All Pages'),
            'parent' => 'pages-settings-menu-items',
            'permissions' => ['page-list'],
        ]);
        $menu_instance->add_menu_item('pages-settings-new-page-settings', [
            'route' => 'landlord.admin.pages.create',
            'label' => __('New Pages'),
            'parent' => 'pages-settings-menu-items',
            'permissions' => ['page-create'],
        ]);
    }

    private function themes_settings_menus(MenuWithPermission $menu_instance): void
    {
        $menu_instance->add_menu_item('themes-settings-menu-items', [
            'route' => '#',
            'label' => __('Themes'),
            'parent' => null,
            'permissions' => ['theme-list', 'theme-edit'],
            'icon' => 'mdi mdi-shape-plus',
        ]);
        $menu_instance->add_menu_item('pages-settings-all-theme-settings', [
            'route' => 'landlord.admin.theme',
            'label' => __('All Themes'),
            'parent' => 'themes-settings-menu-items',
            'permissions' => ['theme-list'],
        ]);
        $menu_instance->add_menu_item('pages-settings-theme-settings', [
            'route' => 'landlord.admin.theme.settings',
            'label' => __('Themes Settings'),
            'parent' => 'themes-settings-menu-items',
            'permissions' => ['theme-settings'],
        ]);
    }

    private function price_plan_settings_menus(MenuWithPermission $menu_instance): void
    {
        $menu_instance->add_menu_item('price-plan-settings-menu-items', [
            'route' => '#',
            'label' => __('Price Plan'),
            'parent' => null,
            'permissions' => ['price-plan-list', 'price-plan-create', 'price-plan-edit', 'price-plan-delete'],
            'icon' => 'mdi mdi-cash-multiple',
        ]);
        $menu_instance->add_menu_item('price-plan-settings-all-page-settings', [
            'route' => 'landlord.admin.price.plan',
            'label' => __('All Price Plan'),
            'parent' => 'price-plan-settings-menu-items',
            'permissions' => ['price-plan-list'],
        ]);
        $menu_instance->add_menu_item('price-plan-settings-new-page-settings', [
            'route' => 'landlord.admin.price.plan.create',
            'label' => __('New Price Plan'),
            'parent' => 'price-plan-settings-menu-items',
            'permissions' => ['price-plan-create'],
        ]);

        $menu_instance->add_menu_item('price-plan-settings-plan-settings', [
            'route' => 'landlord.admin.price.plan.settings',
            'label' => __('Settings'),
            'parent' => 'price-plan-settings-menu-items',
            'permissions' => [''],
        ]);
    }

    private function order_manage_settings_menus(MenuWithPermission $menu_instance): void
    {
        $menu_instance->add_menu_item('order-manage-settings-menu-items', [
            'route' => '#',
            'label' => __('Package Order Manage'),
            'parent' => null,
            'permissions' => ['package-order-all-order', 'package-order-pending-order', 'package-order-pending-order',
                'package-order-progress-order', 'package-order-complete-order', 'package-order-success-order-page', 'package-order-cancel-order-page',
                'package-order-order-page-manage', 'package-order-order-report', 'package-order-payment-logs', 'package-order-payment-report'
            ],
            'icon' => 'mdi mdi-cash-multiple',
        ]);
        $menu_instance->add_menu_item('order-manage-all-order-settings-all-page-settings', [
            'route' => 'landlord.admin.package.order.manage.all',
            'label' => __('All Order'),
            'parent' => 'order-manage-settings-menu-items',
            'permissions' => ['package-order-all-order'],
        ]);
        $menu_instance->add_menu_item('order-manage-success-page-settings-new-page-settings', [
            'route' => 'landlord.admin.package.order.success.page',
            'label' => __('Success Order Page'),
            'parent' => 'order-manage-settings-menu-items',
            'permissions' => ['package-order-success-order-page'],
        ]);
        $menu_instance->add_menu_item('order-manage-cancel-page-settings-new-page-settings', [
            'route' => 'landlord.admin.package.order.cancel.page',
            'label' => __('Cancel Order Page'),
            'parent' => 'order-manage-settings-menu-items',
            'permissions' => ['package-order-cancel-order-page'],
        ]);
        $menu_instance->add_menu_item('order-manage-order-page-settings-new-page-settings', [
            'route' => 'landlord.admin.package.order.page',
            'label' => __('Order Page Manage'),
            'parent' => 'order-manage-settings-menu-items',
            'permissions' => ['package-order-order-page-manage'],
        ]);
        $menu_instance->add_menu_item('order-manage-order-report-settings-new-page-settings', [
            'route' => 'landlord.admin.package.order.report',
            'label' => __('Order Report'),
            'parent' => 'order-manage-settings-menu-items',
            'permissions' => ['package-order-order-report'],
        ]);
        $menu_instance->add_menu_item('order-manage-payment-log-settings-new-page-settings', [
            'route' => 'landlord.admin.payment.logs',
            'label' => __('All Payment Logs'),
            'parent' => 'order-manage-settings-menu-items',
            'permissions' => ['package-order-payment-logs'],
        ]);
        $menu_instance->add_menu_item('order-manage-payment-report-settings-new-page-settings', [
            'route' => 'landlord.admin.payment.report',
            'label' => __('Payment Report'),
            'parent' => 'order-manage-settings-menu-items',
            'permissions' => ['package-order-payment-report'],
        ]);
    }

    private function custom_domain_settings_menus(MenuWithPermission $menu_instance): void
    {
        $menu_instance->add_menu_item('custom-domain-settings-menu-items', [
            'route' => '#',
            'label' => __('Custom Domain'),
            'parent' => null,
            'permissions' => [],
            'icon' => 'mdi mdi-cash-multiple',
        ]);
        $menu_instance->add_menu_item('all-pending-custom-domain-request', [
            'route' => 'landlord.admin.custom.domain.requests.all.pending',
            'label' => __('All Pending Request'),
            'parent' => 'custom-domain-settings-menu-items',
            'permissions' => ['package-order-all-order'],
        ]);

        $menu_instance->add_menu_item('all-custom-domain-request', [
            'route' => 'landlord.admin.custom.domain.requests.all',
            'label' => __('All Requests'),
            'parent' => 'custom-domain-settings-menu-items',
            'permissions' => ['package-order-all-order'],
        ]);

        $menu_instance->add_menu_item('all-custom-domain-request-settings', [
            'route' => 'landlord.admin.custom.domain.requests.settings',
            'label' => __('Settings'),
            'parent' => 'custom-domain-settings-menu-items',
            'permissions' => ['package-order-all-order'],
        ]);

    }

    private function testimonial_settings_menus(MenuWithPermission $menu_instance): void
    {
        $menu_instance->add_menu_item('testimonial', [
            'route' => 'landlord.admin.testimonial',
            'label' => __('Testimonial'),
            'parent' => null,
            'permissions' => ['testimonial-list', 'testimonial-create', 'testimonial-edit', 'testimonial-delete'],
            'icon' => 'mdi mdi-format-quote-close',
        ]);
    }

    private function support_ticket_settings_menus(MenuWithPermission $menu_instance): void
    {
        $menu_instance->add_menu_item('support-tickets-settings-menu-items', [
            'route' => '#',
            'label' => __('Support Tickets'),
            'parent' => null,
            'permissions' => ['support-ticket-list', 'support-ticket-create', 'support-ticket-edit', 'support-ticket-delete',],
            'icon' => 'mdi mdi-folder-outline',
        ]);

        $menu_instance->add_menu_item('support-ticket-settings-all', [
            'route' => 'landlord.admin.support.ticket.all',
            'label' => __('All Tickets'),
            'parent' => 'support-tickets-settings-menu-items',
            'permissions' => ['support-ticket-list'],
        ]);

        $menu_instance->add_menu_item('support-ticket-settings-add', [
            'route' => 'landlord.admin.support.ticket.new',
            'label' => __('Add New Ticket'),
            'parent' => 'support-tickets-settings-menu-items',
            'permissions' => ['support-ticket-create'],
        ]);

        $menu_instance->add_menu_item('support-ticket-settings-department', [
            'route' => 'landlord.admin.support.ticket.department',
            'label' => __('Departments'),
            'parent' => 'support-tickets-settings-menu-items',
            'permissions' => ['support-ticket-department-list', 'support-ticket-department-create', 'support-ticket-department-edit', 'support-ticket-department-delete',],
        ]);

        $menu_instance->add_menu_item('support-ticket-settings-setting', [
            'route' => 'landlord.admin.support.ticket.page.settings',
            'label' => __('Page Settings'),
            'parent' => 'support-tickets-settings-menu-items',
            'permissions' => [],
        ]);
    }

    private function blog_settings_menus(MenuWithPermission $menu_instance): void
    {
        $menu_instance->add_menu_item('blog-settings-menu-items', [
            'route' => '#',
            'label' => __('Blogs'),
            'parent' => null,
            'permissions' => ['blog-list', 'blog-create', 'blog-edit', 'blog-delete', 'blog-settings'], //
            'icon' => 'mdi mdi-blogger',
        ]);

        $menu_instance->add_menu_item('blog-all-settings-menu-items', [
            'route' => 'landlord.admin.blog',
            'label' => __('All Blogs'),
            'parent' => 'blog-settings-menu-items',
            'permissions' => ['blog-list'],
        ]);

        $menu_instance->add_menu_item('blog-add-settings-menu-items', [
            'route' => 'landlord.admin.blog.new',
            'label' => __('Add New Blog'),
            'parent' => 'blog-settings-menu-items',
            'permissions' => ['blog-create'],
        ]);

        $menu_instance->add_menu_item('blog-category-settings-all', [
            'route' => 'landlord.admin.blog.category',
            'label' => __('Blog Category'),
            'parent' => 'blog-settings-menu-items',
            'permissions' => ['blog-category-list', 'blog-category-create', 'blog-category-edit', 'blog-category-delete'],
        ]);

        $menu_instance->add_menu_item('blog-settings-all', [
            'route' => 'landlord.admin.blog.settings',
            'label' => __('Settings'),
            'parent' => 'blog-settings-menu-items',
            'permissions' => ['blog-settings'],
        ]);

    }

    private function form_builder_settings_menus(MenuWithPermission $menu_instance): void
    {
        $menu_instance->add_menu_item('form-builder-settings-menu-items', [
            'route' => '#',
            'label' => __('Form Builder'),
            'parent' => null,
            'permissions' => ['form-builder'],
            'icon' => 'mdi mdi-folder-outline',
        ]);

        $menu_instance->add_menu_item('form-builder-settings-all', [
            'route' => 'landlord.admin.form.builder.all',
            'label' => __('Custom Form Builder'),
            'parent' => 'form-builder-settings-menu-items',
            'permissions' => ['form-builder'],
        ]);

        $menu_instance->add_menu_item('form-builder-settings-contact-message', [
            'route' => 'landlord.admin.contact.message.all',
            'label' => __('All Form Submission'),
            'parent' => 'form-builder-settings-menu-items',
            'permissions' => ['form-builder'],
        ]);
    }

    private function appearance_settings_menus(MenuWithPermission $menu_instance): void
    {
        $menu_instance->add_menu_item('appearance-settings-menu-items', [
            'route' => '#',
            'label' => __('Appearance Settings'),
            'parent' => null,
            'permissions' => ['widget-builder', 'highlight-settings', 'breadcrumb-settings', 'menu-manage'],
            'icon' => 'mdi mdi-folder-outline',
        ]);

        $menu_instance->add_menu_item('highlight-settings-all', [
            'route' => 'landlord.admin.highlight',
            'label' => __('Text Highlight Settings'),
            'parent' => 'appearance-settings-menu-items',
            'permissions' => ['highlight-settings'],
        ]);

        $menu_instance->add_menu_item('breadcrumb-settings-all', [
            'route' => 'landlord.admin.breadcrumb',
            'label' => __('Breadcrumb Settings'),
            'parent' => 'appearance-settings-menu-items',
            'permissions' => ['breadcrumb-settings'],
        ]);

        $menu_instance->add_menu_item('widget-builder-settings-all', [
            'route' => 'landlord.admin.widgets',
            'label' => __('Widget Builder'),
            'parent' => 'appearance-settings-menu-items',
            'permissions' => ['widget-builder'],
        ]);

        $menu_instance->add_menu_item('menu-settings-all', [
            'route' => 'landlord.admin.menu',
            'label' => __('Menu Manage'),
            'parent' => 'appearance-settings-menu-items',
            'permissions' => ['menu-manage'],
        ]);

        $menu_instance->add_menu_item('404-settings-all', [
            'route' => 'landlord.admin.404.page.settings',
            'label' => __('404 Settings'),
            'parent' => 'appearance-settings-menu-items',
            'permissions' => [],
        ]);

        $menu_instance->add_menu_item('maintenance-settings-all', [
            'route' => 'landlord.admin.maintains.page.settings',
            'label' => __('Maintenance Settings'),
            'parent' => 'appearance-settings-menu-items',
            'permissions' => [],
        ]);
    }

    private function newsletter_settings_menus(MenuWithPermission $menu_instance): void
    {
        $menu_instance->add_menu_item('newsletter', [
            'route' => '#',
            'label' => __('Newsletter Manage'),
            'parent' => null,
            'permissions' => ['newsletter-list', 'newsletter-create', 'newsletter-edit', 'newsletter-delete'],
            'icon' => 'mdi mdi-newspaper',
        ]);

        $menu_instance->add_menu_item('all-newsletter', [
            'route' => 'landlord.admin.newsletter',
            'label' => __('All Subscribers'),
            'parent' => 'newsletter',
            'permissions' => ['newsletter-list'],

        ]);

        $menu_instance->add_menu_item('mail-send-all-newsletter', [
            'route' => 'landlord.admin.newsletter.mail',
            'label' => __('Send Mail to All'),
            'parent' => 'newsletter',
            'permissions' => [],
        ]);
    }

    private function general_settings_menus(MenuWithPermission $menu_instance): void
    {
        $menu_instance->add_menu_item('general-settings-menu-items', [
            'route' => '#',
            'label' => __('General Settings'),
            'parent' => null,
            'permissions' => ['general-settings-page-settings', 'general-settings-site-identity', 'general-settings-basic-settings', 'general-settings-color-settings',
                'general-settings-typography-settings', 'general-settings-seo-settings', 'general-settings-payment-settings', 'general-settings-third-party-script-settings',
                'general-settings-ssl-settings', 'general-settings-smtp-settings', 'general-settings-custom-css-settings', 'general-settings-custom-js-settings',
                'general-settings-database-upgrade-settings', 'general-settings-cache-clear-settings', 'general-settings-license-settings'],
            'icon' => 'mdi mdi-settings',
        ]);
        $menu_instance->add_menu_item('general-settings-page-settings', [
            'route' => 'landlord.admin.general.page.settings',
            'label' => __('Page Settings'),
            'parent' => 'general-settings-menu-items',
            'permissions' => ['general-settings-page-settings'],
        ]);
        $menu_instance->add_menu_item('general-settings-site-identity', [
            'route' => 'landlord.admin.general.site.identity',
            'label' => __('Site Identity'),
            'parent' => 'general-settings-menu-items',
            'permissions' => ['general-settings-site-identity'],
        ]);
        $menu_instance->add_menu_item('general-settings-basic-settings', [
            'route' => 'landlord.admin.general.basic.settings',
            'label' => __('Basic Settings'),
            'parent' => 'general-settings-menu-items',
            'permissions' => ['general-settings-basic-settings'],
        ]);
        $menu_instance->add_menu_item('general-settings-color-settings', [
            'route' => 'landlord.admin.general.color.settings',
            'label' => __('Color Settings'),
            'parent' => 'general-settings-menu-items',
            'permissions' => ['general-settings-color-settings'],
        ]);
        $menu_instance->add_menu_item('general-settings-typography-settings', [
            'route' => 'landlord.admin.general.typography.settings',
            'label' => __('Typography Settings'),
            'parent' => 'general-settings-menu-items',
            'permissions' => ['general-settings-typography-settings'],
        ]);
        $menu_instance->add_menu_item('general-settings-seo-settings', [
            'route' => 'landlord.admin.general.seo.settings',
            'label' => __('SEO Settings'),
            'parent' => 'general-settings-menu-items',
            'permissions' => ['general-settings-seo-settings'],
        ]);
        $menu_instance->add_menu_item('general-settings-third-party-script-settings', [
            'route' => 'landlord.admin.general.third.party.script.settings',
            'label' => __('Third Party Script'),
            'parent' => 'general-settings-menu-items',
            'permissions' => ['general-settings-third-party-script-settings'],
        ]);
        $menu_instance->add_menu_item('general-settings-smtp-settings', [
            'route' => 'landlord.admin.general.smtp.settings',
            'label' => __('Smtp Settings'),
            'parent' => 'general-settings-menu-items',
            'permissions' => ['general-settings-smtp-settings'],
        ]);

        if (!tenant())
        {
            $menu_instance->add_menu_item('general-settings-ssl-settings', [
                'route' => 'landlord.admin.general.ssl.settings',
                'label' => __('SSL Settings'),
                'parent' => 'general-settings-menu-items',
                'permissions' => ['general-settings-ssl-settings'],
            ]);
        }

        $menu_instance->add_menu_item('general-settings-gdpr-settings', [
            'route' => 'landlord.admin.general.gdpr.settings',
            'label' => __('GDPR Settings'),
            'parent' => 'general-settings-menu-items',
            'permissions' => ['general-settings-gdpr-settings'],
        ]);

        $menu_instance->add_menu_item('general-settings-custom-css-settings', [
            'route' => 'landlord.admin.general.custom.css.settings',
            'label' => __('Custom CSS'),
            'parent' => 'general-settings-menu-items',
            'permissions' => ['general-settings-custom-css-settings'],
        ]);
        $menu_instance->add_menu_item('general-settings-custom-js-settings', [
            'route' => 'landlord.admin.general.custom.js.settings',
            'label' => __('Custom JS'),
            'parent' => 'general-settings-menu-items',
            'permissions' => ['general-settings-custom-js-settings'],
        ]);
        $menu_instance->add_menu_item('general-settings-database-upgrade-settings', [
            'route' => 'landlord.admin.general.database.upgrade.settings',
            'label' => __('Database Upgrade'),
            'parent' => 'general-settings-menu-items',
            'permissions' => ['general-settings-database-upgrade-settings'],
        ]);
        $menu_instance->add_menu_item('general-settings-cache-settings', [
            'route' => 'landlord.admin.general.cache.settings',
            'label' => __('Cache Settings'),
            'parent' => 'general-settings-menu-items',
            'permissions' => ['general-settings-cache-clear-settings'],
        ]);
        $menu_instance->add_menu_item('general-settings-license-settings', [
            'route' => 'landlord.admin.general.license.settings',
            'label' => __('License Settings'),
            'parent' => 'general-settings-menu-items',
            'permissions' => ['general-settings-license-settings'],
        ]);

        $menu_instance->add_menu_item('general-settings-check-update-settings', [
            'route' => 'landlord.admin.general.software.update.settings',
            'label' => __('Check Update'),
            'parent' => 'general-settings-menu-items',
            'permissions' => ['general-settings-license-settings'],
        ]);

    }

    private function payment_settings_menus(MenuWithPermission $menu_instance): void
    {
        $menu_instance->add_menu_item('payment-settings-menu-items', [
            'route' => '#',
            'label' => __('Payment Settings'),
            'parent' => null,
            'permissions' => ['paypal-payment-settings'],
            'icon' => 'mdi mdi-coin',
        ]);
        $menu_instance->add_menu_item('payment-currency-settings', [
            'route' => 'landlord.admin.general.payment.settings',
            'label' => __('Currency Settings'),
            'parent' => 'payment-settings-menu-items',
            'permissions' => ['payment-currency-settings'],
        ]);
        $menu_instance->add_menu_item('paypal-settings-page-settings', [
            'route' => 'landlord.admin.payment.settings.paypal',
            'label' => __('Paypal'),
            'parent' => 'payment-settings-menu-items',
            'permissions' => ['paypal-payment-settings'],
        ]);
        $menu_instance->add_menu_item('paytm-settings-page-settings', [
            'route' => 'landlord.admin.payment.settings.paytm',
            'label' => __('Paytm'),
            'parent' => 'payment-settings-menu-items',
            'permissions' => ['paytm-payment-settings'],
        ]);
        $menu_instance->add_menu_item('stripe-settings-page-settings', [
            'route' => 'landlord.admin.payment.settings.stripe',
            'label' => __('Stripe'),
            'parent' => 'payment-settings-menu-items',
            'permissions' => ['stripe-payment-settings'],
        ]);
        $menu_instance->add_menu_item('razorpay-settings-page-settings', [
            'route' => 'landlord.admin.payment.settings.razorpay',
            'label' => __('Razorpay'),
            'parent' => 'payment-settings-menu-items',
            'permissions' => ['razorpay-payment-settings'],
        ]);
        $menu_instance->add_menu_item('paystack-settings-page-settings', [
            'route' => 'landlord.admin.payment.settings.paystack',
            'label' => __('Paystack'),
            'parent' => 'payment-settings-menu-items',
            'permissions' => ['paystack-payment-settings'],
        ]);
        $menu_instance->add_menu_item('mollie-settings-page-settings', [
            'route' => 'landlord.admin.payment.settings.mollie',
            'label' => __('Mollie'),
            'parent' => 'payment-settings-menu-items',
            'permissions' => ['mollie-payment-settings'],
        ]);
        $menu_instance->add_menu_item('midtrans-settings-page-settings', [
            'route' => 'landlord.admin.payment.settings.midtrans',
            'label' => __('Midtrans'),
            'parent' => 'payment-settings-menu-items',
            'permissions' => ['midtrans-payment-settings'],
        ]);
        $menu_instance->add_menu_item('cashfree-settings-page-settings', [
            'route' => 'landlord.admin.payment.settings.cashfree',
            'label' => __('Cashfree'),
            'parent' => 'payment-settings-menu-items',
            'permissions' => ['cashfree-payment-settings'],
        ]);
        $menu_instance->add_menu_item('instamojo-settings-page-settings', [
            'route' => 'landlord.admin.payment.settings.instamojo',
            'label' => __('Instamojo'),
            'parent' => 'payment-settings-menu-items',
            'permissions' => ['instamojo-payment-settings'],
        ]);
        $menu_instance->add_menu_item('marcadopago-settings-page-settings', [
            'route' => 'landlord.admin.payment.settings.marcadopago',
            'label' => __('Marcadopago'),
            'parent' => 'payment-settings-menu-items',
            'permissions' => ['marcadopago-payment-settings'],
        ]);
        $menu_instance->add_menu_item('zitopay-settings-page-settings', [
            'route' => 'landlord.admin.payment.settings.zitopay',
            'label' => __('Zitopay'),
            'parent' => 'payment-settings-menu-items',
            'permissions' => ['zitopay-payment-settings'],
        ]);
        $menu_instance->add_menu_item('squareup-settings-page-settings', [
            'route' => 'landlord.admin.payment.settings.squareup',
            'label' => __('Squareup'),
            'parent' => 'payment-settings-menu-items',
            'permissions' => ['squareup-payment-settings'],
        ]);
        $menu_instance->add_menu_item('cinetpay-settings-page-settings', [
            'route' => 'landlord.admin.payment.settings.cinetpay',
            'label' => __('Cinetpay'),
            'parent' => 'payment-settings-menu-items',
            'permissions' => ['cinetpay-payment-settings'],
        ]);
        $menu_instance->add_menu_item('paytabs-settings-page-settings', [
            'route' => 'landlord.admin.payment.settings.paytabs',
            'label' => __('Paytabs'),
            'parent' => 'payment-settings-menu-items',
            'permissions' => ['paytabs-payment-settings'],
        ]);
        $menu_instance->add_menu_item('billplz-settings-page-settings', [
            'route' => 'landlord.admin.payment.settings.billplz',
            'label' => __('Billplz'),
            'parent' => 'payment-settings-menu-items',
            'permissions' => ['billplz-payment-settings'],
        ]);
        $menu_instance->add_menu_item('toyyibpay-settings-page-settings', [
            'route' => 'landlord.admin.payment.settings.toyyibpay',
            'label' => __('Toyyibpay'),
            'parent' => 'payment-settings-menu-items',
            'permissions' => ['toyyibpay-payment-settings'],
        ]);
        $menu_instance->add_menu_item('flutterwave-settings-page-settings', [
            'route' => 'landlord.admin.payment.settings.flutterwave',
            'label' => __('Flutterwave'),
            'parent' => 'payment-settings-menu-items',
            'permissions' => ['flutterwave-payment-settings'],
        ]);
        $menu_instance->add_menu_item('payfast-settings-page-settings', [
            'route' => 'landlord.admin.payment.settings.payfast',
            'label' => __('Payfast'),
            'parent' => 'payment-settings-menu-items',
            'permissions' => ['payfast-payment-settings'],
        ]);
        $menu_instance->add_menu_item('manual_payment-settings-page-settings', [
            'route' => 'landlord.admin.payment.settings.manual_payment',
            'label' => __('Manual Payment'),
            'parent' => 'payment-settings-menu-items',
            'permissions' => ['manual_payment-payment-settings'],
        ]);

        // External Menu Render
        foreach (getAllExternalPaymentGatewayMenu() as $externalMenu)
        {
            foreach ($externalMenu as $individual_menu_item){
                $convert_to_array = (array) $individual_menu_item;
                $convert_to_array['parent'] = 'payment-settings-menu-items';

                $routeName = $convert_to_array['route'];
                if (isset($routeName) && !empty($routeName) && Route::has($routeName)){
                    $menu_instance->add_menu_item($convert_to_array['id'], $convert_to_array);
                }
            }
        }

    }

    private function users_manage_menus(MenuWithPermission $menu_instance): void
    {
        $menu_instance->add_menu_item('users-manage-settings-menu-items', [
            'route' => '#',
            'label' => __('Users Manage'),
            'parent' => null,
            'permissions' => [],
            'icon' => 'mdi mdi-account-multiple',
        ]);
        $menu_instance->add_menu_item('users-manage-settings-list-menu-items', [
            'route' => 'landlord.admin.tenant',
            'label' => __('All Users'),
            'parent' => 'users-manage-settings-menu-items',
            'permissions' => [],
        ]);
        $menu_instance->add_menu_item('users-manage-settings-add-new-menu-items', [
            'route' => 'landlord.admin.tenant.new',
            'label' => __('Add New'),
            'parent' => 'users-manage-settings-menu-items',
            'permissions' => [],
        ]);

        $menu_instance->add_menu_item('users-manage-settings-activity-log', [
            'route' => 'landlord.admin.tenant.activity.log',
            'label' => __('Activity Log'),
            'parent' => 'users-manage-settings-menu-items',
            'permissions' => [],
        ]);

        $menu_instance->add_menu_item('users-manage-settings', [
            'route' => 'landlord.admin.tenant.settings',
            'label' => __('Account Settings'),
            'parent' => 'users-manage-settings-menu-items',
            'permissions' => [],
        ]);

        $menu_instance->add_menu_item('users-manage-failed-tenant-settings', [
            'route' => 'landlord.admin.tenant.failed.index',
            'label' => __('Failed Tenants'),
            'parent' => 'users-manage-settings-menu-items',
            'permissions' => [],
        ]);
    }

    private function admin_manage_menus(MenuWithPermission $menu_instance): void
    {
        $menu_instance->add_menu_item('admin-manage-settings-menu-items', [
            'route' => '#',
            'label' => __('Admin Role Manage'),
            'parent' => null,
            'permissions' => [],
            'icon' => 'mdi mdi-account-multiple',
        ]);
        $menu_instance->add_menu_item('admins-manage-settings-list-menu-items', [
            'route' => 'landlord.admin.all.user',
            'label' => __('All Admin'),
            'parent' => 'admin-manage-settings-menu-items',
            'permissions' => [],
        ]);
        $menu_instance->add_menu_item('admins-manage-settings-add-new-menu-items', [
            'route' => 'landlord.admin.new.user',
            'label' => __('Add New Admin'),
            'parent' => 'admin-manage-settings-menu-items',
            'permissions' => [],
        ]);
        $menu_instance->add_menu_item('admins-role-manage-settings-add-new-menu-items', [
            'route' => 'landlord.admin.all.admin.role',
            'label' => __('All Admin Role'),
            'parent' => 'admin-manage-settings-menu-items',
            'permissions' => [],
        ]);
    }

    private function wallet_manage_settings_menus(MenuWithPermission $menu_instance): void
    {
        $menu_instance->add_menu_item('wallet-manage-settings-menu-items', [
            'route' => '#',
            'label' => __('Wallet Manage'),
            'parent' => null,
            'permissions' => ['wallet-list','wallet-history'],
            'icon' => 'mdi mdi-cash-register',
        ]);
        $menu_instance->add_menu_item('wallet-manage-settings-list-menu-items', [
            'route' => 'landlord.admin.wallet.lists',
            'label' => __('All Wallet'),
            'parent' => 'wallet-manage-settings-menu-items',
            'permissions' => ['wallet-list'],
        ]);
        $menu_instance->add_menu_item('wallet-manage-settings-history-menu-items', [
            'route' => 'landlord.admin.wallet.history',
            'label' => __('Wallet History'),
            'parent' => 'wallet-manage-settings-menu-items',
            'permissions' => ['wallet-history'],
        ]);
        $menu_instance->add_menu_item('wallet-manage-settings-admin-menu-items', [
            'route' => 'landlord.admin.wallet.settings',
            'label' => __('Wallet Settings'),
            'parent' => 'wallet-manage-settings-menu-items',
            'permissions' => ['wallet-history'],
        ]);
    }

    private function users_website_issues_manage_menus(MenuWithPermission $menu_instance) : void
    {
        $menu_instance->add_menu_item('users-website-issues-manage-settings-menu-items', [
            'route' => '#',
            'label' => __('User Website'),
            'parent' => null,
            'permissions' => [],
            'icon' => 'mdi mdi-bug-check-outline',
        ]);
        $menu_instance->add_menu_item('users-website-manage-settings-list-menu-items', [
            'route' => 'landlord.admin.tenant.website.issues',
            'label' => __('User website Issues'),
            'parent' => 'users-website-issues-manage-settings-menu-items',
            'permissions' => [],
        ]);

    }


    /* tenent menu */
    public function render_tenant_sidebar_menus(): string
    {
        $menu_instance = new \App\Helpers\MenuWithPermission();

        $current_tenant_payment_data = tenant()->payment_log ?? [];
        $admin = \Auth::guard('admin')->user();

        $menu_instance->add_menu_item('tenant-dashboard-menu', [
            'route' => 'tenant.admin.dashboard',
            'label' => __('Dashboard'),
            'parent' => null,
            'permissions' => [],
            'icon' => 'mdi mdi-home',
        ]);

        if ($admin->hasRole('Super Admin')) {
            $this->tenant_admin_manage_menus($menu_instance);
        }

        if ($admin->hasRole('Super Admin')) {
            $this->tenant_users_manage_menus($menu_instance);
        }

        $this->tenant_order_manage_settings_menus($menu_instance);

        $this->tenant_sales_report_settings_menus($menu_instance);

        $this->tenant_pages_settings_menus($menu_instance);

        if (isPluginActive('SupportTicket'))
        {
            $this->tenant_support_ticket_settings_menus($menu_instance);
        }

        if (isPluginActive('RefundModule'))
        {
            $this->tenant_refund_settings_menus($menu_instance);
        }

        if (isPluginActive('Blog'))
        {
            $this->tenant_blog_settings_menus($menu_instance);
        }

        if (isPluginActive('Badge'))
        {
            $this->tenant_badge_settings_menus($menu_instance);
        }

        $this->tenant_country_settings_menus($menu_instance);
        $this->tenant_tax_settings_menus($menu_instance);

        $this->tenant_shipping_settings_menus($menu_instance);

        if (tenant_plan_sidebar_permission('coupon'))
        {
            $this->tenant_coupon_settings_menus($menu_instance);
        }

        if (isPluginActive('Attributes'))
        {
            $this->tenant_attribute_settings_menus($menu_instance);
        }

        if (isPluginActive('Product'))
        {
            $this->tenant_product_settings_menus($menu_instance);
        }

        if (isPluginActive('DigitalProduct'))
        {
            if (tenant_plan_sidebar_permission('digital_product'))
            {
                $this->tenant_digital_product_settings_menus($menu_instance);
            }
        }

        if (isPluginActive('Inventory'))
        {
            if (tenant_plan_sidebar_permission('inventory'))
            {
                $this->tenant_inventory_settings_menus($menu_instance);
            }
        }


        if (isPluginActive('Campaign'))
        {
            if (tenant_plan_sidebar_permission('campaign'))
            {
                $this->tenant_campaign_settings_menus($menu_instance);
            }
        }

        if (tenant_plan_sidebar_permission('testimonial'))
        {
            $this->tenant_testimonial_settings_menus($menu_instance);
        }

        if (isPluginActive('NewsLetter'))
        {
            if (tenant_plan_sidebar_permission('newsletter'))
            {
                $this->tenant_newsletter_settings_menus($menu_instance);
            }
        }


        $this->tenant_form_builder_settings_menus($menu_instance);

        if ($admin->hasRole('Super Admin')) {
            $this->tenant_payment_manage_menus($menu_instance);
        }

        if (tenant_plan_sidebar_permission('custom_domain'))
        {
            $this->tenant_custom_domain_request_settings_menus($menu_instance);
        }

        // External Menu Render
        foreach (getAllExternalMenu() as $externalMenu)
        {
            foreach ($externalMenu as $individual_menu_item){
                $convert_to_array = (array) $individual_menu_item;
                $routeName = $convert_to_array['route'];
                if (isset($routeName) && !empty($routeName) && Route::has($routeName)){
                    $menu_instance->add_menu_item($convert_to_array['id'], $convert_to_array);
                }
            }
        }

        if (isPluginActive('MobileApp'))
        {
            $this->tenant_mobile_app_settings_menus($menu_instance);
        }

        $this->tenant_appearance_settings_menus($menu_instance);

        $this->tenant_general_settings_menus($menu_instance);

        $this->tenant_payment_settings_menus($menu_instance);

        $menu_instance->add_menu_item('tenant-languages', [
            'route' => 'tenant.admin.languages',
            'label' => __('Languages'),
            'parent' => null,
            'permissions' => ['language-list', 'language-create', 'language-edit', 'language-delete'],
            'icon' => 'mdi mdi-polymer ',
        ]);

        return $menu_instance->render_menu_items();
    }

    private function tenant_order_manage_settings_menus(MenuWithPermission $menu_instance): void
    {
        $menu_instance->add_menu_item('product-order-manage-settings', [
            'route' => '#',
            'label' => __('Product Order Manage'),
            'parent' => null,
            'permissions' => ['product-order-all-order', 'product-order-pending-order',
                'product-progress-order', 'product-order-complete', 'product-order-success-page', 'product-order-cancel-page',
                'product-order-page-manage', 'product-order-report', 'product-order-payment-logs', 'product-order-payment-report',
                'product-order-manage-settings', 'product-order-invoice-settings'
            ],
            'icon' => 'mdi mdi-cart',
        ]);
        $menu_instance->add_menu_item('product-order-manage-settings-all-order', [
            'route' => 'tenant.admin.product.order.manage.all',
            'label' => __('All Order'),
            'parent' => 'product-order-manage-settings',
            'permissions' => ['product-order-all-order'],
        ]);
        $menu_instance->add_menu_item('product-order-manage-settings-success-page', [
            'route' => 'tenant.admin.product.order.success.page',
            'label' => __('Success Order Page'),
            'parent' => 'product-order-manage-settings',
            'permissions' => ['product-order-success-page'],
        ]);
        $menu_instance->add_menu_item('product-order-manage-settings-cancel-page', [
            'route' => 'tenant.admin.product.order.cancel.page',
            'label' => __('Cancel Order Page'),
            'parent' => 'product-order-manage-settings',
            'permissions' => ['product-order-cancel-page'],
        ]);
        $menu_instance->add_menu_item('product-order-manage-settings-order-settings', [
            'route' => 'tenant.admin.product.order.settings',
            'label' => __('Order Settings'),
            'parent' => 'product-order-manage-settings',
            'permissions' => ['product-order-manage-settings'],
        ]);
        $menu_instance->add_menu_item('invoice-settings-order-settings', [
            'route' => 'tenant.admin.product.invoice.settings',
            'label' => __('Invoice Settings'),
            'parent' => 'product-order-manage-settings',
            'permissions' => ['product-order-invoice-settings'],
        ]);
    }

    private function tenant_sales_report_settings_menus(MenuWithPermission $menu_instance): void
    {
        $menu_instance->add_menu_item('sales-report-settings', [
            'route' => '#',
            'label' => __('Sales Report'),
            'parent' => null,
            'permissions' => ['sales-report-all-settings', 'sales-report-manage-settings','sales-report-weekly'],
            'icon' => 'mdi mdi-chart-line',
        ]);
        $menu_instance->add_menu_item('sales-report-all-settings', [
            'route' => 'tenant.admin.sales.dashboard',
            'label' => __('All Report'),
            'parent' => 'sales-report-settings',
            'permissions' => ['sales-report-all-settings'],
        ]);
        $menu_instance->add_menu_item('sales-report-weekly', [
            'route' => 'tenant.admin.sales.report.weekly',
            'label' => __('Weekly Report'),
            'parent' => 'sales-report-settings',
            'permissions' => ['sales-report-weekly'],
        ]);
        $menu_instance->add_menu_item('sales-report-monthly', [
            'route' => 'tenant.admin.sales.report.monthly',
            'label' => __('Monthly Report'),
            'parent' => 'sales-report-settings',
            'permissions' => ['sales-report-monthly'],
        ]);
        $menu_instance->add_menu_item('sales-report-yearly', [
            'route' => 'tenant.admin.sales.report.yearly',
            'label' => __('Yearly Report'),
            'parent' => 'sales-report-settings',
            'permissions' => ['sales-report-yearly'],
        ]);
        $menu_instance->add_menu_item('sales-report-range', [
            'route' => '#',
            'label' => __('Range Report (Coming Soon)'),
            'parent' => 'sales-report-settings',
            'permissions' => [],
            'class' => 'submenu-disabled'
        ]);
        $menu_instance->add_menu_item('sales-report-export', [
            'route' => '#',
            'label' => __('Export Report (Coming Soon)'),
            'parent' => 'sales-report-settings',
            'permissions' => [],
            'class' => 'submenu-disabled'
        ]);
        $menu_instance->add_menu_item('sales-report-manage-settings', [
            'route' => 'tenant.admin.sales.settings',
            'label' => __('Report Settings'),
            'parent' => 'sales-report-settings',
            'permissions' => ['sales-report-manage-settings'],
        ]);
    }

    private function tenant_pages_settings_menus(MenuWithPermission $menu_instance): void
    {
        $menu_instance->add_menu_item('pages-settings-menu-items', [
            'route' => '#',
            'label' => __('Pages'),
            'parent' => null,
            'permissions' => ['page-list', 'page-create', 'page-edit', 'page-delete'],
            'icon' => 'mdi mdi-file',
        ]);
        $menu_instance->add_menu_item('pages-settings-all-page-settings', [
            'route' => 'tenant.admin.pages',
            'label' => __('All Pages'),
            'parent' => 'pages-settings-menu-items',
            'permissions' => ['page-list'],
        ]);
        $menu_instance->add_menu_item('pages-settings-new-page-settings', [
            'route' => 'tenant.admin.pages.create',
            'label' => __('New Pages'),
            'parent' => 'pages-settings-menu-items',
            'permissions' => ['page-create'],
        ]);
    }

    private function tenant_newsletter_settings_menus(MenuWithPermission $menu_instance): void
    {
        $menu_instance->add_menu_item('newsletter', [
            'route' => '#',
            'label' => __('Newsletter Manage'),
            'parent' => null,
            'permissions' => ['newsletter-list', 'newsletter-create', 'newsletter-edit', 'newsletter-delete'],
            'icon' => 'mdi mdi-newspaper',
        ]);

        $menu_instance->add_menu_item('all-newsletter', [
            'route' => 'tenant.admin.newsletter',
            'label' => __('All Subscribers'),
            'parent' => 'newsletter',
            'permissions' => ['newsletter-list'],

        ]);

        $menu_instance->add_menu_item('mail-send-all-newsletter', [
            'route' => 'tenant.admin.newsletter.mail',
            'label' => __('Send Mail to All'),
            'parent' => 'newsletter',
            'permissions' => [],
        ]);
    }

    private function tenant_blog_settings_menus(MenuWithPermission $menu_instance): void
    {
        $menu_instance->add_menu_item('blog-settings-menu-items', [
            'route' => '#',
            'label' => __('Blogs'),
            'parent' => null,
            'permissions' => ['blog-list', 'blog-create', 'blog-edit', 'blog-delete', 'blog-settings'],
            'icon' => 'mdi mdi-blogger',
        ]);

        $menu_instance->add_menu_item('blog-all-settings-menu-items', [
            'route' => 'tenant.admin.blog',
            'label' => __('All Blogs'),
            'parent' => 'blog-settings-menu-items',
            'permissions' => ['blog-list'],
        ]);

        $menu_instance->add_menu_item('blog-add-settings-menu-items', [
            'route' => 'tenant.admin.blog.new',
            'label' => __('Add New Blog'),
            'parent' => 'blog-settings-menu-items',
            'permissions' => ['blog-create'],
        ]);

        $menu_instance->add_menu_item('blog-category-settings-all', [
            'route' => 'tenant.admin.blog.category',
            'label' => __('Blog Category'),
            'parent' => 'blog-settings-menu-items',
            'permissions' => ['blog-category-list'],
        ]);

        $menu_instance->add_menu_item('blog-tag-settings-all', [
            'route' => 'tenant.admin.blog.tag',
            'label' => __('Blog Tag'),
            'parent' => 'blog-settings-menu-items',
            'permissions' => ['blog-tag-list'],
        ]);

        $menu_instance->add_menu_item('blog-settings-all', [
            'route' => 'tenant.admin.blog.settings',
            'label' => __('Settings'),
            'parent' => 'blog-settings-menu-items',
            'permissions' => ['blog-settings'],
        ]);

    }

    private function tenant_badge_settings_menus(MenuWithPermission $menu_instance): void
    {
        $menu_instance->add_menu_item('badge-settings-menu-items', [
            'route' => '#',
            'label' => __('Badge Manage'),
            'parent' => null,
            'permissions' => [
                'badge-list', 'badge-create', 'badge-edit', 'badge-delete',
            ],
            'icon' => 'mdi mdi-label',
        ]);

        $menu_instance->add_menu_item('badge-all-settings-menu-items', [
            'route' => 'tenant.admin.badge.all',
            'label' => __('Badge Manage'),
            'parent' => 'badge-settings-menu-items',
            'permissions' => ['badge-list'],
        ]);

        $menu_instance->add_menu_item('state-all-settings-menu-items', [
            'route' => 'tenant.admin.state.all',
            'label' => __('State Manage'),
            'parent' => 'country-settings-menu-items',
            'permissions' => ['state-list'],
        ]);
    }

    private function tenant_country_settings_menus(MenuWithPermission $menu_instance): void
    {
        $menu_instance->add_menu_item('country-settings-menu-items', [
            'route' => '#',
            'label' => __('Country Manage'),
            'parent' => null,
            'permissions' => [
                'country-list', 'country-create', 'country-edit', 'country-delete',
                'state-list', 'state-create', 'state-edit', 'state-delete'
            ],
            'icon' => 'mdi mdi-map',
        ]);

        $menu_instance->add_menu_item('country-all-settings-menu-items', [
            'route' => 'tenant.admin.country.all',
            'label' => __('Country Manage'),
            'parent' => 'country-settings-menu-items',
            'permissions' => ['country-list'],
        ]);

        $menu_instance->add_menu_item('state-all-settings-menu-items', [
            'route' => 'tenant.admin.state.all',
            'label' => __('State Manage'),
            'parent' => 'country-settings-menu-items',
            'permissions' => ['state-list'],
        ]);
    }

    private function tenant_tax_settings_menus(MenuWithPermission $menu_instance): void
    {
        $menu_instance->add_menu_item('tax-settings-menu-items', [
            'route' => '#',
            'label' => __('Tax Manage'),
            'parent' => null,
            'permissions' => [
                'country-tax-list', 'country-tax-create', 'country-tax-edit', 'country-tax-delete',
                'state-tax-list', 'state-tax-create', 'state-tax-edit', 'state-tax-delete'
            ],
            'icon' => 'mdi mdi-cash',
        ]);

        $menu_instance->add_menu_item('tax-country-settings-menu-items', [
            'route' => 'tenant.admin.tax.country.all',
            'label' => __('Country Tax Manage'),
            'parent' => 'tax-settings-menu-items',
            'permissions' => ['country-tax-list'],
        ]);

        $menu_instance->add_menu_item('tax-state-settings-menu-items', [
            'route' => 'tenant.admin.tax.state.all',
            'label' => __('State Tax Manage'),
            'parent' => 'tax-settings-menu-items',
            'permissions' => ['state-tax-list'],
        ]);
    }

    private function tenant_shipping_settings_menus(MenuWithPermission $menu_instance): void
    {
        $menu_instance->add_menu_item('shipping-settings-menu-items', [
            'route' => '#',
            'label' => __('Shipping Manage'),
            'parent' => null,
            'permissions' => [
                'shipping-method-list', 'shipping-method-create', 'shipping-method-edit', 'shipping-method-delete', 'shipping-method-make',
                'shipping-zone-list', 'shipping-zone-create', 'shipping-zone-edit', 'shipping-zone-delete'
            ],
            'icon' => 'mdi mdi-truck',
        ]);

        $menu_instance->add_menu_item('shipping-zone-settings-menu-items', [
            'route' => 'tenant.admin.shipping.zone.all',
            'label' => __('Shipping Zone'),
            'parent' => 'shipping-settings-menu-items',
            'permissions' => ['shipping-zone-list'],
        ]);

        $menu_instance->add_menu_item('shipping-method-settings-menu-items', [
            'route' => 'tenant.admin.shipping.method.all',
            'label' => __('Shipping Method'),
            'parent' => 'shipping-settings-menu-items',
            'permissions' => ['shipping-method-list'],
        ]);
    }

    private function tenant_coupon_settings_menus(MenuWithPermission $menu_instance): void
    {
        $menu_instance->add_menu_item('coupon-settings-menu-items', [
            'route' => '#',
            'label' => __('Coupon Manage'),
            'parent' => null,
            'permissions' => [
                'product-coupon-list', 'product-coupon-create', 'product-coupon-edit', 'product-coupon-delete',
            ],
            'icon' => 'mdi mdi-ticket-percent',
        ]);

        $menu_instance->add_menu_item('product-coupon-settings-menu-items', [
            'route' => 'tenant.admin.product.coupon.all',
            'label' => __('All Coupon'),
            'parent' => 'coupon-settings-menu-items',
            'permissions' => ['product-coupon-list'],
        ]);
    }

    private function tenant_attribute_settings_menus(MenuWithPermission $menu_instance): void
    {
        $menu_instance->add_menu_item('product-attribute-menu-items', [
            'route' => '#',
            'label' => __('Attribute'),
            'parent' => null,
            'permissions' => [
                'product-category-list', 'product-category-create', 'product-category-edit', 'product-category-delete',
                'product-sub-category-list', 'product-sub-category-create', 'product-sub-category-edit', 'product-sub-category-delete',
                'product-child-category-list', 'product-child-category-create', 'product-child-category-edit', 'product-child-category-delete',
                'product-tag-list', 'product-tag-create', 'product-tag-edit', 'product-tag-delete',
                'product-unit-list', 'product-unit-create', 'product-unit-edit', 'product-unit-delete',
                'product-color-list', 'product-color-create', 'product-color-edit', 'product-color-delete',
                'product-size-list', 'product-size-create', 'product-size-edit', 'product-size-delete',
                'product-delivery-option-list', 'product-delivery-option-create', 'product-delivery-option-edit', 'product-delivery-option-delete',
                'product-attribute-list'
            ],
            'icon' => 'mdi mdi-format-list-checks',
        ]);

        $menu_instance->add_menu_item('product-category-settings-menu-items', [
            'route' => 'tenant.admin.product.category.all',
            'label' => __('Category Manage'),
            'parent' => 'product-attribute-menu-items',
            'permissions' => ['product-category-list'],
        ]);

        $menu_instance->add_menu_item('product-sub-category-settings-menu-items', [
            'route' => 'tenant.admin.product.subcategory.all',
            'label' => __('Subcategory Manage'),
            'parent' => 'product-attribute-menu-items',
            'permissions' => ['product-sub-category-list'],
        ]);

        $menu_instance->add_menu_item('product-child-category-settings-menu-items', [
            'route' => 'tenant.admin.product.child-category.all',
            'label' => __('Child Category Manage'),
            'parent' => 'product-attribute-menu-items',
            'permissions' => ['product-child-category-list'],
        ]);

        $menu_instance->add_menu_item('product-tag-settings-menu-items', [
            'route' => 'tenant.admin.product.tag.all',
            'label' => __('Tags Manage'),
            'parent' => 'product-attribute-menu-items',
            'permissions' => ['product-tag-list'],
        ]);

        $menu_instance->add_menu_item('product-unit-settings-menu-items', [
            'route' => 'tenant.admin.product.units.all',
            'label' => __('Unit Manage'),
            'parent' => 'product-attribute-menu-items',
            'permissions' => ['product-unit-list'],
        ]);
        $menu_instance->add_menu_item('product-color-settings-menu-items', [
            'route' => 'tenant.admin.product.colors.all',
            'label' => __('Color Manage'),
            'parent' => 'product-attribute-menu-items',
            'permissions' => ['product-color-list'],
        ]);
        $menu_instance->add_menu_item('product-size-settings-menu-items', [
            'route' => 'tenant.admin.product.sizes.all',
            'label' => __('Size Manage'),
            'parent' => 'product-attribute-menu-items',
            'permissions' => ['product-size-list'],
        ]);
        $menu_instance->add_menu_item('product-brand-settings-menu-items', [
            'route' => 'tenant.admin.product.brand.manage.all',
            'label' => __('Brand Manage'),
            'parent' => 'product-attribute-menu-items',
            'permissions' => ['product-brand-list'],
        ]);
        $menu_instance->add_menu_item('product-delivery-option-settings-menu-items', [
            'route' => 'tenant.admin.product.delivery.option.all',
            'label' => __('Delivery Option Manage'),
            'parent' => 'product-attribute-menu-items',
            'permissions' => ['product-delivery-option-list'],
        ]);
        $menu_instance->add_menu_item('product-attribute-settings-menu-items', [
            'route' => 'tenant.admin.products.attributes.all',
            'label' => __('Product Attribute'),
            'parent' => 'product-attribute-menu-items',
            'permissions' => ['product-attribute-list'],
        ]);
    }

    private function tenant_product_settings_menus(MenuWithPermission $menu_instance): void
    {
        $menu_instance->add_menu_item('product-settings-menu-items', [
            'route' => '#',
            'label' => __('Products'),
            'parent' => null,
            'permissions' => ['product-list', 'product-create', 'product-edit', 'product-delete', 'product-settings', 'product-reviews'],
            'icon' => 'mdi mdi-shopping',
        ]);

        $menu_instance->add_menu_item('product-all-settings-menu-items', [
            'route' => 'tenant.admin.product.all',
            'label' => __('All Products'),
            'parent' => 'product-settings-menu-items',
            'permissions' => ['product-list'],
        ]);

        $menu_instance->add_menu_item('product-create-menu-items', [
            'route' => 'tenant.admin.product.create',
            'label' => __('Add New Product'),
            'parent' => 'product-settings-menu-items',
            'permissions' => ['product-create'],
        ]);

        $menu_instance->add_menu_item('product-global-settings-menu-items', [
            'route' => 'tenant.admin.product.settings',
            'label' => __('Product Settings'),
            'parent' => 'product-settings-menu-items',
            'permissions' => ['product-settings'],
        ]);

        $menu_instance->add_menu_item('product-reviews-menu-items', [
            'route' => 'tenant.admin.product.review',
            'label' => __('Review and Rating List'),
            'parent' => 'product-settings-menu-items',
            'permissions' => ['product-reviews'],
        ]);
    }

    private function tenant_digital_product_settings_menus(MenuWithPermission $menu_instance): void
    {
        $menu_instance->add_menu_item('digital-product-settings-menu-items', [
            'route' => '#',
            'label' => __('Digital Products'),
            'parent' => null,
            'permissions' => [
                'digital-product-type-list', 'digital-product-list', 'digital-product-create', 'digital-product-edit', 'digital-product-delete', 'digital-product-settings', 'digital-product-reviews',
                'digital-product-category-list', 'digital-product-subcategory-list', 'digital-product-childcategory-list', 'digital-product-tax-list', 'digital-product-language-list'
            ],
            'icon' => 'mdi mdi-shopping',
        ]);

        $menu_instance->add_menu_item('digital-product-list-settings-menu-items', [
            'route' => 'tenant.admin.digital.product.all',
            'label' => __('All Product'),
            'parent' => 'digital-product-settings-menu-items',
            'permissions' => ['digital-product-list'],
        ]);

        $menu_instance->add_menu_item('digital-product-create-settings-menu-items', [
            'route' => 'tenant.admin.digital.product.create',
            'label' => __('Add New Product'),
            'parent' => 'digital-product-settings-menu-items',
            'permissions' => ['digital-product-create'],
        ]);

        $menu_instance->add_menu_item('digital-product-type-settings-menu-items', [
            'route' => 'tenant.admin.digital.product.type.all',
            'label' => __('Product List Type'),
            'parent' => 'digital-product-settings-menu-items',
            'permissions' => ['digital-product-type-list'],
        ]);

        $menu_instance->add_menu_item('digital-product-category-settings-menu-items', [
            'route' => 'tenant.admin.digital.product.category.all',
            'label' => __('Category Manage'),
            'parent' => 'digital-product-settings-menu-items',
            'permissions' => ['digital-product-category-list'],
        ]);

        $menu_instance->add_menu_item('digital-product-subcategory-settings-menu-items', [
            'route' => 'tenant.admin.digital.product.subcategory.all',
            'label' => __('Sub Category Manage'),
            'parent' => 'digital-product-settings-menu-items',
            'permissions' => ['digital-product-subcategory-list'],
        ]);

        $menu_instance->add_menu_item('digital-product-childcategory-settings-menu-items', [
            'route' => 'tenant.admin.digital.product.childcategory.all',
            'label' => __('Child Category Manage'),
            'parent' => 'digital-product-settings-menu-items',
            'permissions' => ['digital-product-childcategory-list'],
        ]);

        $menu_instance->add_menu_item('digital-product-author-settings-menu-items', [
            'route' => 'tenant.admin.digital.product.author.all',
            'label' => __('Author Manage'),
            'parent' => 'digital-product-settings-menu-items',
            'permissions' => ['digital-product-author-list'],
        ]);

        $menu_instance->add_menu_item('digital-product-language-settings-menu-items', [
            'route' => 'tenant.admin.digital.product.language.all',
            'label' => __('Language Manage'),
            'parent' => 'digital-product-settings-menu-items',
            'permissions' => ['digital-product-language-list'],
        ]);

        $menu_instance->add_menu_item('digital-product-tax-settings-menu-items', [
            'route' => 'tenant.admin.digital.product.tax.all',
            'label' => __('Tax Manage'),
            'parent' => 'digital-product-settings-menu-items',
            'permissions' => ['digital-product-tax-list'],
        ]);

//        $menu_instance->add_menu_item('product-create-menu-items', [
//            'route' => 'tenant.admin.product.create',
//            'label' => __('Add New Product'),
//            'parent' => 'product-settings-menu-items',
//            'permissions' => ['product-create'],
//        ]);
//
//        $menu_instance->add_menu_item('product-reviews-menu-items', [
//            'route' => 'tenant.admin.product.review',
//            'label' => __('Review and Rating List'),
//            'parent' => 'product-settings-menu-items',
//            'permissions' => ['product-reviews'],
//        ]);
    }

    private function tenant_campaign_settings_menus(MenuWithPermission $menu_instance): void
    {
        $menu_instance->add_menu_item('campaign-settings-menu-items', [
            'route' => 'tenant.admin.campaign.all',
            'label' => __('Campaign'),
            'parent' => null,
            'permissions' => ['campaign-list', 'campaign-create', 'campaign-edit', 'campaign-delete', 'campaign-settings'],
            'icon' => 'mdi mdi-shopping',
        ]);
    }

    private function tenant_inventory_settings_menus(MenuWithPermission $menu_instance): void
    {
        $menu_instance->add_menu_item('inventory-settings-menu-items', [
            'route' => '#',
            'label' => __('Inventory'),
            'parent' => null,
            'permissions' => ['inventory-list', 'inventory-create', 'inventory-edit', 'inventory-delete', 'inventory-settings'],
            'icon' => 'mdi mdi-shopping',
        ]);

        $menu_instance->add_menu_item('inventory-manage-settings-menu-items', [
            'route' => 'tenant.admin.product.inventory.all',
            'label' => __('Inventory Manage'),
            'parent' => 'inventory-settings-menu-items',
            'permissions' => ['inventory-list', 'inventory-create', 'inventory-edit', 'inventory-delete'],
        ]);
        $menu_instance->add_menu_item('inventory-stock-settings-menu-items', [
            'route' => 'tenant.admin.product.inventory.settings',
            'label' => __('Inventory Settings'),
            'parent' => 'inventory-settings-menu-items',
            'permissions' => ['inventory-settings'],
        ]);
    }

    private function tenant_testimonial_settings_menus(MenuWithPermission $menu_instance): void
    {
        $menu_instance->add_menu_item('testimonial', [
            'route' => 'tenant.admin.testimonial',
            'label' => __('Testimonial'),
            'parent' => null,
            'permissions' => ['testimonial-list', 'testimonial-create', 'testimonial-edit', 'testimonial-delete'],
            'icon' => 'mdi mdi-format-quote-close',
        ]);
    }

    private function tenant_support_ticket_settings_menus(MenuWithPermission $menu_instance): void
    {
        $menu_instance->add_menu_item('support-tickets-settings-menu-items', [
            'route' => '#',
            'label' => __('Support Tickets'),
            'parent' => null,
            'permissions' => ['support-ticket-list', 'support-ticket-create', 'support-ticket-edit', 'support-ticket-delete',],
            'icon' => 'mdi mdi-folder-outline',
        ]);

        $menu_instance->add_menu_item('support-ticket-settings-all', [
            'route' => 'tenant.admin.support.ticket.all',
            'label' => __('All Tickets'),
            'parent' => 'support-tickets-settings-menu-items',
            'permissions' => ['support-ticket-list'],
        ]);

        $menu_instance->add_menu_item('support-ticket-settings-add', [
            'route' => 'tenant.admin.support.ticket.new',
            'label' => __('Add New Ticket'),
            'parent' => 'support-tickets-settings-menu-items',
            'permissions' => ['support-ticket-create'],
        ]);

        $menu_instance->add_menu_item('support-ticket-settings-department', [
            'route' => 'tenant.admin.support.ticket.department',
            'label' => __('Departments'),
            'parent' => 'support-tickets-settings-menu-items',
            'permissions' => ['support-ticket-department-list', 'support-ticket-department-create', 'support-ticket-department-edit', 'support-ticket-department-delete',],
        ]);

        $menu_instance->add_menu_item('support-ticket-settings-setting', [
            'route' => 'tenant.admin.support.ticket.page.settings',
            'label' => __('Page Settings'),
            'parent' => 'support-tickets-settings-menu-items',
            'permissions' => [],
        ]);
    }

    private function tenant_refund_settings_menus(MenuWithPermission $menu_instance): void
    {
        $menu_instance->add_menu_item('refund-settings-menu-items', [
            'route' => '#',
            'label' => __('Refund Manage'),
            'parent' => null,
            'permissions' => ['refund-chat-list','refund-chat-create','refund-chat-edit','refund-chat-delete'],
            'icon' => 'mdi mdi-folder-outline',
        ]);

        $menu_instance->add_menu_item('refund-settings-all', [
            'route' => 'tenant.admin.refund.all',
            'label' => __('All Refunds'),
            'parent' => 'refund-settings-menu-items',
            'permissions' => ['refund-list'],
        ]);

        $menu_instance->add_menu_item('refund-settings-message-all', [
            'route' => 'tenant.admin.refund.chat.all',
            'label' => __('Refund Chats'),
            'parent' => 'refund-settings-menu-items',
            'permissions' => ['refund-chat-list'],
        ]);
    }

    private function tenant_form_builder_settings_menus(MenuWithPermission $menu_instance): void
    {
        $menu_instance->add_menu_item('form-builder-settings-menu-items', [
            'route' => '#',
            'label' => __('Form Builder'),
            'parent' => null,
            'permissions' => ['form-builder'],
            'icon' => 'mdi mdi-folder-outline',
        ]);

        $menu_instance->add_menu_item('form-builder-settings-all', [
            'route' => 'tenant.admin.form.builder.all',
            'label' => __('Custom From Builder'),
            'parent' => 'form-builder-settings-menu-items',
            'permissions' => ['form-builder'],
        ]);

        $menu_instance->add_menu_item('form-builder-settings-contact-message', [
            'route' => 'tenant.admin.contact.message.all',
            'label' => __('All Form Submission'),
            'parent' => 'form-builder-settings-menu-items',
            'permissions' => ['form-builder'],
        ]);
    }

    private function tenant_mobile_app_settings_menus(MenuWithPermission $menu_instance): void
    {
        $menu_instance->add_menu_item('mobile-app-settings-menu-items', [
            'route' => '#',
            'label' => __('Mobile App Settings'),
            'parent' => null,
            'permissions' => ['index'],
            'icon' => 'mdi mdi-cellphone-iphone',
        ]);

        $menu_instance->add_menu_item('slider-settings-all', [
            'route' => 'tenant.admin.mobile.slider.all',
            'label' => __('Slider Create'),
            'parent' => 'mobile-app-settings-menu-items',
            'permissions' => null,
        ]);

        $menu_instance->add_menu_item('mobile-intro-all', [
            'route' => 'tenant.admin.mobile.intro.all',
            'label' => __('Mobile Intro'),
            'parent' => 'mobile-app-settings-menu-items',
            'permissions' => null,
        ]);

        $menu_instance->add_menu_item('featured-product-all', [
            'route' => 'tenant.admin.featured.product.all',
            'label' => __('Featured Product'),
            'parent' => 'mobile-app-settings-menu-items',
            'permissions' => null,
        ]);

        $menu_instance->add_menu_item('mobile-campaign-all', [
            'route' => 'tenant.admin.mobile.campaign.create',
            'label' => __('Mobile Campaign'),
            'parent' => 'mobile-app-settings-menu-items',
            'permissions' => null,
        ]);

        $menu_instance->add_menu_item('mobile-tac-settings', [
            'route' => 'tenant.admin.mobile.settings.terms_and_condition',
            'label' => __('Mobile Terms Condition'),
            'parent' => 'mobile-app-settings-menu-items',
            'permissions' => null,
        ]);

        $menu_instance->add_menu_item('mobile-pap-settings', [
            'route' => 'tenant.admin.mobile.settings.privacy.policy',
            'label' => __('Mobile Privacy Policy'),
            'parent' => 'mobile-app-settings-menu-items',
            'permissions' => null,
        ]);
    }

    private function tenant_appearance_settings_menus(MenuWithPermission $menu_instance): void
    {
        $menu_instance->add_menu_item('appearance-settings-menu-items', [
            'route' => '#',
            'label' => __('Appearance Settings'),
            'parent' => null,
            'permissions' => ['menu-manage', 'topbar-manage', 'widget-builder', 'other-settings', 'section-title-manage'],
            'icon' => 'mdi mdi-folder-outline',
        ]);

        $menu_instance->add_menu_item('theme-settings-all', [
            'route' => 'tenant.admin.theme.all',
            'label' => __('Theme Manage'),
            'parent' => 'appearance-settings-menu-items',
            'permissions' => null,
        ]);

        $menu_instance->add_menu_item('section-title-settings-all', [
            'route' => 'tenant.admin.section.manage',
            'label' => __('Section Title Manage'),
            'parent' => 'appearance-settings-menu-items',
            'permissions' => ['section-title-manage'],
        ]);

        $menu_instance->add_menu_item('breadcrumb-settings-all', [
            'route' => 'tenant.admin.breadcrumb.manage',
            'label' => __('Breadcrumb Settings'),
            'parent' => 'appearance-settings-menu-items',
            'permissions' => ['breadcrumb-settings'],
        ]);

        $menu_instance->add_menu_item('topbar-settings-all', [
            'route' => 'tenant.admin.topbar.settings',
            'label' => __('Topbar Settings'),
            'parent' => 'appearance-settings-menu-items',
            'permissions' => ['topbar-manage'],
        ]);

        $menu_instance->add_menu_item('menu-settings-all', [
            'route' => 'tenant.admin.menu',
            'label' => __('Menu Manage'),
            'parent' => 'appearance-settings-menu-items',
            'permissions' => ['menu-manage'],
        ]);

        $menu_instance->add_menu_item('widget-builder-settings-all', [
            'route' => 'tenant.admin.widgets',
            'label' => __('Widget Builder'),
            'parent' => 'appearance-settings-menu-items',
            'permissions' => ['widget-builder'],
        ]);

        $menu_instance->add_menu_item('404-settings-all', [
            'route' => 'tenant.admin.404.page.settings',
            'label' => __('404 Settings'),
            'parent' => 'appearance-settings-menu-items',
            'permissions' => [],
        ]);

        $menu_instance->add_menu_item('maintenance-settings-all', [
            'route' => 'tenant.admin.maintains.page.settings',
            'label' => __('Maintenance Settings'),
            'parent' => 'appearance-settings-menu-items',
            'permissions' => [],
        ]);
    }

    private function tenant_general_settings_menus(MenuWithPermission $menu_instance): void
    {
        $menu_instance->add_menu_item('general-settings-menu-items', [
            'route' => '#',
            'label' => __('General Settings'),
            'parent' => null,
            'permissions' => ['general-settings-page-settings', 'general-settings-site-identity', 'general-settings-basic-settings', 'general-settings-color-settings',
                'general-settings-typography-settings', 'general-settings-seo-settings', 'general-settings-payment-settings', 'general-settings-third-party-script-settings',
                'general-settings-smtp-settings', 'general-settings-custom-css-settings', 'general-settings-custom-js-settings', 'general-settings-database-upgrade-settings',
                'general-settings-cache-clear-settings', 'general-settings-license-settings'],
            'icon' => 'mdi mdi-settings',
        ]);
        $menu_instance->add_menu_item('general-settings-reading-settings', [
            'route' => 'tenant.admin.general.page.settings',
            'label' => __('Page Settings'),
            'parent' => 'general-settings-menu-items',
            'permissions' => ['general-settings-page-settings'],
        ]);
        $menu_instance->add_menu_item('general-settings-global-footer-settings', [
            'route' => 'tenant.admin.general.global.footer.settings',
            'label' => __('Global Footer Settings'),
            'parent' => 'general-settings-menu-items',
            'permissions' => [],
        ]);

        $menu_instance->add_menu_item('general-settings-site-identity', [
            'route' => 'tenant.admin.general.site.identity',
            'label' => __('Site Identity'),
            'parent' => 'general-settings-menu-items',
            'permissions' => ['general-settings-site-identity'],
        ]);
        $menu_instance->add_menu_item('general-settings-basic-settings', [
            'route' => 'tenant.admin.general.basic.settings',
            'label' => __('Basic Settings'),
            'parent' => 'general-settings-menu-items',
            'permissions' => ['general-settings-basic-settings'],
        ]);
        $menu_instance->add_menu_item('general-settings-color-settings', [
            'route' => 'tenant.admin.general.color.settings',
            'label' => __('Color Settings'),
            'parent' => 'general-settings-menu-items',
            'permissions' => ['general-settings-color-settings'],
        ]);
        $menu_instance->add_menu_item('general-settings-typography-settings', [
            'route' => 'tenant.admin.general.typography.settings',
            'label' => __('Typography Settings'),
            'parent' => 'general-settings-menu-items',
            'permissions' => ['general-settings-typography-settings'],
        ]);
        $menu_instance->add_menu_item('general-settings-seo-settings', [
            'route' => 'tenant.admin.general.seo.settings',
            'label' => __('SEO Settings'),
            'parent' => 'general-settings-menu-items',
            'permissions' => ['general-settings-seo-settings'],
        ]);
        $menu_instance->add_menu_item('general-settings-payment-gateway-settings', [
            'route' => 'tenant.admin.general.payment.settings',
            'label' => __('Currency Settings'),
            'parent' => 'general-settings-menu-items',
            'permissions' => ['general-settings-payment-settings'],
        ]);
        $menu_instance->add_menu_item('general-settings-third-party-script-settings', [
            'route' => 'tenant.admin.general.third.party.script.settings',
            'label' => __('Third Party Script'),
            'parent' => 'general-settings-menu-items',
            'permissions' => ['general-settings-third-party-script-settings'],
        ]);
        $menu_instance->add_menu_item('general-settings-email-settings', [
            'route' => 'tenant.admin.general.email.settings',
            'label' => __('Email Settings'),
            'parent' => 'general-settings-menu-items',
            'permissions' => ['general-settings-smtp-settings'],
        ]);
        $menu_instance->add_menu_item('general-settings-gdpr-settings', [
            'route' => 'tenant.admin.general.gdpr.settings',
            'label' => __('GDPR Settings'),
            'parent' => 'general-settings-menu-items',
            'permissions' => ['general-settings-gdpr-settings'],
        ]);
        $menu_instance->add_menu_item('general-settings-custom-css-settings', [
            'route' => 'tenant.admin.general.custom.css.settings',
            'label' => __('Custom CSS'),
            'parent' => 'general-settings-menu-items',
            'permissions' => ['general-settings-custom-css-settings'],
        ]);
        $menu_instance->add_menu_item('general-settings-custom-js-settings', [
            'route' => 'tenant.admin.general.custom.js.settings',
            'label' => __('Custom JS'),
            'parent' => 'general-settings-menu-items',
            'permissions' => ['general-settings-custom-js-settings'],
        ]);

        $menu_instance->add_menu_item('general-settings-cache-settings', [
            'route' => 'tenant.admin.general.cache.settings',
            'label' => __('Cache Settings'),
            'parent' => 'general-settings-menu-items',
            'permissions' => ['general-settings-cache-clear-settings'],
        ]);
    }

    private function tenant_users_manage_menus(MenuWithPermission $menu_instance): void
    {
        $menu_instance->add_menu_item('users-manage-settings-menu-items', [
            'route' => '#',
            'label' => __('Users Manage'),
            'parent' => null,
            'permissions' => [],
            'icon' => 'mdi mdi-account-multiple',
        ]);
        $menu_instance->add_menu_item('users-manage-settings-list-menu-items', [
            'route' => 'tenant.admin.user',
            'label' => __('All Users'),
            'parent' => 'users-manage-settings-menu-items',
            'permissions' => [],
        ]);
        $menu_instance->add_menu_item('users-manage-settings-add-new-menu-items', [
            'route' => 'tenant.admin.user.new',
            'label' => __('Add New'),
            'parent' => 'users-manage-settings-menu-items',
            'permissions' => [],
        ]);
    }

    private function tenant_payment_manage_menus(MenuWithPermission $menu_instance): void
    {
        $menu_instance->add_menu_item('tenant-payment-manage-settings-menu-items', [
            'route' => '#',
            'label' => __('My Package Orders'),
            'parent' => null,
            'permissions' => [],
            'icon' => 'mdi mdi-account-multiple',
        ]);
        $menu_instance->add_menu_item('my-payment-manage-my-logs-settings-menu-items', [
            'route' => 'tenant.my.package.order.payment.logs',
            'label' => __('My Payment Logs'),
            'parent' => 'tenant-payment-manage-settings-menu-items',
            'permissions' => [],
        ]);
    }

    private function tenant_payment_settings_menus(MenuWithPermission $menu_instance): void
    {
        $menu_instance->add_menu_item('payment-settings-menu-items', [
            'route' => '#',
            'label' => __('Payment Settings'),
            'parent' => null,
            'permissions' => ['paypal-payment-settings'],
            'icon' => 'mdi mdi-coin',
        ]);
        $menu_instance->add_menu_item('paypal-settings-page-settings', [
            'route' => 'tenant.admin.payment.settings.paypal',
            'label' => __('Paypal'),
            'parent' => 'payment-settings-menu-items',
            'permissions' => ['paypal-payment-settings'],
        ]);
        $menu_instance->add_menu_item('paytm-settings-page-settings', [
            'route' => 'tenant.admin.payment.settings.paytm',
            'label' => __('Paytm'),
            'parent' => 'payment-settings-menu-items',
            'permissions' => ['paytm-payment-settings'],
        ]);
        $menu_instance->add_menu_item('stripe-settings-page-settings', [
            'route' => 'tenant.admin.payment.settings.stripe',
            'label' => __('Stripe'),
            'parent' => 'payment-settings-menu-items',
            'permissions' => ['stripe-payment-settings'],
        ]);
        $menu_instance->add_menu_item('razorpay-settings-page-settings', [
            'route' => 'tenant.admin.payment.settings.razorpay',
            'label' => __('Razorpay'),
            'parent' => 'payment-settings-menu-items',
            'permissions' => ['razorpay-payment-settings'],
        ]);
        $menu_instance->add_menu_item('paystack-settings-page-settings', [
            'route' => 'tenant.admin.payment.settings.paystack',
            'label' => __('Paystack'),
            'parent' => 'payment-settings-menu-items',
            'permissions' => ['paystack-payment-settings'],
        ]);
        $menu_instance->add_menu_item('mollie-settings-page-settings', [
            'route' => 'tenant.admin.payment.settings.mollie',
            'label' => __('Mollie'),
            'parent' => 'payment-settings-menu-items',
            'permissions' => ['mollie-payment-settings'],
        ]);
        $menu_instance->add_menu_item('midtrans-settings-page-settings', [
            'route' => 'tenant.admin.payment.settings.midtrans',
            'label' => __('Midtrans'),
            'parent' => 'payment-settings-menu-items',
            'permissions' => ['midtrans-payment-settings'],
        ]);
        $menu_instance->add_menu_item('cashfree-settings-page-settings', [
            'route' => 'tenant.admin.payment.settings.cashfree',
            'label' => __('Cashfree'),
            'parent' => 'payment-settings-menu-items',
            'permissions' => ['cashfree-payment-settings'],
        ]);
        $menu_instance->add_menu_item('instamojo-settings-page-settings', [
            'route' => 'tenant.admin.payment.settings.instamojo',
            'label' => __('Instamojo'),
            'parent' => 'payment-settings-menu-items',
            'permissions' => ['instamojo-payment-settings'],
        ]);
        $menu_instance->add_menu_item('marcadopago-settings-page-settings', [
            'route' => 'tenant.admin.payment.settings.marcadopago',
            'label' => __('Marcadopago'),
            'parent' => 'payment-settings-menu-items',
            'permissions' => ['marcadopago-payment-settings'],
        ]);
        $menu_instance->add_menu_item('zitopay-settings-page-settings', [
            'route' => 'tenant.admin.payment.settings.zitopay',
            'label' => __('Zitopay'),
            'parent' => 'payment-settings-menu-items',
            'permissions' => ['zitopay-payment-settings'],
        ]);
        $menu_instance->add_menu_item('squareup-settings-page-settings', [
            'route' => 'tenant.admin.payment.settings.squareup',
            'label' => __('Squareup'),
            'parent' => 'payment-settings-menu-items',
            'permissions' => ['squareup-payment-settings'],
        ]);
        $menu_instance->add_menu_item('cinetpay-settings-page-settings', [
            'route' => 'tenant.admin.payment.settings.cinetpay',
            'label' => __('Cinetpay'),
            'parent' => 'payment-settings-menu-items',
            'permissions' => ['cinetpay-payment-settings'],
        ]);
        $menu_instance->add_menu_item('paytabs-settings-page-settings', [
            'route' => 'tenant.admin.payment.settings.paytabs',
            'label' => __('Paytabs'),
            'parent' => 'payment-settings-menu-items',
            'permissions' => ['paytabs-payment-settings'],
        ]);
        $menu_instance->add_menu_item('billplz-settings-page-settings', [
            'route' => 'tenant.admin.payment.settings.billplz',
            'label' => __('Billplz'),
            'parent' => 'payment-settings-menu-items',
            'permissions' => ['billplz-payment-settings'],
        ]);
        $menu_instance->add_menu_item('toyyibpay-settings-page-settings', [
            'route' => 'tenant.admin.payment.settings.toyyibpay',
            'label' => __('Toyyibpay'),
            'parent' => 'payment-settings-menu-items',
            'permissions' => ['toyyibpay-payment-settings'],
        ]);
        $menu_instance->add_menu_item('flutterwave-settings-page-settings', [
            'route' => 'tenant.admin.payment.settings.flutterwave',
            'label' => __('Flutterwave'),
            'parent' => 'payment-settings-menu-items',
            'permissions' => ['flutterwave-payment-settings'],
        ]);
        $menu_instance->add_menu_item('payfast-settings-page-settings', [
            'route' => 'tenant.admin.payment.settings.payfast',
            'label' => __('Payfast'),
            'parent' => 'payment-settings-menu-items',
            'permissions' => ['payfast-payment-settings'],
        ]);
        $menu_instance->add_menu_item('manual_payment-settings-page-settings', [
            'route' => 'tenant.admin.payment.settings.manual_payment',
            'label' => __('Manual Payment'),
            'parent' => 'payment-settings-menu-items',
            'permissions' => ['manual_payment-payment-settings'],
        ]);
        $menu_instance->add_menu_item('cod-settings-page-settings', [
            'route' => 'tenant.admin.payment.settings.cod',
            'label' => __('Cash On Delivery'),
            'parent' => 'payment-settings-menu-items',
            'permissions' => ['cod-payment-settings'],
        ]);

        // External Menu Render
        foreach (getAllExternalPaymentGatewayMenu() as $externalMenu)
        {
            foreach ($externalMenu as $individual_menu_item){
                $convert_to_array = (array) $individual_menu_item;
                $convert_to_array['parent'] = 'payment-settings-menu-items';

                $routeName = $convert_to_array['tenantRoute'];
                if (isset($routeName) && !empty($routeName) && Route::has($routeName)){
                    $menu_instance->add_menu_item($convert_to_array['id'], $convert_to_array);
                }
            }
        }
    }

    private function tenant_custom_domain_request_settings_menus(MenuWithPermission $menu_instance): void
    {
        $menu_instance->add_menu_item('custom-domain-request', [
            'route' => 'tenant.admin.custom.domain.requests',
            'label' => __('Custom Domain'),
            'parent' => null,
            'permissions' => [],
            'icon' => 'mdi mdi-format-quote-close',
        ]);
    }

    private function tenant_admin_manage_menus(MenuWithPermission $menu_instance): void
    {
        $menu_instance->add_menu_item('admin-manage-settings-menu-items', [
            'route' => '#',
            'label' => __('Admin Role Manage'),
            'parent' => null,
            'permissions' => [],
            'icon' => 'mdi mdi-account-multiple',
        ]);
        $menu_instance->add_menu_item('admins-manage-settings-list-menu-items', [
            'route' => 'tenant.admin.all.user',
            'label' => __('All Admin'),
            'parent' => 'admin-manage-settings-menu-items',
            'permissions' => [],
        ]);
        $menu_instance->add_menu_item('admins-manage-settings-add-new-menu-items', [
            'route' => 'tenant.admin.new.user',
            'label' => __('Add New Admin'),
            'parent' => 'admin-manage-settings-menu-items',
            'permissions' => [],
        ]);
        $menu_instance->add_menu_item('admins-role-manage-settings-add-new-menu-items', [
            'route' => 'tenant.admin.all.admin.role',
            'label' => __('All Admin Role'),
            'parent' => 'admin-manage-settings-menu-items',
            'permissions' => [],
        ]);
    }
}
