<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;
use Stripe\Stripe;
use Carbon\Carbon;
use App\Stripe as StripeModel;
use App\Credit;
use App\TaskClassType;
use App\Configuration;
use App\CreditsCalculation;
use App\Role;

class PaymentsReceivedToday extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payments_received:today';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This Job fetches details of all the payments which were made today by the parents';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $stripeLiveSecretKey = Configuration::where('key', 'stripe_live_secret_key')->value('value');
        date_default_timezone_set('America/Los_Angeles');
        $today = Carbon::today();
        //$today = Carbon::yesterday();
        $todayUT = strtotime($today);
        $now = Carbon::now();
        $nowDateTime =date('Y-m-d H:i:s',strtotime($now));
        \Stripe\Stripe::setApiKey($stripeLiveSecretKey);

        $listOfPayments = \Stripe\PaymentIntent::all(['created[gte]' => $todayUT]);

        foreach($listOfPayments as $paymentIntent){
            if($paymentIntent->charges->data != null && $paymentIntent->charges->data != ""){
                $payment = $paymentIntent->charges->data[0];
                $emailId = $payment->receipt_email;
                $amount = ($payment->amount)/100;
                $paymentId = $payment->payment_method;

                if($payment->invoice != null){
                    $invoice = \Stripe\Invoice::retrieve($payment->invoice);
                    $product_id = $invoice->lines->data[0]->plan->id;
                }else{

                    $product_id = $paymentIntent->metadata->product_id;
                }
            
                if($product_id != null && $product_id != ""){
                    $stripeData = StripeModel::where('product_id',$product_id)->first();
                    $credits = $stripeData->number_of_credits;
                    $taskClassTypeId = $stripeData->task_class_type_id;
                    // $credits = 4;
                    // $taskClassTypeId = 1;

                    $creditObj = new Credit();
                    $creditObj->credits_given = $credits;
                    $creditObj->credits_given_date =$nowDateTime;
                    $creditObj->customer_email = $emailId;
                    $creditObj->payment_id = $paymentId;
                    $creditObj->product_id = $product_id;
                    $creditObj->task_class_type_id = $taskClassTypeId;
                    $creditObj->save();  

                    $roleId = Role::where('role', 'parent')->value('id');
                    $userPhoneNumber = User::where(['role_id' => $roleId,
                                                    'email' => $emailId,])->value('phone_number');

                    $creditsCalculation = CreditsCalculation::where(['phone_number' => $userPhoneNumber,
                                                                     'product_id' => $product_id,
                                                                     'task_class_type_id' => $taskClassTypeId])->first();
                    if($creditsCalculation != null && $creditsCalculation != ""){
                        if($creditsCalculation->customer_email == null || $creditsCalculation->customer_email == ""){
                            $creditsCalculation->customer_email = $emailId;
                            $creditsCalculation->product_id = $product_id;
                        }
                        $previous_credits = $creditsCalculation->credits_given;
                        $new_credits = $previous_credits + $credits;

                        $creditsCalculation->credits_given = $new_credits;
                        $creditsCalculation->save();
                    }else{
                        $creditsCalculation = new CreditsCalculation();
                        $creditsCalculation->credits_given = $credits;
                        $creditsCalculation->customer_email = $emailId;
                        $creditsCalculation->phone_number = $userPhoneNumber;
                        $creditsCalculation->product_id = $product_id;
                        $creditsCalculation->task_class_type_id = $taskClassTypeId;
                        $creditsCalculation->save();
                    }
                }
            }
        }
    }
}
