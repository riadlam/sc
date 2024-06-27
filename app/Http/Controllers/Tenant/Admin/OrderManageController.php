<?php

namespace App\Http\Controllers\Tenant\Admin;

use App\Enums\ProductTypeEnum;
use App\Http\Controllers\Controller;
use App\Models\FormBuilder;
use App\Models\Language;
use App\Mail\BasicMail;
use App\Mail\OrderReply;
use App\Mail\PlaceOrder;
use App\Models\Order;
use App\Models\OrderProducts;
use App\Models\PaymentLogs;
use App\Models\PricePlan;
use App\Models\ProductOrder;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use LaravelDaily\Invoices\Classes\InvoiceItem;
use LaravelDaily\Invoices\Classes\Party;
use LaravelDaily\Invoices\Invoice;
use Modules\DigitalProduct\Entities\DigitalProductDownload;
use Modules\Product\Entities\ProductInventory;
use Modules\Product\Entities\ProductInventoryDetail;

class OrderManageController extends Controller
{
    private const ROOT_PATH = 'tenant.admin.product-order-manage.';

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function all_orders(Request $request)
    {
        $typeArr = ['pending', 'in_progress', 'cancel', 'complete'];
        if (isset($request->filter) && in_array($request->filter, $typeArr)) {
            $all_orders = ProductOrder::where('status', $request->filter)->orderBy('id', 'desc')->get();
            return view(self::ROOT_PATH . 'order-manage-all')->with(['all_orders' => $all_orders]);
        }

        $all_orders = ProductOrder::orderBy('id', 'desc')->get();
        return view(self::ROOT_PATH . 'order-manage-all')->with(['all_orders' => $all_orders]);
    }

    public function view_order($id)
    {
        if (!empty($id)) {
            $order = ProductOrder::find($id);
        }

        return view(self::ROOT_PATH . 'order-view', compact('order'));
    }

    public function pending_orders()
    {
        $all_orders = PaymentLogs::where('status', 'pending')->get();
        return view(self::ROOT_PATH . 'order-manage-pending')->with(['all_orders' => $all_orders]);
    }

    public function completed_orders()
    {
        $all_orders = PaymentLogs::where('status', 'complete')->get();
        return view(self::ROOT_PATH . 'order-manage-completed')->with(['all_orders' => $all_orders]);
    }

    public function in_progress_orders()
    {
        $all_orders = PaymentLogs::where('status', 'in_progress')->get();
        return view(self::ROOT_PATH . 'order-manage-in-progress')->with(['all_orders' => $all_orders]);
    }

    public function change_status(Request $request)
    {
        $this->validate($request, [
            'order_status' => 'required|string|max:191',
            'payment_status' => 'nullable',
            'order_id' => 'required|string|max:191'
        ]);

        $order_details = ProductOrder::find($request->order_id);

        if ($order_details->payment_status === 'success' && isset($request->payment_status)) {
            return redirect()->back()->withErrors(['msg' => __('You can not change this payment status')]);
        }

        $order_details->status = $request->order_status;
        if (isset($request->payment_status)) {
            $order_details->payment_status = $request->payment_status;
        }
        $order_details->save();

        if ($order_details->status === 'cancel') {
            $this->undostock($order_details);
        }

        foreach (json_decode($order_details->order_details) as $item)
        {
            if ($item->options->type == ProductTypeEnum::DIGITAL)
            {
                $product_download = DigitalProductDownload::where('product_id', $item->id)->first();
                if (!empty($product_download))
                {
                    $product_download->increment('download_count', 1);
                } else {
                    DigitalProductDownload::create([
                        'product_id' => $item->id,
                        'user_id' => $order_details->user_id ?? null,
                        'download_count' => 1
                    ]);
                }
            }
        }

        $data['subject'] = __('Your order status has been changed');
        $data['message'] = __('Hello') . ' ' . $order_details->name . '<br>';
        $data['message'] .= __('Your order') . ' #' . $order_details->id . ' ';
        $data['message'] .= __('status has been changed to') . ' ' . str_replace('_', ' ', $request->order_status) . '.';

        //send mail while order status change
        try {
            Mail::to($order_details->email)->send(new BasicMail($data['message'], $data['subject']));

        } catch (\Exception $e) {

            return redirect()->back()->with(['type' => 'danger', 'msg' => $e->getMessage()]);
        }


        return redirect()->back()->with(['msg' => __('Payment Logs Status Update Success...'), 'type' => 'success']);
    }

