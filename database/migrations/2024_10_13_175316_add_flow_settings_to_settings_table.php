<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->string('flow_transaction_token')->nullable()->after('nowpayments_order_id');
        });

        Schema::table('subscriptions', function (Blueprint $table) {
            $table->string('flow_subscription_id')->nullable()->after('ccbill_subscription_id')->nullable();
        });

        DB::table('data_rows')->insert([
            'data_type_id' => 13,
            'field' => 'flow_subscription_id',
            'type' => 'text',
            'display_name' => 'FLOW ID',
            'required' => 0,
            'browse' => 1,
            'read' => 1,
            'edit' => 1,
            'add' => 1,
            'delete' => 1,
            'details' => '{}',
            'order' => 11,
        ]);

        DB::update('UPDATE data_rows SET details = ? WHERE id = 248', [
            '{"default":"credit","options":{"stripe":"Stripe","paypal":"Paypal","ccbill":"CCBill","coinbase":"Coinbase","nowpayments":"Nowpayments","paystack":"Paystack","oxxo":"Oxxo","credit":"Credit","flow":"Flow"}}'
        ]);
        DB::update('UPDATE data_rows SET details = ? WHERE id = 92', [
            '{"default":"credit","options":{"stripe":"Stripe","paypal":"Paypal","ccbill":"CCBill","coinbase":"Coinbase","nowpayments":"Nowpayments","paystack":"Paystack","oxxo":"Oxxo","credit":"Credit","flow":"Flow"}}'
        ]);

        DB::table('settings')->insert([
            [
                'key'   => 'payments.flow_api_key',
                'value' => null,
                'group' => 'Payments',
                'display_name' => 'Flow API Key',
                'details' => json_encode([]),
                'type' => 'text',
                'order' => 1,
            ],
            [
                'key'   => 'payments.flow_api_secret',
                'value' => null,
                'group' => 'Payments',
                'display_name' => 'Flow API Secret',
                'details' => json_encode([]),
                'type' => 'text',
                'order' => 2,
            ],
            [
                'key'   => 'payments.flow_checkout_disabled',
                'value' => 0,
                'group' => 'Payments',
                'display_name' => 'Disable for checkout',
                'details' => json_encode([
                    'true' => 'On',
                    'false' => 'Off',
                    'checked' => false,
                    'description' => "Won't be shown on checkout, but it's still available for deposits.",
                ]),
                'type' => 'checkbox',
                'order' => 3,
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            if (Schema::hasColumn('transactions', 'flow_transaction_token')) {
                $table->dropColumn('flow_transaction_token');
            }
        });
    
        if (DB::table('settings')->where('key', 'payments.flow_api_key')->exists()) {
            DB::table('settings')->where('key', 'payments.flow_api_key')->delete();
        }
    
        if (DB::table('settings')->where('key', 'payments.flow_api_secret')->exists()) {
            DB::table('settings')->where('key', 'payments.flow_api_secret')->delete();
        }
    
        if (DB::table('settings')->where('key', 'payments.flow_checkout_disabled')->exists()) {
            DB::table('settings')->where('key', 'payments.flow_checkout_disabled')->delete();
        }
    }
    
};
