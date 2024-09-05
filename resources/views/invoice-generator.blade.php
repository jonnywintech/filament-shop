<div class="inv-paper bg-white dark:bg-slate-700 p-8 shadow-lg dark:shadow-none">
    <style>
        .inv-paper {
            font-family: '{{ $font }}', sans-serif;
        }

        .accent {
            background-color: {{ $color }};
        }
    </style>
    <div class="flex flex-col md:flex-row">
        <div class="md:w-1/2 p-4">
            @if ($logo && $show_logo)
                <x-invoice.logo class="ml-6" :src="url('storage') . '/' . $logo" />
            @endif
        </div>
        <div class="md:w-1/2 p-4">


            <h2 class="text-2xl pt-2 pe-3 pb-4 text-end dark:text-white">{{ env('APP_NAME') }}</h2>
        </div>
    </div>
    <hr class="dark:border-white">
    <h1 class="text-6xl py-5 pb-10 text-start dark:text-white">Invoice</h1>
    <h3 class="text-2xl dark:text-white">BILL TO</h3>
    @forelse ($invoice_data as $djata)
    @empty
        <h3 class="text-3xl dark:text-white text-bold">Customer Name</h3>
        <div class="flex flex-col md:flex-row">
            <div class="md:w-1/2 p-4">
                <ul class="list-none">
                    <li>123 Main Street</li>
                    <li>New York, New York 10001</li>
                    <li>United States</li>
                </ul>
            </div>
            <div class="md:w-1/2 p-4">
                <ul class="list-none">
                    <li class="mb-2">
                        <span class="font-bold">Invoice Number:</span>
                        <span class="ml-2">INV-00001</span>
                    </li>
                    <li class="mb-2">
                        <span class="font-bold">Invoice Date:</span>
                        <span class="ml-2">Sep 3, 2024</span>
                    </li>
                    <li>
                        <span class="font-bold">Payment Due:</span>
                        <span class="ml-2">Sep 3, 2024</span>
                    </li>
                </ul>
            </div>
        </div>
        <table class="w-full mb-6">
            <thead class="accent dark:text-white">
                <tr>
                    <th class="p-2 text-left">Items</th>
                    <th class="p-2 text-right">Quantity</th>
                    <th class="p-2 text-right">Price</th>
                    <th class="p-2 text-right">Amount</th>
                </tr>
            </thead>
            <tbody>
                <tr class="border-b">
                    <td class="p-2 font-bold">Item 1</td>
                    <td class="p-2 text-right">2</td>
                    <td class="p-2 text-right">$150.00</td>
                    <td class="p-2 text-right">$300.00</td>
                </tr>
                <tr class="border-b">
                    <td class="p-2 font-bold">Item 2</td>
                    <td class="p-2 text-right">3</td>
                    <td class="p-2 text-right">$200.00</td>
                    <td class="p-2 text-right">$600.00</td>
                </tr>
                <tr class="border-b">
                    <td class="p-2 font-bold">Item 3</td>
                    <td class="p-2 text-right">1</td>
                    <td class="p-2 text-right">$180.00</td>
                    <td class="p-2 text-right">$180.00</td>
                </tr>
            </tbody>
        </table>
    @endforelse

    <div class="flex justify-end">
        <div class="w-1/2">
            <div class="flex justify-between border-b py-2">
                <span class="font-bold">Subtotal:</span>
                <span>$1080.00</span>
            </div>
            <div class="flex justify-between border-b py-2">
                <span>Discount (5%):</span>
                <span>($54.00)</span>
            </div>
            <div class="flex justify-between border-b py-2">
                <span>Sales Tax (10%):</span>
                <span>$102.60</span>
            </div>
            <div class="flex justify-between font-bold text-lg py-2">
                <span>Total:</span>
                <span>$1128.60</span>
            </div>
            <div class="flex justify-between font-bold text-lg py-2">
                <span>Amount Due (USD):</span>
                <span>$1128.60</span>
            </div>
        </div>
    </div>
</div>
