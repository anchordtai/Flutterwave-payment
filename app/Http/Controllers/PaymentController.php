<?php
// app/Http/Controllers/PaymentController.php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PaymentController extends Controller
{

    //pass public key to the blade
    public function showPaymentForm()
    {
        // Get the public key from your Flutterwave settings
        $publicKey = env('FLUTTERWAVE_PUBLIC_KEY'); // Retrieve the public key from the .env file
        $secretKey = env('FLUTTERWAVE_SECRET_KEY');
        // Pass the variable to the Blade view
        return view('payment.form', compact('publicKey', 'secretKey')); // Pass the variable to the Blade view
    }


    /**
     * Initiate payment via Flutterwave API
     */
    public function initiatePayment(Request $request)
    {
        // Ensure required fields are provided
        $request->validate([
            'amount' => 'required|numeric',
            'currency' => 'required|string',
            'email' => 'required|email',
            'item_name' => 'required|string'
        ]);

        // Generate a unique transaction reference
        $tx_ref = 'TX' . time();

        // Prepare payment data
        $paymentData = [
            'tx_ref' => $tx_ref,
            'amount' => $request->amount,
            'currency' => $request->currency,
            'email' => $request->email,
            'order_id' => rand(1000, 9999), // This can be an order ID from your database
            'order_description' => $request->item_name,
            'redirect_url' => route('payment.callback'),
            'payment_options' => 'card, mobilemoney, ussd', // Customize as needed
        ];


        // Send request to Flutterwave to initiate payment
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . env('FLUTTERWAVE_SECRET_KEY')
            ])->post('https://api.flutterwave.com/v3/charges?tx_ref=' . $tx_ref, $paymentData);

            // Handle response
            $data = $response->json();

            if ($data['status'] === 'success') {
                // Redirect the user to Flutterwave's hosted payment page
                return redirect($data['data']['link']);
            }

            // Return error if payment initiation fails
            return back()->with('error', 'Payment initiation failed: ' . $data['message']);
        } catch (\Exception $e) {
            Log::error('Payment initiation error: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while initiating payment.');
        }
    }

    /**
     * Handle payment callback after user completes payment
     */
    public function paymentCallback(Request $request)
    {
        $tx_ref = $request->get('tx_ref');
        $status = $request->get('status');

        if ($status === 'successful') {
            // Transaction was successful, verify the payment

            //verify the payment status from flutterwave API
            $verificationResult = $this->verifyTransaction($tx_ref);
            // Optionally, you can update your database or grant access
            return view('payment.success'); // You can create a view to show success
        }
    }

    /**
     * Verify payment status with Flutterwave API
     */
    public function verifyTransaction($tx_ref)
    {
        // Make API call to verify transaction
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('FLUTTERWAVE_SECRET_KEY')
        ])->get("https://api.flutterwave.com/v3/transactions/{$tx_ref}/verify");
        $data = $response->json();

        // If the transaction is successful, proceed to update the database
        if ($data['status'] === 'success') {
            $transaction = $data['data'];

            // Handle successful transaction (e.g., updating user database, activating services)
            // Example: Update user's payment status in the database
            // User::where('id', $userId)->update(['has_paid' => true]);
            return true;
        } else {
            // Handle failed transaction
            // Log or notify user of failure
            Log::error('Transaction verification failed for tx_ref:', $tx_ref);
            return false;

            // Transaction failed
            return view('payment.failed');
        }
    }
}
