@component('mail::message')
# Low Stock Alert

The following products are running low in stock:

@foreach($products as $product)
- **{{ $product->product_name }}** — Quantity: {{ $product->stock_quantity }} (ID: {{ $product->id }})
@endforeach

Please restock as soon as possible.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
