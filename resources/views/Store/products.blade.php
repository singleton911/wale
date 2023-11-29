<div style="text-align: center;">
    <a href="/store/{{ $store->store_name }}/add-listings"
        style="background-color: #0b3996; padding: 5px; text-decoration: none; color: white; border-radius: 5px;">+ add
        listing</a><br><br>
</div>
<div class="products-grid">
    @if (!empty($store->products))
        @include('Store.product')
    @else
      <P>Your have no product listed yet. -_-</P>
    @endif
</div>