    private function undostock($order)
    {
        $ordered_products = OrderProducts::where('order_id', $order->id)->get();
        foreach ($ordered_products ?? [] as $product) {
            if ($product->variant_id !== null) {
                $variants = ProductInventoryDetail::where(['product_id' => $product->product_id, 'id' => $product->variant_id])->get();
                if (!empty($variants)) {
                    foreach ($variants ?? [] as $variant) {
                        $variant->increment('stock_count', $product->quantity);
                        $variant->decrement('sold_count', $product->quantity);
                    }
                }
            }

            $product_inventory = ProductInventory::where('product_id', $product->product_id ?? 0)->first();
            $product_inventory->increment('stock_count', $product->quantity ?? 0);
            $product_inventory->sold_count = $product_inventory->sold_count == null ? 1 : $product_inventory->sold_count - $product->quantity;
            $product_inventory->save();
        }
    }

    public function order_reminder(Request $request)
    {
        $order_details = ProductOrder::find($request->id);

        //send order reminder mail
        $data['subject'] = __('your order is still in pending at') . ' ' . get_static_option('site_title');
        $data['message'] = __('hello') . ' ' . $order_details->name . '<br>';
        $data['message'] .= __('your order') . ' #' . $order_details->id . ' ';
        $data['message'] .= __('is still in pending, to complete your order go to');
        $data['message'] .= ' <a href="' . route('tenant.user.home') . '">' . __('your dashboard') . '</a>';
        //send mail while order status change

        try {
            Mail::to($order_details->email)->send(new BasicMail($data['message'], $data['subject']));
        } catch (\Exception $e) {
            return redirect()->back()->with(['type' => 'danger', 'msg' => $e->getMessage()]);
        }

        return redirect()->back()->with(['msg' => __('PaymentLogs Reminder Mail Send Success...'), 'type' => 'success']);
    }

