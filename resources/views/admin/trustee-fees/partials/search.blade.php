<!-- resources/views/trustee_fees/partials/search.blade.php -->
<div class="mb-6 bg-white rounded-lg shadow-md p-4">
    <form action="{{ route('trustee-fees.search') }}" method="GET">
        <div class="text-gray-700 font-medium mb-2">Search Trustee Fees</div>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label for="issuer" class="block text-sm font-medium text-gray-700">Issuer</label>
                <input type="text" name="issuer" id="issuer" value="{{ request('issuer') }}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
            </div>
            
            <div>
                <label for="invoice_no" class="block text-sm font-medium text-gray-700">Invoice No</label>
                <input type="text" name="invoice_no" id="invoice_no" value="{{ request('invoice_no') }}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
            </div>
            
            <div>
                <label for="month" class="block text-sm font-medium text-gray-700">Month</label>
                <select name="month" id="month" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option value="">All Months</option>
                    <option value="Jan" {{ request('month') == 'Jan' ? 'selected' : '' }}>January</option>
                    <option value="Feb" {{ request('month') == 'Feb' ? 'selected' : '' }}>February</option>
                    <option value="Mar" {{ request('month') == 'Mar' ? 'selected' : '' }}>March</option>
                    <option value="Apr" {{ request('month') == 'Apr' ? 'selected' : '' }}>April</option>
                    <option value="May" {{ request('month') == 'May' ? 'selected' : '' }}>May</option>
                    <option value="Jun" {{ request('month') == 'Jun' ? 'selected' : '' }}>June</option>
                    <option value="Jul" {{ request('month') == 'Jul' ? 'selected' : '' }}>July</option>
                    <option value="Aug" {{ request('month') == 'Aug' ? 'selected' : '' }}>August</option>
                    <option value="Sep" {{ request('month') == 'Sep' ? 'selected' : '' }}>September</option>
                    <option value="Oct" {{ request('month') == 'Oct' ? 'selected' : '' }}>October</option>
                    <option value="Nov" {{ request('month') == 'Nov' ? 'selected' : '' }}>November</option>
                    <option value="Dec" {{ request('month') == 'Dec' ? 'selected' : '' }}>December</option>
                </select>
            </div>
            
            <div>
                <label for="payment_status" class="block text-sm font-medium text-gray-700">Payment Status</label>
                <select name="payment_status" id="payment_status" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option value="">All Statuses</option>
                    <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Paid</option>
                    <option value="unpaid" {{ request('payment_status') == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                </select>
            </div>
        </div>
        
        <div class="mt-4 flex justify-end">
            <a href="{{ route('trustee-fees.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 mr-2">
                Reset
            </a>
            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                Search
            </button>
        </div>
    </form>
</div>