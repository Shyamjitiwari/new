<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use App\Stripe as stripeModel;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\UserParent;
use App\Configuration;
use App\Role;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\FreezedSubscriptions;
use App\TaskClassFrequency;
use App\Currency;
use Exception;
use App\CancelledSubscription;
use App\Domain\MailFunctions;

class BillingAndPaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:teacher|admin|parent');
    }

    public function plans(){
        $user = Auth::user();
        $emailId = $user->email;
        if($emailId == null || $emailId == ""){
            return view('billing_and_payment.parents_email');
        }
        else{
            $plans = $this->getPlans();
            return view('billing_and_payment.parents_billing', compact('plans'))->withError("");
        }
    }

    public function getPlans(){
        $user = Auth::user();
        $phoneNumber = $user->phone_number;
        $roleId = Role::where('role','student')->value('id');
        $getStudentsOfThisParent = User::where(['phone_number' => $phoneNumber,
                                                'role_id' =>  $roleId ])->get();
        $plans = array();
        $locations = array();
        foreach($getStudentsOfThisParent as $student){
            $locationData= $student->locations()->get();
            foreach($locationData as $location){
                $dataArray = $location->id;
                array_push($locations,$dataArray);       
            }
        }
        $locations = array_unique($locations);
        foreach($locations as $location){
            $plansData = stripeModel::where(['location_id' => $location,
                                             'is_promo' => false])->get();
            foreach($plansData as $plan){
                $url = "/plan/".$plan->product_id."";
                $dataArray = ["id" =>$plan->id,
                            "product_id" => $plan->product_id,
                            "product_name" => $plan->product_name,
                            "url" => $url,
                            ];
                array_push($plans,$dataArray);           
            }
        }
        return $plans;
    }

    public function showPlan($planId, Request $request){

        $user = Auth::user();
        $emailId = $user->email;
        if($emailId == null || $emailId == ""){
            return view('billing_and_payment.parents_email');
        }
        else{
            // $emailId = "rida@codewithus.com";
            $plan = stripeModel::where(['product_id' => $planId])->with('currency')->first();
            $plan_id = $plan->product_id;
            $plan_name = $plan->product_name;
            $plan_desc = $plan->description;
            $plan_price = number_format((float)$plan->price, 2, '.', '');
            $plan_currency = $plan->currency->name;
            return view('billing_and_payment.plan')->withPlanid($plan_id)
                                                    ->withPlanname($plan_name)
                                                    ->withPlandescription($plan_desc)
                                                    ->withPlanprice($plan_price)
                                                    ->withPlancurrency($plan_currency)
                                                    ->withEmailid($emailId);  
        }
    }
    
    public function addEmailId(Request $request){
        $user = Auth::user();
        $user->email = $request->email;
        $user->save();

        return redirect()->back();
    }

    public function makePayment(Request $request){

        $stripeTestSecretKey = Configuration::where('key', 'stripe_live_secret_key')->value('value');
        \Stripe\Stripe::setApiKey($stripeTestSecretKey);

        $user = Auth::user();
        //Check if customer already exists in Stripe
        $userId = $user->id;
        $emailId = $user->email;
        $parent = UserParent::where('user_id',$userId)->first();
        $parentStripeId = "";
        //$stripeCustomerId = "cus_HSsq76eKd72Law";

        if($parent != null){
            $parentStripeId = $parent->stripe_customer_id;
        }    
        if($parent == null || $parentStripeId == null || $parentStripeId == ""){
            // This creates a new Customer and attaches the default PaymentMethod in one API call.
            $stripeCustomer = \Stripe\Customer::create([
                'payment_method' => $request->payment_method,
                'email' => $emailId,
                'invoice_settings' => [
                    'default_payment_method' => $request->payment_method
                ]
            ]);
                
            $stripeCustomerId = $stripeCustomer->id;

            $newParentRecord = new UserParent();
            $newParentRecord->user_id = $userId;
            $newParentRecord->stripe_customer_id = $stripeCustomerId;
            $newParentRecord->save();
        }
        else{
            $stripeCustomerId = $parentStripeId;
        }
        
        $stripePlanId = $request->plan_id;
        $plan = stripeModel::where(['product_id' => $stripePlanId])->with('currency')->first();
        $plan_id = $plan->product_id;
        $plan_name = $plan->product_name;
        $plan_desc = $plan->description;
        $plan_price = $plan->price;
        $plan_currency = $plan->currency->name;

        if($plan->is_subscription == false){
            try {
             $paymentIntent = \Stripe\PaymentIntent::create([
                 'amount' => $plan_price*100,
                 'currency' => $plan_currency,
                 'customer' => $stripeCustomerId,
                 'payment_method' => $request->payment_method,
                 'payment_method_types' => ['card'],     
                 'confirm' => true,   
                 'metadata' =>[
                     'product_id' => $plan_id,
                     'idempotency_key' => $request->idempotent_id
                    ]
                 ],[
                 'idempotency_key' => $request->idempotent_id
                ]);     
            } catch (Exception $e) {
            }
         }
         else{
            try {
                $subscription = \Stripe\Subscription::create([
                'customer' => $stripeCustomerId,
                'items' => [
                    [
                        'plan' => $stripePlanId,
                    ],
                ],
                'expand' => ['latest_invoice.payment_intent'],
                ],[
                    'idempotency_key' => $request->idempotent_id,
                ]);
            } catch (Exception $e) {
            }
        }
         
        return redirect()->route('thankyou.page');
    }
    public function thankyouPage(){
        return view('billing_and_payment.parents_thankyou');
    }

    public function showPromo(Request $request){
        $user = Auth::user();
        $emailId = $user->email;
        if($emailId == null || $emailId == ""){
            return view('billing_and_payment.parents_email');
        }
        else{
            $promo = stripeModel::where(['password' => $request->promo_code,
                                        'is_promo' => true])->with('currency')->first();
            if($promo != null){
                $promo_id = $promo->product_id;
                $promo_name = $promo->product_name;
                $promo_desc = $promo->description;
                $promo_price = number_format((float)$promo->price, 2, '.', '');
                $promo_currency = $promo->currency->name;

                $user = Auth::user();
                $emailId = $user->email;  
            
                return view('billing_and_payment.plan')->withPlanid($promo_id)
                                                    ->withPlanname($promo_name)
                                                    ->withPlandescription($promo_desc)
                                                    ->withPlanprice($promo_price)
                                                    ->withPlancurrency($promo_currency)
                                                    ->withEmailid($emailId);  
            }  
            else{
                $plans = $this->getPlans();
                return view('billing_and_payment.parents_billing', compact('plans'))->withError("No such promotion exists.");
            }
        }
    }

    public function billingHistory(){
        return view('billing_and_payment.billing_history');
    }

    public function billingHistoryOfSubscriptions($userId = null){
        /*
        * If the value of $userId is null, it means a loggedIn Parent wants to
        * retrieve list of their subscriptions. But if it's not null, it means an Admin or 
        * teacher is trying to get list of subscriptions for a particular parent by passing
        * his/her id. 
        */
        if($userId != null){
            $user = User::find($userId);
        }else{
            $user = Auth::user();
        }
        $userId = $user->id;
        $emailId = $user->email;
        $parent = UserParent::where('user_id',$userId)->first();
        $stripeBillingHistoryOfSubscriptions = array();

        if($parent != null){
            $parentStripeId = $parent->stripe_customer_id;
        }    
        if($parent == null || $parentStripeId == null || $parentStripeId == ""){}
        else{
            //We have a stripe customer id for this loggedIn Parent.
            $stripeTestSecretKey = Configuration::where('key', 'stripe_live_secret_key')->value('value');
            \Stripe\Stripe::setApiKey($stripeTestSecretKey);
           
            $stripeCustomerSubscriptionsData = \Stripe\Customer::retrieve($parentStripeId); 
            $stripeCustomerSubscriptions = $stripeCustomerSubscriptionsData->subscriptions;
            foreach($stripeCustomerSubscriptions as $stripeCustomerSubscription){
                $plan = $stripeCustomerSubscription->plan;
                $subscription_frequency_id = stripeModel::where(['product_id' => $plan->id ,
                                                              'is_subscription' => true])->value('frequency_id');
                $subscription_frequency = TaskClassFrequency::where('id',$subscription_frequency_id)->value('name');
                $invoice_data = \Stripe\Invoice::retrieve($stripeCustomerSubscription->latest_invoice);
                $invoice_url = $invoice_data->hosted_invoice_url;
                
                $dataArray = [
                    'plan_id' => $plan->id,
                    'subscription_name' => $plan->name,
                    'amount' => ($plan->amount)/100,
                    'currency' => $plan->currency,
                    'frequency' => $subscription_frequency,
                    'invoice_url' => $invoice_url,
                ];
                array_push($stripeBillingHistoryOfSubscriptions,$dataArray);
            }
        }
        if(count($stripeBillingHistoryOfSubscriptions) > 0){
            return response()->json(['subscriptions'=> $stripeBillingHistoryOfSubscriptions],200);
        }else{
            return response()->json(['response_msg'=>'No history of Subscriptions.'],200);
        }
    }

    public function billingHistoryOfOneTimePayments($userId = null){
        /*
        * If the value of $userId is null, it means a loggedIn Parent wants to
        * retrieve list of their one-time-payments. But if it's not null, it means an Admin or 
        * teacher is trying to get list of one-time-payments for a particular parent by passing
        * his/her id. 
        */
        if($userId != null){
            $user = User::find($userId);
        }else{
            $user = Auth::user();
        }
        $userId = $user->id;
        $emailId = $user->email;
        $parent = UserParent::where('user_id',$userId)->first();
        $stripeBillingHistoryOfOneTimePayments = array();

        if($parent != null){
            $parentStripeId = $parent->stripe_customer_id;
        }    
        if($parent == null || $parentStripeId == null || $parentStripeId == ""){}
        else{
            //We have a stripe customer id for this loggedIn Parent.
            $stripeTestSecretKey = Configuration::where('key', 'stripe_live_secret_key')->value('value');
            \Stripe\Stripe::setApiKey($stripeTestSecretKey); 
    
            $stripeCustomerPaymentIntents = \Stripe\PaymentIntent::all(['customer' => $parentStripeId]);
            foreach($stripeCustomerPaymentIntents as $stripeCustomerPaymentIntent){
                $invoiceId = $stripeCustomerPaymentIntent->invoice;
                $status = $stripeCustomerPaymentIntent->status;
                if($invoiceId == null && $status == "succeeded"){
                    //It's a One-time payment
                    $date = date('d M Y',$stripeCustomerPaymentIntent->created);
                    if($stripeCustomerPaymentIntent->charges->data != null && $stripeCustomerPaymentIntent->charges->data != ""){
                        $receipt_url = $stripeCustomerPaymentIntent->charges->data[0]->receipt_url;
                        $metadata_product_id = $stripeCustomerPaymentIntent->metadata->product_id;
                        $stripe_product = stripeModel::where('product_id',$metadata_product_id)->with('currency')->first();
                        $currency = $stripe_product->currency->name;
                        $dataArray = [
                            'product_name' => $stripe_product->product_name,
                            'amount' => number_format((float)$stripe_product->price, 2, '.', ''),
                            'currency' => $currency,
                            'paid_at' => $date,
                            'receipt_url' => $receipt_url,
                        ];
                        array_push($stripeBillingHistoryOfOneTimePayments,$dataArray);
                    }
                }
            }  
        }
        if(count($stripeBillingHistoryOfOneTimePayments) > 0){
            return response()->json(['oneTimePayments'=> $stripeBillingHistoryOfOneTimePayments],200);
        }else{
            return response()->json(['response_msg'=>'No history of One time payments.'],200);
        }
    }

    public function makeRegistrationPayment(Request $request){

        $stripeTestSecretKey = Configuration::where('key', 'stripe_live_secret_key')->value('value');
        \Stripe\Stripe::setApiKey($stripeTestSecretKey);

        $user = User::find($request->input('user'));

        //Check if customer already exists in Stripe
        $userId = $user->id;
        $emailId = $user->email;
        $parent = UserParent::where('user_id',$userId)->first();
        $parentStripeId = "";

        if($parent != null){
            $parentStripeId = $parent->stripe_customer_id;
        }
        if($parent == null || $parentStripeId == null || $parentStripeId == ""){
            // This creates a new Customer and attaches the default PaymentMethod in one API call.
            $stripeCustomer = \Stripe\Customer::create([
                'payment_method' => $request->payment_method,
                'email' => $emailId,
                'invoice_settings' => [
                    'default_payment_method' => $request->payment_method
                ]
            ]);

            $stripeCustomerId = $stripeCustomer->id;

            $newParentRecord = new UserParent();
            $newParentRecord->user_id = $userId;
            $newParentRecord->stripe_customer_id = $stripeCustomerId;
            $newParentRecord->save();
        }
        else{
            $stripeCustomerId = $parentStripeId;
        }

        $stripePlanId = $request->plan_id;
        $plan = stripeModel::where(['product_id' => $stripePlanId])->with('currency')->first();

        $plan_id = $plan->product_id;
        $plan_name = $plan->product_name;
        $plan_desc = $plan->description;
        $plan_price = $plan->price;
        $plan_currency = $plan->currency->name;

        $paymentIntent = \Stripe\PaymentIntent::create([
            'amount' => $plan_price * 100,
            'currency' => $plan_currency,
            'customer' => $stripeCustomerId,
            'payment_method' => $request->payment_method,
            'payment_method_types' => ['card'],
            'confirm' => true,
            'metadata' => [
                'product_id' => $plan_id,
            ]
        ],[
            'idempotency_key' => $request->idempotent_id
           ]);


        return response()->json(['data' => $paymentIntent, 'message' => 'Success'],200);
    }

    public function getAllBillingProducts(){
        $stripeProducts = DB::table('stripes as s')
                            ->join('task_class_types as tct','tct.id','=','s.task_class_type_id')
                            ->join('locations as l','l.id' , '=', 's.location_id')
                            ->join('task_class_frequencies as tcf','tcf.id','=','s.frequency_id')
                            ->join('currencies as c','c.id','=','s.currency_id')
                            ->where('s.is_deleted', false)
                            ->select('s.*','l.id as location_id','l.location_name as location_name','tct.id as task_class_type_id','tct.type_name as task_class_type_name','tcf.name as frequency','c.name as currency')
                            ->orderBy('s.id', 'DESC')
                            ->get();

        return response()->json(['billingProducts'=> $stripeProducts],200);
    }

    public function addNewBillingProductForm(){
        return view('billing_and_payment.admin_add_billing_products');
    }

    public function addNewBillingProduct(Request $request){
        $billing_product = new stripeModel();
        $billing_product->product_id = $request->product_id;
        $billing_product->product_name = $request->product_name;
        $billing_product->description = $request->description;
        $billing_product->frequency_id = $request->frequency_id;
        $billing_product->price = $request->price;
        $billing_product->currency_id = $request->currency_id;
        $billing_product->number_of_credits = $request->number_of_credits;
        $billing_product->is_subscription = $request->is_subscription;
        $billing_product->password = $request->password;
        $billing_product->is_promo = $request->is_promo;
        $billing_product->task_class_type_id = $request->task_class_type_id;
        $billing_product->location_id = $request->location_id;
        $billing_product->save();
 
        return response()->json(['response_msg'=> "Product has been added."],200);
    }

    public function editBillingProduct(Request $request, $id){
       $billing_product = stripeModel::where('id',$id)->first();
       $billing_product->product_id = $request->product_id;
       $billing_product->product_name = $request->product_name;
       $billing_product->description = $request->description;
       $billing_product->frequency_id = $request->frequency_id;
       $billing_product->price = $request->price;
       $billing_product->currency_id = $request->currency_id;
       $billing_product->number_of_credits = $request->number_of_credits;
       $billing_product->is_subscription = $request->is_subscription;
       $billing_product->password = $request->password;
       $billing_product->is_promo = $request->is_promo;
       $billing_product->task_class_type_id = $request->task_class_type_id;
       $billing_product->location_id = $request->location_id;
       $billing_product->save();

       return response()->json(['response_msg'=> "Product has been updated."],200);
    }

    public function deleteBillingProduct($id){
        $data = stripeModel::find($id);
        $data->is_deleted = true;
        $data->update();
        return response()->json(['response_msg'=>'Data deleted'],200);
    }

    public function listOfStripeProductsDirectLinks(){
       $listOfBillingProductsLinks = stripeModel::where(['is_deleted' => false])->with('currency')->get();
       $plans = array();
       foreach($listOfBillingProductsLinks as $plan){
            $url = " https://portal.codewithus.com/plan/".$plan->product_id."";
            $dataArray = ["id" =>$plan->id,
            "product_id" => $plan->product_id,
            "product_name" => $plan->product_name,
            "url" => $url,
            ];
            array_push($plans,$dataArray);           
        }

        return view('billing_and_payment.direct_links_to_billing_products',compact('plans'));
    }

    public function subscriptionsOfAUser(){
        return view('billing_and_payment.parents_subscriptions');
    }

    public function allActiveSubscriptionsOfAUser(){
        $user = Auth::user();
        $userId = $user->id;
        $userStripeId = UserParent::where('user_id',$userId)->value('stripe_customer_id');

        //$userStripeId = "cus_FH4g5lIC0OjXlQ";
        $stripeTestSecretKey = Configuration::where('key', 'stripe_live_secret_key')->value('value');
        \Stripe\Stripe::setApiKey($stripeTestSecretKey); 

        $stripeCustomerActiveSubscriptions = \Stripe\Subscription::all(['customer' => $userStripeId, 'status' => 'active']);
        $activeSubs = array();

        foreach($stripeCustomerActiveSubscriptions as $stripeCustomerActiveSubscription){
            $dataArray = ['subscription_id' => $stripeCustomerActiveSubscription->id,
                          'product_name' => $stripeCustomerActiveSubscription->plan->name];
            array_push($activeSubs,$dataArray);
        }

        if(count($activeSubs) > 0){
            return response()->json(['activeSubscriptions'=> $activeSubs],200);
        }
        else{
            return response()->json(['response_msg'=> "No Active Subscriptions"],200);
        }
    }

    public function allFreezedSubscriptionsOfAUser(){
        $user = Auth::user();
        $userId = $user->id;
        // $userStripeId = UserParent::where('user_id',$userId)->value('stripe_customer_id');
        $stripeCustomerfreezedSubscriptions = FreezedSubscriptions::where(['user_id' => $userId,
                                                                           'is_deleted' => false]);
        $freezedSubs = array();

        foreach($stripeCustomerfreezedSubscriptions as $stripeCustomerfreezedSubscription){
            $dataArray = ['subscription_id' => $stripeCustomerfreezedSubscription->subscription_id,
                          'product_name' => $stripeCustomerfreezedSubscription->product_name];
            array_push($freezedSubs,$dataArray);
        }

        if(count($freezedSubs) > 0){
            return response()->json(['freezedSubscriptions'=> $freezedSubs],200);
        }
        else{
            return response()->json(['response_msg'=> "No Freezed Subscriptions"],200);
        }
    }

    public function allCancelledSubscriptionsOfAUser(){
        $user = Auth::user();
        $userId = $user->id;
        $userStripeId = UserParent::where('user_id',$userId)->value('stripe_customer_id');

        //$userStripeId = "cus_FH4g5lIC0OjXlQ";
        $stripeTestSecretKey = Configuration::where('key', 'stripe_live_secret_key')->value('value');
        \Stripe\Stripe::setApiKey($stripeTestSecretKey); 

        $stripeCustomerCancelledSubscriptions = \Stripe\Subscription::all(['customer' => $userStripeId, 'status' => 'canceled']);
        $cancelledSubs = array();

        foreach($stripeCustomerCancelledSubscriptions as $stripeCustomerCancelledSubscription){
            $dataArray = ['subscription_id' => $stripeCustomerCancelledSubscription->id,
                          'product_name' => $stripeCustomerCancelledSubscription->plan->name];
            array_push($cancelledSubs,$dataArray);
        }

        if(count($cancelledSubs) > 0){
            return response()->json(['cancelledSubscriptions'=> $cancelledSubs],200);
        }
        else{
            return response()->json(['response_msg'=> "No Cancelled Subscriptions"],200);
        }
    }

    public function reActivateASubscription(Request $request){
        $stripeLiveSecretKey = Configuration::where('key', 'stripe_live_secret_key')->value('value');
        \Stripe\Stripe::setApiKey($stripeLiveSecretKey);

        \Stripe\Subscription::update(
        $request->subscriptionId,
            [
                'pause_collection' => '',
            ]
        );

        $freezedSubscription = FreezedSubscriptions::where('subscription_id',$request->subscriptionId)->first();
        $freezedSubscription->is_deleted = true;
        $freezedSubscription->save();

        return response()->json(['response_msg'=> "Subscription is Reactivated"],200);
    }

    public function freezeASubscription(Request $request){
        $stripeLiveSecretKey = Configuration::where('key', 'stripe_live_secret_key')->value('value');
        \Stripe\Stripe::setApiKey($stripeLiveSecretKey);

        \Stripe\Subscription::update(
            $request->subscriptionId,
            [
                'pause_collection' => [
                'behavior' => 'keep_as_draft',
                ],
            ]
        );

        return response()->json(['response_msg'=> "Subscription is Paused"],200);
    }

    public function cancelASubscription(Request $request) {
        $user = Auth::user();
        $userId = $user->id;

        $stripeLiveSecretKey = Configuration::where('key', 'stripe_live_secret_key')->value('value');
        \Stripe\Stripe::setApiKey($stripeLiveSecretKey);

        $subscription = \Stripe\Subscription::retrieve($request->subscriptionId);
        $subscription->cancel();

       $cancelled_subs = CancelledSubscription::updateOrCreate([
            'subscription_id' => $request->subscriptionId,
            'user_id' => $userId,
            'reason_of_cancellation' => $request->cancellation_reason
       ]);

       return response()->json(['response_msg'=> "Subscription is Cancelled"],200);
    }

    public function getStudentsOfTheParent(){
        $parent = Auth::user();
        $parent_phone_number = $parent->phone_number;
        $studentRoleId = Role::where('role','student')->value('id');
        $students = User::where(['role_id' => $studentRoleId,
                                 'phone_number' => $parent_phone_number])->get();
        return response()->json(['students'=> $students],200);
    }

    public function sendStudentScheduleToTheCwuTeam(Request $request,MailFunctions $mail){
        $students = $request->selectedStudents; 
        $parent = Auth::user();
        foreach($students as $selectedStudent){
            $student =  User::find($selectedStudent);
            $data = array(
                'parent_email' => $parent->email,
                'parent_phone_number' => $parent->phone_number,
                'student_name' => $student->full_name,
                'message' => $request->description
            );
            $mail->send_student_schedule_request_by_parents("operations@codewithus.com",$data); 
        }
    }

}
