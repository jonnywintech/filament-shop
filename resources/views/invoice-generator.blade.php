<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <div class="inv-paper bg-white dark:bg-slate-700 p-8">
        <style>
            * {
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
        <h3 class="text-xl dark:text-white">Bill to:</h3>
        <h3 class="text-3xl dark:text-white font-bold">
            {{ $order->address->first_name }}
            {{ $order->address->last_name }}
        </h3>
        <div class="flex flex-col md:flex-row">
            <div class="md:w-1/2 p-4">
                <ul class="list-none">
                    <li>{{ $order->address->street_address }}</li>
                    <li>{{ $order->address->city }}</li>
                    <li>{{ $order->address->state }}</li>
                </ul>
            </div>
            <div class="md:w-1/2 p-4">
                <ul class="list-none">
                    <li class="mb-2">
                        <span class="font-bold">Invoice Number:</span>
                        <span class="ml-2">INV-{{ $order->id }}</span>
                    </li>
                    <li class="mb-2">
                        <span class="font-bold">Invoice Date:</span>
                        <span class="ml-2">{{ date('Y/m/d') }}</span>

                    </li>
                    <li>
                        <span class="font-bold">Payment Due:</span>
                        <span class="ml-2">
                            @if ($order->payment_status === 'paid')
                                {{ \Carbon\Carbon::parse($order->created_at)->format('Y/m/d') }}
                            @else
                            {{ \Carbon\Carbon::parse($order->created_at)->addDays(7)->format('Y/m/d') }}
                            @endif
                        </span>
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
                @foreach ($order->items as $item)
                    <tr class="border-b">
                        <td class="p-2 font-bold">{{ $item->product->name }}</td>
                        <td class="p-2 text-right">{{ $item->quantity }}</td>
                        <td class="p-2 text-right">{{ $item->unit_amount }}</td>
                        <td class="p-2 text-right">{{ $item->total_amount }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="flex justify-end">
            <div class="w-1/2">
                <div class="flex justify-between border-b py-2">
                    <span class="font-bold">Subtotal:</span>
                    <span>{{ Number::currency($order->grand_total, $order->currency ?? 'USD') }}</span>
                </div>
                <div class="flex justify-between border-b py-2">
                    <span>Discount (5%):</span>
                    <span>{{ Number::currency($a = number_format($order->grand_total * 0.05, 2), $order->currency ?? 'USD') }}
                    </span>
                </div>
                <div class="flex justify-between border-b py-2">
                    <span>Sales Tax (10%):</span>
                    <span>{{ Number::currency($b = number_format($order->grand_total * 0.1, 2), $order->currency ?? 'USD') }}</span>
                </div>
                <div class="flex justify-between font-bold text-lg py-2">
                    <span>Total:</span>
                    <span>{{ Number::currency($order->grand_total, $order->currency ?? 'USD') }}</span>
                </div>
                <div class="flex justify-between font-bold text-lg py-2">
                    <span>Amount Due (USD):</span>
                    <span>{{ Number::currency($order->grand_total - $a + $b, 'USD') }}</span>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
