<?php

namespace App\Helpers;

use App\Enums\StatusEnums;
use App\Facades\ModuleDataFacade;
use App\Models\PaymentGateway;
use nova\Paymentgateway\Facades\XgPaymentGateway;

class PaymentGatewayRenderHelper
{
    public static function listOfPaymentGateways()
    {
        $plan_based_payment_gateway = tenant_plan_payment_gateway_list();
        $payment_gateway_list = PaymentGateway::where('status', 1);
        if (!empty($plan_based_payment_gateway)) // For tenant
        {
            $payment_gateway_list->whereIn('name', $plan_based_payment_gateway);
        }

        $payment_gateway_list = $payment_gateway_list->select(['name', 'image'])->get();

        $payment_gateway_list = !empty($payment_gateway_list) ? $payment_gateway_list->toArray() : $payment_gateway_list;

        //todo append payment gateway name from modules
        $modules_payment_gateway = getAllPaymentGatewayListWithImage();
        return !empty($modules_payment_gateway) ? array_merge($payment_gateway_list, $modules_payment_gateway) : $payment_gateway_list;
    }

    public static function renderCurrentBalanceForm()
    {
        $output = '<div class="current-balance-wrapper">';
        $output .= '<input type="checkbox" name="selected_payment_gateway" id="current_balance_gateway" class="mr-2 current_balance_selected_gateway">';
        $output .= '<label for="current_balance_gateway">' . __('Deposit From Current Balance') . '</label>';
        $output .= '</div>';
        return $output;
    }

    public static function renderWalletForm()
    {
        $output = '<div class="wallet-payment-gateway-wrapper">';
        $output .= '<input type="checkbox" name="selected_payment_gateway" id="wallet_selected_payment_gateway" class="mr-2 wallet_selected_payment_gateway">';
        $output .= '<label for="wallet_selected_payment_gateway">' . __('Order From Wallet') . '</label>';
        $output .= '</div>';
        return $output;
    }

    public static function renderPaymentGatewayForForm()
    {
        $output = '<div class="payment-gateway-wrapper payment_getway_image">';

        $output .= '<input type="hidden" name="selected_payment_gateway" id="order_from_user_wallet" value="' . get_static_option('site_default_payment_gateway') . '">';

        $all_gateway = self::listOfPaymentGateways();

        $output .= '<ul>';
        foreach ($all_gateway as $gateway) {
            if ($gateway['name'] == 'manual_payment')
            {
                $manual_payment_gateway = PaymentGateway::where(['status' => StatusEnums::PUBLISH, 'name' => $gateway['name']])->first();
                $description = json_decode($manual_payment_gateway->credentials);
                $description = $description->description;
            }

            $class = (get_static_option('site_default_payment_gateway') == $gateway['name']) ? 'class="selected"' : '';
            $output .= '<li data-gateway="' . $gateway['name'] . '" ' . $class . ' data-description="'.(isset($description) ? $description : '').'"><div class="img-select">';

            if (array_key_exists('module', $gateway))
            {
                $output .= '<img src="'.loadPaymentGatewayLogo(moduleName: $gateway['module'], gatewayName: $gateway['name']).'"';
            } else {
                $output .= render_image_markup_by_attachment_id($gateway['image']);
            }
            $output .= '</div></li>';
        }
        $output .= '</ul>';
        $output .= '</div>';
        //extra field data for payment gateway
        $output .= '<div class="payment_gateway_extra_field_information_wrap">';
        if (!empty(get_static_option('manual_payment_gateway'))) {
            $output .= '<div class="manual_payment_gateway_extra_field">
                            <div class="form-group">
                                <div class="label mt-3 mb-2">' . get_static_option('site_manual_payment_name') . __('Receipt') . '</div>
                                    <input type="file" name="manual_payment_image" class="form-control" style="line-height: 1.15">
                                </div>
                            <div class="manual_description">' . get_static_option('site_manual_payment_description') . '</div>
                       </div>';
        }
        //todo write code for all module extra info markup
        $output .= renderAllPaymentGatewayExtraInfoBlade();
        $output .= '</div>';

        return $output;
    }
}
