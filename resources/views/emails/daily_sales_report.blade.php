@component('mail::message')
# Daily Sales Report

@foreach($orders as $order)
**Order #{{ $order->order_number }}**  
Total: {{ config('constants.currency_symbol') }} {{ $order->order_total }}

| Product | Quantity | Line Total |
|---------|---------|-----------|
@foreach($order->items as $item)
| {{ $item->product->product_name }} | {{ $item->quantity }} | {{ config('constants.currency_symbol') }} {{ $item->line_total }} |
@endforeach

---

@endforeach

Thanks,<br>
{{ config('app.name') }}
@endcomponent
