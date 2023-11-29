
<div>
    <div class="pname">
        <p>{{$product->product_name }}</p>
    </div>
    <div class="image">
        <img src="data:image/png;base64,{{ $icon['osint'] }}">
    </div>
    <div class="cat-sub">
        <p class="{{ $product->payment_type }}">{{ '{'. $product->payment_type .'}' }}</p>
        <p class="parent-catg">{{ $product->parentCategory->name }}</p>
        <p class="sub-catg">{{ $product->subCategory->name }}</p>
    </div>
    <div class="price" style="margin: 10px">
        <h3>Price: ${{ $product->price }}</h3>
    </div>
    @if ($product->product_type === 'digital')
    @if (($product->auto_delivery_content != NULL or $product->auto_delivery_content != ''))
    <h3 style="background-color: darkgoldenrod; color:#f1f1f1; border-radius: .3rem; margin-top: 0;">
        AutoShop: Yes</h3>
    @else
    <h3 style="background-color: darkgoldenrod; color:#f1f1f1; border-radius: .3rem; margin-top: 0;">
        AutoShop: No</h3>
    @endif
    @endif
    <div class="buttons">
        <div>
            <a href="/store/{{ $product->store->store_name }}/{{ $product->store_id }}">Store({{ $product->store->products->count() }})</a> |
            <a href="/listing/{{ $product->created_at->timestamp }}/{{ $product->id }}" style="background-color: green;">Buy Now</a> 
        </div>
    </div>
    <hr style="width: 100%; border-radius: 100%; !important">
    <div class="desc">
        <img src="data:image/png;base64,{{ $icon['osint'] }}"> |
        <span class="span1" title="In Stocks" style="display: flex; align-items: center;"><img src="data:image/png;base64,{{ $icon['inventory'] }}" class="icon-filter" width="15"> <span style="margin-left: .2em"> {{ $product->in_stocks }} |</span></span>
        <span class="span1" title="Sold" style="display: flex; align-items: center;"><img src="data:image/png;base64,{{ $icon['shopping-cart'] }}" class="icon-filter" width="15"> <span style="margin-left: .2em"> {{ $product->sold }} |</span></span>
        <span class="span3" style="border: 2px solid skyblue; border-radius:.5rem; padding:5px;">
            @php
            $weightedAverage = \App\Models\Review::claculateStoreRating($product->store_id);
            @endphp
            {{ $weightedAverage != 0 ? $weightedAverage : '5.0' }}⭐</span>
    </div>
</div>