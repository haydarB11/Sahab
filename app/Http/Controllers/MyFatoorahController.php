<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Manager;
use App\Models\Place;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;
use MyFatoorah\Library\PaymentMyfatoorahApiV2;

class MyFatoorahController extends Controller {

    public $mfObj;

//-----------------------------------------------------------------------------------------------------------------------------------------

    /**
     * create MyFatoorah object
     */
    public function __construct() {
        $this->mfObj = new PaymentMyfatoorahApiV2(config('myfatoorah.api_key'), config('myfatoorah.country_iso'), config('myfatoorah.test_mode'));
    }

//-----------------------------------------------------------------------------------------------------------------------------------------

    /**
     * Create MyFatoorah invoice
     *
     * @return \Illuminate\Http\Response
     */
    public function index($bookingId) {
        try {

            $booking = Booking::with('paymentMethod')->where('bookings.id', $bookingId)->first();
            $paymentMethodId = $booking->paymentMethod->payment_method_id; // test how to get payment method id
            // dd($paymentMethodId);
            // $paymentMethodId = 0; // 0 for MyFatoorah invoice or 1 for Knet in test mode

            $curlData = $this->getPayLoadData($bookingId);
            $data     = $this->mfObj->getInvoiceURL($curlData, $paymentMethodId);

            // dd($data);

            $response = ['IsSuccess' => 'true', 'Message' => 'Invoice created successfully.', 'Data' => $data];
        } catch (\Exception $e) {
            $booking = Booking::where('bookings.id', $bookingId)->first();
            $booking->delete();
            $response = ['IsSuccess' => 'false', 'Message' => $e->getMessage()];
        }
        return response()->json($response);
    }

//-----------------------------------------------------------------------------------------------------------------------------------------

    /**
     *
     * @param int|string $orderId
     * @return array
     */
    private function getPayLoadData($bookingId) {
        $callbackURL = route('myfatoorah.callback');

        $booking = Booking::findOrFail($bookingId);

        // dd($booking);

        $userEmail = $booking->user->email;
        $userName = $booking->user->name;
        $userNumber = $booking->user->phone;
        $totalPrice = $booking->total_price;
        $supplierCode = "";

        if ($booking->service_id) {
            $supplierCode = $booking->service->vendor->supplier_code;
        } else {
            $supplierCode = $booking->place->vendor->supplier_code;
        }

        // added by abd
        if ($booking->promo_code_id) {
            $priceAfterDiscount = $totalPrice - $totalPrice * $booking->promoCode->discount / 100;
            $booking->payment = $priceAfterDiscount;
            $booking->save();
        } else {
            $booking->payment = $totalPrice;
            $booking->save();
        }

        $payment = $booking->payment;

        return [
            'CustomerName'       => $userName,
            'InvoiceValue'       => $payment,
            'DisplayCurrencyIso' => 'KWD',
            'CustomerEmail'      => $userEmail,
            'CallBackUrl'        => $callbackURL,
            'ErrorUrl'           => $callbackURL,
            'MobileCountryCode'  => '+965',
            'CustomerMobile'     => $userNumber,
            'Language'           => 'en',
            'CustomerReference'  => $bookingId,
            'Suppliers'          => [
                [
                    'SupplierCode' => "$supplierCode",
                    'InvoiceShare' => $payment
                ]
            ],
            'SourceInfo'         => 'Laravel ' . app()::VERSION . ' - MyFatoorah Package ' . MYFATOORAH_LARAVEL_PACKAGE_VERSION
        ];

        // 'Commission' => $commissionAmount,
        // 'CustomerReference'  => $customerReference,

    }

//-----------------------------------------------------------------------------------------------------------------------------------------

    /**
     * Get MyFatoorah payment information
     *
     * @return \Illuminate\Http\Response
     */
        public function callback() {
            try {
                $paymentId = request('paymentId');
                $data = $this->mfObj->getPaymentStatus($paymentId, 'PaymentId');

                $booking = Booking::where('bookings.id', $data->CustomerReference)->first();
                $booking->invoice_reference = $data->InvoiceReference;
                $booking->transaction_id = $data->InvoiceTransactions[0]->TransactionId;
                $booking->reference_id = $data->InvoiceTransactions[0]->ReferenceId;
                $booking->save();

                if ($data->InvoiceStatus == 'Paid') {
                    $msg = 'Invoice is paid.';
                    $pushNotification = new pushNotificationController();
                    $title = "new booking added";
                    $body = "";
                    $user_id = 0;
                    $name = "";
                    if ($booking->place_id) {
                        $place = Place::where('id', $booking->place_id)->first();
                        $body = "your booking has been successfully added for place $place->title with payment $booking->payment";
                        $user_id = $place->vendor_id;
                        $name = $place->title;
                        $category=$place->category->title;
                    } else {
                        $service = Service::where('id', $booking->service_id)->first();
                        $body = "your booking has been successfully added for service $service->title with payment $booking->payment";
                        $user_id = $service->vendor_id;
                        $name = $service->title;
                        $category=$service->category->title;
                    }
                    $pushNotification->pushNotificationForSpecificUser($title, $body, $user_id);
                } else if ($data->InvoiceStatus == 'Failed') {
                    $msg = 'Invoice is not paid due to ' . $data->InvoiceError;
                } else if ($data->InvoiceStatus == 'Expired') {
                    $msg = 'Invoice is expired.';
                }

                $discount = $booking->total_price - $booking->payment;
                $response = ['IsSuccess'=>'true','bookingId'=>$booking->id,'status'=>$booking->status,'category'=>$category,'amount'=>$booking->total_price,'name'=>$booking->user->name,'phone'=>$booking->user->phone,'start'=>$booking->starting_date,'end'=>$booking->ending_date,'method'=>$booking->paymentMethod->payment_method,'transaction_id'=>$booking->transaction_id,'reference_id'=>$booking->reference_id,'invoice_reference'=>$booking->invoice_reference,'discount'=>$discount,'total'=>$booking->payment,'Message'=>$msg];
                $queryParams = http_build_query($response);
                $urlWithParams = route('categories.All') . '?' . $queryParams;
                return redirect()->away($urlWithParams);
            } catch (\Exception $e) {
                $response = ['IsSuccess'=>'false','Message'=>$e->getMessage()];
                $queryParams = http_build_query($response);
                $urlWithParams = route('categories.All') . '?' . $queryParams;
                return redirect()->away($urlWithParams);
            }
            return response()->json($response);
        }

//-----------------------------------------------------------------------------------------------------------------------------------------
}