    public function send_mail(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|string|max:191',
            'name' => 'required|string|max:191',
            'subject' => 'required|string',
            'message' => 'required|string',
        ]);
        $subject = str_replace('{site}', get_static_option('site_title'), $request->subject);
        $data = [
            'name' => $request->name,
            'message' => $request->message,
        ];
        try {
            Mail::to($request->email)->send(new OrderReply($data, $subject));
        } catch (\Exception $e) {
            return redirect()->back()->with(['type' => 'danger', 'msg' => $e->getMessage()]);
        }
        return redirect()->back()->with(['msg' => __('Order Reply Mail Send Success...'), 'type' => 'success']);
    }


    public function all_payment_logs()
    {
        $paymeng_logs = PaymentLogs::all();
        return view('tenant.admin.payment-logs.payment-logs-all')->with(['payment_logs' => $paymeng_logs]);
    }

    public function payment_logs_delete(Request $request, $id)
    {
        PaymentLogs::find($id)->delete();
        return redirect()->back()->with(['msg' => __('Payment Log Delete Success...'), 'type' => 'danger']);
    }

    public function payment_logs_approve(Request $request, $id)
    {
        $payment_logs = PaymentLogs::find($id);
        $payment_logs->status = 'complete';
        $payment_logs->save();

        PaymentLogs::where('id', $payment_logs->order_id)->update(['payment_status' => 'complete']);

        $order_details = PaymentLogs::find($payment_logs->order_id);
        $package_details = PricePlan::where('id', $order_details->package_id)->first();
        $payment_details = PaymentLogs::where('order_id', $payment_logs->order_id)->first();
        $all_fields = unserialize($order_details->custom_fields);
        unset($all_fields['package']);

        $all_attachment = unserialize($order_details->attachment);
        $order_page_form_mail = get_static_option('order_page_form_mail');
        $order_mail = $order_page_form_mail ? $order_page_form_mail : get_static_option('site_global_email');

        $subject = __('your order has been placed');
        $message = __('your order has been placed.') . ' #' . $payment_logs->order_id;
        $message .= ' ' . __('at') . ' ' . date_format($order_details->created_at, 'd F Y H:m:s');
        $message .= ' ' . __('via') . ' ' . str_replace('_', ' ', $payment_details->package_gateway);
        Mail::to($payment_details->email)->send(new PlacePaymentLogs([
            'data' => $order_details,
            'subject' => $subject,
            'message' => $message,
            'package' => $package_details,
            'attachment_list' => $all_attachment,
            'payment_log' => $payment_details
        ]));

        return redirect()->back()->with(['msg' => __('Manual Payment Accept Success'), 'type' => 'success']);
    }

    public function order_success_payment()
    {
        return view(self::ROOT_PATH . 'order-success-page');
    }

    public function update_order_success_payment(Request $request)
    {
        $this->validate($request, [
            'site_order_success_page_title' => 'nullable',
            'site_order_success_page_description' => 'nullable',
        ]);
        $title = 'site_order_success_page_title';
        $description = 'site_order_success_page_description';

        update_static_option($title, $request->$title);
        update_static_option($description, $request->$description);
        return redirect()->back()->with(['msg' => __('PaymentLogs Success Page Update Success...'), 'type' => 'success']);
    }

    public function order_cancel_payment()
    {
        $all_languages = Language::all();
        return view(self::ROOT_PATH . 'order-cancel-page')->with(['all_languages' => $all_languages]);
    }

    public function update_order_cancel_payment(Request $request)
    {
        $this->validate($request, [
            'site_order_cancel_page_title' => 'nullable',
            'site_order_cancel_page_subtitle' => 'nullable',
            'site_order_cancel_page_description' => 'nullable',
        ]);
        $title = 'site_order_cancel_page_title';
        $subtitle = 'site_order_cancel_page_subtitle';
        $description = 'site_order_cancel_page_description';

        update_static_option($title, $request->$title);
        update_static_option($subtitle, $request->$subtitle);
        update_static_option($description, $request->$description);

        return redirect()->back()->with(['msg' => __('PaymentLogs Cancel Page Update Success...'), 'type' => 'success']);
    }

    public function bulk_action(Request $request)
    {
        $all = PaymentLogs::find($request->ids);
        foreach ($all as $item) {
            $item->delete();
        }
        return response()->json(['status' => 'ok']);
    }

    public function payment_log_bulk_action(Request $request)
    {
        $all = PaymentLogs::find($request->ids);
        foreach ($all as $item) {
            $item->delete();
        }
        return response()->json(['status' => 'ok']);
    }

    public function order_report(Request $request)
    {
        $order_data = '';
        $query = PaymentLogs::query();
        if (!empty($request->start_date)) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if (!empty($request->end_date)) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }
        if (!empty($request->order_status)) {
            $query->where(['status' => $request->order_status]);
        }
        if (!empty($request->payment_status)) {
            $query->where(['payment_status' => $request->payment_status]);
        }
        $error_msg = __('select start & end date to generate order report');
        if (!empty($request->start_date) && !empty($request->end_date)) {
            $query->orderBy('id', 'DESC');
            $order_data = $query->paginate($request->items);
            $error_msg = '';
        }

        return view(self::ROOT_PATH . 'order-report')->with([
            'order_data' => $order_data,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'items' => $request->items,
            'order_status' => $request->order_status,
            'payment_status' => $request->payment_status,
            'error_msg' => $error_msg
        ]);
    }

    public function payment_report(Request $request)
    {

        $order_data = '';
        $query = PaymentLogs::query();
        if (!empty($request->start_date)) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if (!empty($request->end_date)) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }
        if (!empty($request->payment_status)) {
            $query->where(['status' => $request->payment_status]);
        }
        $error_msg = __('select start & end date to generate payment report');
        if (!empty($request->start_date) && !empty($request->end_date)) {
            $query->orderBy('id', 'DESC');
            $order_data = $query->paginate($request->items);
            $error_msg = '';
        }

        return view('tenant.admin.payment-logs.payment-report')->with([
            'order_data' => $order_data,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'items' => $request->items,
            'payment_status' => $request->payment_status,
            'error_msg' => $error_msg
        ]);
    }

    public function index()
    {
        $all_custom_form = FormBuilder::all();
        return view(self::ROOT_PATH . 'form-section')->with(['all_custom_form' => $all_custom_form]);
    }

    public function udpate(Request $request)
    {
        $this->validate($request, [
            'order_form' => 'nullable|string',
        ]);

        $this->validate($request, [
            'order_page_form_title' => 'nullable|string',
        ]);
        $field = 'order_page_form_title';
        update_static_option('order_page_form_title', $request->$field);

        update_static_option('order_form', $request->order_form);

        return redirect()->back()->with(['msg' => __('Settings Updated....'), 'type' => 'success']);
    }

    public function generate_order_invoice(Request $request)
    {
        $payment_details = ProductOrder::find($request->id);
        if (empty($payment_details)) {
            return abort(404);
        }

        $client = new Party([
            'name' => site_title(),
            'custom_fields' => [
                'email' => get_static_option('order_receiving_email'),
                'website' => str_replace(['http://', 'https://'], '', url('/'))
            ]
        ]);

        $customer = new Party([
            'name' => $payment_details->name,
            'phone' => $payment_details->phone,
            'custom_fields' => [
                'email' => $payment_details->email,
                'country' => $payment_details->getCountry?->name,
                'state' => $payment_details->getState?->name,
                'city' => $payment_details->city,
                'address' => $payment_details->address,
            ]
        ]);

        $currency_symbol = site_currency_symbol();
        $currency = site_currency_symbol();
        $currency_symbol_position = get_static_option('site_currency_symbol_position');

        $payment_status = $payment_details->payment_status == 'success' ? __('Paid') : __('Unpaid');
        if ($payment_details->status == 'cancel') {
            $payment_status = __('Cancel');
        }

        $invoice_number_padding = get_static_option('invoice_number_padding') ?? 2;
        $thousand_separator = get_static_option('site_custom_currency_thousand_separator') ?? ',';
        $decimal_separator = get_static_option('site_custom_currency_decimal_separator') ?? '.';

        $site_logo = get_attachment_image_by_id(get_static_option('site_logo'))['img_url'] ?? '';

        $taxPosition = get_static_option('invoice_tax_position') ?? 'total';
        $taxInfo = json_decode($payment_details->payment_meta);
        $tax_rate = array_key_exists('product_tax', (array)$taxInfo) ? $taxInfo->product_tax : 0;
        $shipping_cost = array_key_exists('shipping_cost', (array)$taxInfo) ? $taxInfo->shipping_cost : 0;

        $items = [];
        foreach (json_decode($payment_details->order_details) as $order_details) {
            $title = $order_details->name;
            $description = '';
            if (array_key_exists('color_name', (array)$order_details->options)) {
                $description .= __('Color:') . ' ' . ($order_details?->options?->color_name ?? '') . PHP_EOL;
            }

            if (array_key_exists('size_name', (array)$order_details->options)) {
                $description .= __('Size:') . ' ' . ($order_details?->options?->size_name ?? '');
            }

            $pricePerUnit = $order_details->price;
            $quantity = $order_details->qty;

            $InvoiceItem = (new InvoiceItem())
                ->title($title)
                ->description($description)
                ->pricePerUnit($pricePerUnit)
                ->quantity($quantity);
            if ($taxPosition == 'each') {
                $InvoiceItem->taxByPercent($tax_rate);
            }

            $items[] = $InvoiceItem;
        }

        $invoiceInstance = Invoice::make(site_title() . ' - Order Invoice')
            // ability to include translated invoice status
            // in case it was paid
            ->status($payment_status)
            ->sequence($payment_details->id)
            ->sequencePadding($invoice_number_padding)
            ->serialNumberFormat('{SEQUENCE}')
            ->seller($client)
            ->buyer($customer)
            ->date(now()->subWeeks(3))
            ->dateFormat('m/d/Y')
            ->currencySymbol($currency_symbol)
            ->currencyCode($currency)
            ->currencyFormat($currency_symbol_position == 'left' ? '{SYMBOL}{VALUE}' : '{VALUE}{SYMBOL}')
            ->currencyThousandsSeparator($thousand_separator)
            ->currencyDecimalPoint($decimal_separator)
            ->addItems($items)
            ->shipping($shipping_cost)
            ->logo($site_logo);
        // You can additionally save generated invoice to configured disk

        if ($taxPosition == 'total') {
            $invoiceInstance->totalTaxes($tax_rate, true);
        }

        $invoice = $invoiceInstance->save();


        return $invoice->stream();


        dd($payment_details, $customer);
//
////        return view('tenant.frontend.invoice.order', ['payment_details' => $payment_details]);
//        $pdf = PDF::loadview('tenant.frontend.invoice.order', ['payment_details' => $payment_details])->setOptions(['defaultFont' => 'sans-serif']);
//        return $pdf->download('package-invoice.pdf');


    }

    public function order_manage_settings(Request $request)
    {
        if ($request->method() == 'GET') {
            return view(self::ROOT_PATH . 'order-settings');
        } else {
            $this->validate($request, [
                'receiving_email' => 'nullable|email',
            ]);

            update_static_option('order_receiving_email', $request->receiving_email);

            return redirect()->back()->with(['msg' => __('Settings Updated....'), 'type' => 'success']);
        }
    }

    public function order_invoice_settings(Request $request)
    {
        if ($request->method() == 'GET') {
            return view(self::ROOT_PATH . 'invoice-settings');
        } else {
            $this->validate($request, [
                'invoice_number_padding' => 'nullable|integer',
                'invoice_tax_position' => 'required',
            ]);

            update_static_option('invoice_number_padding', $request->invoice_number_padding);
            update_static_option('invoice_tax_position', $request->invoice_tax_position);

            return redirect()->back()->with(['msg' => __('Settings Updated....'), 'type' => 'success']);
        }
    }
}
