<form action="{{ route('payment.process') }}" method="POST">
  @csrf
  <input type="text" name="amount" placeholder="Enter amount">
  <!-- Add more fields for payment details -->
  <button type="submit">Pay Now</button>
</form>

<!--new-->
<form id="paymentForm" class="space-y-4">
    <div>
        <label for="itemName" class="block text-sm font-medium text-gray-700">Item Name</label>
        <input type="text" id="itemName" name="item_name" class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500" placeholder="Enter item name" required>
    </div>
    <div>
        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
        <input type="email" id="email" name="email" class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500" placeholder="Enter your email" required>
    </div>
    <div>
        <label for="amount" class="block text-sm font-medium text-gray-700">Amount</label>
        <input type="number" id="amount" name="amount" class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500" placeholder="Enter amount" required>
    </div>
    <div>
        <label for="currency" class="block text-sm font-medium text-gray-700">Currency</label>
        <select id="currency" name="currency" class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
            <option value="USD">USD</option>
            <option value="NGN">NGN</option>
            <option value="EUR">EUR</option>
        </select>
    </div>

    <button type="button" onclick="makePayment()" class="w-full px-4 py-2 font-semibold text-white bg-blue-600 rounded-lg shadow hover:bg-blue-700">
        Pay Now
    </button>
</form>