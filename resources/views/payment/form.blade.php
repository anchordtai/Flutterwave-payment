<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Form</title>

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>
<body>
    <div class="flex items-center justify-center min-h-screen bg-gray-100">
        <div class="w-full max-w-xs p-8 bg-white rounded-lg shadow-lg">
            <h1 class="mb-4 text-2xl font-bold text-center">
                <img src="your-logo.png" alt="Itembo.com Logo" class="inline-block w-16 h-16 mr-2">
                Itembo.com
            </h1>

            @if(session('error'))
                <div class="mb-4 text-red-500">{{ session('error') }}</div>
            @endif

            
            <form action="{{ route('payment.initiate') }}" method="POST" class="space-y-4">
                @csrf

                <input type="hidden" name="publicKey" value="{{ env('FLUTTERWAVE_PUBLIC_KEY') }}">

                <div>
                    <label for="amount" class="block mb-2 text-sm font-bold text-gray-700">Amount:</label>
                    <input type="number" name="amount" id="amount" class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline" required>
                </div>

                <div>
                    <label for="currency" class="block mb-2 text-sm font-bold text-gray-700">Currency:</label>
                    <input type="text" name="currency" id="currency" class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline" required>
                </div>

                <div>
                    <label for="email" class="block mb-2 text-sm font-bold text-gray-700">Email:</label>
                    <input type="email" name="email" id="email" class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline" required>
                </div>

                <div>
                    <label for="item_name" class="block mb-2 text-sm font-bold text-gray-700">Item Name:</label>
                    <input type="text" name="item_name" id="item_name" class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline" required>
                </div>

                <button type="submit" class="w-full px-4 py-2 font-bold text-white bg-blue-500 rounded hover:bg-black focus:outline-none focus-shadow-outline">Pay Now</button>
            </form>
        </div>
    </div>
</body>
</html>
