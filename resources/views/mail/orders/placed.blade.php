<x-mail::message>
# Order Placed successfully

Thank you for your puchace.

Your order number is: {{ $order->id }}

<x-mail::button :url="$url">
View Order
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
