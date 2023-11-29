<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Whales Market | Listing > {{ $product->product_name }}</title>
    <link rel="stylesheet" href="{{ asset('market.white.css') }}">
    <link rel="stylesheet" href="{{ asset('filter.css') }}">
</head>

<body>
    @include('User.navebar')

    <div class="container">
        <div class="main-div">
            <div class="dir">
                <div class="dir-div">
                    <a href="/">Go Back</a>
                </div>
                <div class="prices-div">
                    <span>BTC/USD: <span class="usd">0</span></span>
                    <span>XMR/USD: <span class="usd">0</span></span>
                </div>
            </div>
            <div>
                @if (session('error'))
                    <p style="padding: 10px; margin: 10px; border-radius: .5rem; background-color: #dc3545">
                        {{ session('error') }}
                    </p>
                @elseif (session('success'))
                    <p style="padding: 10px; margin: 10px; border-radius: .5rem; background-color:#28a745">
                        {{ session('success') }}
                    </p>
                @endif
                @if ($errors->any)
                    @foreach ($errors->all() as $error)
                        <p style="padding: 10px; margin: 10px; border-radius: .5rem; background-color: #dc3545">
                            {{ $error }}
                        </p>
                    @endforeach
                @endif
            </div>
            <div class="products-overview">
                <form action="" method="post">
                    @csrf
                    <h2>{{ $product->product_name }}</h2>
                    <hr>
                    <div class="desc-photo">
                        <div class="photo">
                            <div class="main-pic">
                                <img src="data:image/png;base64,{{ $icon['osint'] }}">
                            </div>
                            <div class="sub-pics">
                                <img src="data:image/png;base64,{{ $icon['osint'] }}">
                                <img src="data:image/png;base64,{{ $icon['osint'] }}">
                                <img src="data:image/png;base64,{{ $icon['osint'] }}">
                            </div>
                            <div class="desc-others">
                                <div class="description">
                                    <h3>DESCRIPTIONS</h3>
                                    <p class="contents">{{ $product->product_description }}</p>
                                </div>
                                @if ($product->return_policy != null)
                                    <div class="refund-policy">
                                        <h3>Store Refund Policy</h3>
                                        <p>{{ $product->return_policy }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="main-store-div" style="margin: 1px;">
                            <div class="info-overvew">
                                @if (session('enter_adderss'))
                                    <h3>Store Public PGP Key</h3>
                                    <div class="main-store-div" style="margin: 1px;">
                                        <div>
                                            <p>
                                                <textarea name="" id="" cols="30" rows="10">{{ $product->store->store_key }}</textarea>
                                            </p>
                                        </div>
                                    </div>
                                @else
                                    <h3>Store Informatain</h3>
                                    @foreach ($user->favoriteStores as $favoriteStore)
                                        @if ($favoriteStore->store_id === $product->store_id)
                                            <p style="color: green; margin: 0; font-weight: lighter;">This store is one
                                                of
                                                your favorite store!</p>
                                        @endif
                                    @endforeach
                                    <div class="main-store-div" style="margin: 1px;">
                                        <div class="s-main-image">
                                            <img src="data:image/png;base64,{{ $icon['osint'] }}">
                                            <div>
                                                <div class="div-p">
                                                    <p class="store-name">{{ $product->store->store_name }}<span
                                                            style="font-size: .5em;">Store</span></p>
                                                    <p class="span3"
                                                        style="border: 2px solid skyblue; border-radius:.5rem; padding:5px;">
                                                        @php
                                                            $weightedAverage = \App\Models\Review::claculateStoreRating($product->store_id);
                                                        @endphp
                                                        {{ $weightedAverage != 0 ? $weightedAverage : '5.0' }}⭐</p>
                                                </div>
                                                <div style="margin-top: 0; display:flex; justify-content:space-around">

                                                    <span>S I N C E</span>
                                                    <span>{{ $product->store->created_at->format('d F, Y') }}</span>
                                                </div>
                                                <div class="div-p">
                                                    <p>Status: <span
                                                            class="{{ $product->store->status }}">{{ $product->store->status }}</span>
                                                    </p> |
                                                    <p>Sales: {{ $product->store->width_sales }}</p>
                                                </div>
                                                <div class="div-p">
                                                    <p>Disputes: [<span style="color: #28a745;">Won
                                                            ({{ $product->store->disputes_won }})</span>/<span
                                                            style="color:#dc3545;">Lost
                                                            ({{ $product->store->disputes_lost }})</span>]</p>
                                                </div>
                                                <div class="div-p">
                                                    <p>Listings: {{ $product->store->products->count() }}</p> |
                                                    <p>Favorited: {{ $product->store->favoriteStores->count() }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="div-p" style="display: flex; gap: 1.3em; justify-content:center;">
                                            <a href="/store/message/{{ $product->store->store_name }}/{{ $product->store->id }}"
                                                class="input-listing"> Message</a>
                                            <a href="/store/{{ $product->store->store_name }}/{{ $product->store->id }}"
                                                class="input-listing">See
                                                Store</a>
                                            @if ($user->favoriteStores->count() > 0)
                                                @php $storeFavorited = false; @endphp
                                                @foreach ($user->favoriteStores as $favoriteStore)
                                                    @if ($favoriteStore->store_id === $product->store_id)
                                                        <a href="/favorite/f_store" class="input-listing">
                                                            UnFavorite</a>
                                                        @php $storeFavorited = true; @endphp
                                                    @endif
                                                @endforeach

                                                @if (!$storeFavorited)
                                                    <input type="submit" name="favorite_store" class="input-listing"
                                                        value="Favorite Store">
                                                @endif
                                            @else
                                                <input type="submit" name="favorite_store" class="input-listing"
                                                    value="Favorite Store">
                                            @endif
                                            <input type="submit" name="block_store" value="Block Store"
                                                class="input-listing">
                                            <a href="/store/report/{{ $product->store->store_name }}/{{ $product->store->id }}"
                                                class="input-listing"> Report</a>

                                        </div>
                                    </div>


                                    <h3>Listing Informatain</h3>
                                    @foreach ($user->favoriteListings as $favoriteListing)
                                        @if ($favoriteListing->product_id === $product->id)
                                            <p style="color: green; margin: 0; font-weight: lighter;">This listing has
                                                been
                                                favorited by you!</p>
                                        @endif
                                    @endforeach
                                    <div class="main-store-div" style="margin: 1px;">
                                        <p class="cls3" style="text-decoration: underline">Sold <span>
                                                {{ $product->sold }}</span> <span>
                                                Since {{ $product->created_at->format('d F, Y') }}</span>
                                        <div class="div-p">
                                            <p>Product Type: <span
                                                    style="color: #28a745">{{ $product->product_type }}</span>
                                            </p>
                                            <p>In Stocks: <span style="color: #28a745">{{ $product->in_stocks }}</span>
                                            </p>
                                        </div>
                                        <div class="div-p">
                                            <p>Ship From: <span style="color: #28a745">{{ $product->ship_from }}</span>
                                            </p>
                                            <p>Ships To: <span style="color: #28a745">{{ $product->ship_to }}</span>
                                            </p>
                                        </div>
                                        <div class="div-p">
                                            <p>Payment Type: <span
                                                    class="{{ $product->payment_type }}">{{ '{' . $product->payment_type . '}' }}</span>
                                            </p>
                                            <p>Disputes: [<span style="color: #28a745;">Won
                                                    ({{ $product->disputes_won }})</span>/<span
                                                    style="color:#dc3545;">Lost
                                                    ({{ $product->disputes_lost }})</span>]</p>
                                        </div>
                                        <div class="div-p" style="display: flex; gap: 1.3em; justify-content:center;">
                                            @if ($user->favoriteListings->count() > 0)
                                                @php $listingFavorited = false; @endphp
                                                @foreach ($user->favoriteListings as $favoriteListing)
                                                    @if ($favoriteListing->product_id === $product->id)
                                                        <a href="/favorite/f_listing" class="input-listing">
                                                            UnFavorite
                                                            Listing</a>
                                                        @php $listingFavorited = true; @endphp
                                                    @endif
                                                @endforeach
                                                @if (!$listingFavorited)
                                                    <input type="submit" name="favorite_listing"
                                                        class="input-listing" value="Favorite Listing">
                                                @endif
                                            @else
                                                <input type="submit" name="favorite_listing" class="input-listing"
                                                    value="Favorite Listing">
                                            @endif
                                            <a href="/listing/report/{{ $product->created_at->timestamp }}/{{ $product->id }}"
                                                class="input-listing"> Report Listing</a>
                                        </div>
                                    </div>
                                @endif
                                <p></p>
                                @if (session('enter_adderss'))
                                    <div>
                                        <p
                                            style="font-family: Arial, sans-serif; font-size: 18px; color: #333; line-height: 1.5; margin-bottom: 10px;">
                                            <span
                                                style="background-color: darkred; padding: 2px; color: #f1f1f1; margin-right: 5px;">
                                                NOTE: </span> <span>Encrypt all address or any sensitive data yourself,
                                                We
                                                will encrypt everything if you have not encrypted it after submition.
                                                You
                                                can encrypt your address using the store public PGP key.
                                                You can find the store public PGP key above, which will allow them to
                                                decrypt your address. Rest assured that the store will delete your
                                                address
                                                or any sensitive data after viewing it. </span>
                                        </p>
                                        <p>
                                            <textarea name="address_text" class="support-msg"
                                                placeholder="Write or paste your note here (if you have any) like: address or any note to send to this product owner."
                                                id="" cols="30" rows="10"></textarea>
                                        </p>
                                        <input type="hidden" name="extra_shipping_option"
                                            value="{{ session('extra_shipping_option') }}">
                                        <input type="hidden" name="items" value="{{ session('items') }}">
                                        <div
                                            style="display: flex; gap: 2em; justify-content:center; margin-bottom: 15px;">
                                            <div class="main-store-div" style="margin: 1px;">
                                                <div class="buy-now-cart" title="complete order now">
                                                    <input type="submit" name="complete_order" value="Done">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div>
                                        <div class="extra">
                                            <p>Extra/Shipping Options</p>
                                            <select name="extra_shipping_option" id="extra-shipping-option">
                                                @if ($product->extraShipping->count() > 0)
                                                    @forelse ($product->extraShipping as $extraShipping)
                                                        <option value="{{ $extraShipping->id }}">
                                                            {{ $extraShipping->name }}
                                                            -
                                                            USD + {{ $extraShipping->cost }} / order</option>
                                                    @empty
                                                        <option value="1"> Default - USD + 0.00 / order</option>
                                                    @endforelse
                                                @else
                                                    <option value="1"> Default - USD + 0.00 / order</option>
                                                @endif
                                            </select>
                                        </div>
                                        <div class="price" style="margin-bottom: 10px">
                                            <h3>Price: ${{ $product->price }}</h3>
                                            <h3 style="margin: 10px"> <img
                                                    src="data:image/png;base64,{{ $icon['xmr'] }}" width="25">
                                                0.000 XMR
                                            </h3>
                                            @if ($product->product_type === 'digital')
                                                @if ($product->auto_delivery_content != null or $product->auto_delivery_content != '')
                                                    <h3
                                                        style="background-color: darkgoldenrod; color:#f1f1f1; border-radius: .3rem; margin-top: 0;">
                                                        AutoShop: Yes</h3>
                                                @else
                                                    <h3
                                                        style="background-color: darkgoldenrod; color:#f1f1f1; border-radius: .3rem; margin-top: 0;">
                                                        AutoShop: No</h3>
                                                @endif
                                            @endif
                                        </div>
                                        <div class="price" style="margin-bottom: 10px">
                                            <input type="number" name="items" min="1" pattern="[0-9]+"
                                                value="1">
                                        </div>
                                        <div
                                            style="display: flex; gap: 2em; justify-content:center; margin-bottom: 15px;">
                                            <div class="buy-now-cart" title="add this item in cart">
                                                <input type="submit" name="add_to_cart" value="Add to cart">
                                            </div>
                                            <div class="buy-now">
                                                <img style="width: 20px; height: 20px;" src="/public/site-img/xmr.png"
                                                    alt="" srcset="">
                                                <input type="submit" name="buy_now" value="BUY NOW">
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="main-div">
                <h3>Reviews</h3>
                <div class="products-overview">
                    <div style="display: flex; gap: 2em;" class="reviews">
                        <table style="border: 1px solid gray;">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th>1 Month</th>
                                    <th>6 Months</th>
                                    <th>12 Months</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="font-size: 1.3rem; text-align:center;">➕</td>
                                    <td style="font-weight: bold; font-size:1.2rem; color:inherit;">Positive</td>
                                    <td>{{ $product->reviews->where('feedback', 'positive')->whereBetween('created_at', [now()->subMonth(), now()])->count() }}
                                    </td>
                                    <td>{{ $product->reviews->where('feedback', 'positive')->whereBetween('created_at', [now()->subMonths(6), now()])->count() }}
                                    </td>
                                    <td>{{ $product->reviews->where('feedback', 'positive')->whereBetween('created_at', [now()->subYear(), now()])->count() }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="font-size: 1.3rem; text-align:center;">⏹️</td>
                                    <td style="font-weight: bold; font-size:1.2rem; color:inherit;">Neutral</td>
                                    <td>{{ $product->reviews->where('feedback', 'neutral')->whereBetween('created_at', [now()->subMonth(), now()])->count() }}
                                    </td>
                                    <td>{{ $product->reviews->where('feedback', 'neutral')->whereBetween('created_at', [now()->subMonths(6), now()])->count() }}
                                    </td>
                                    <td>{{ $product->reviews->where('feedback', 'neutral')->whereBetween('created_at', [now()->subYear(), now()])->count() }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="font-size: 1.3rem; text-align:center;">⛔</td>
                                    <td style="font-weight: bold; font-size:1.2rem; color:inherit;">Negative</td>
                                    <td>{{ $product->reviews->where('feedback', 'negative')->whereBetween('created_at', [now()->subMonth(), now()])->count() }}
                                    </td>
                                    <td>{{ $product->reviews->where('feedback', 'negative')->whereBetween('created_at', [now()->subMonths(6), now()])->count() }}
                                    </td>
                                    <td>{{ $product->reviews->where('feedback', 'negative')->whereBetween('created_at', [now()->subYear(), now()])->count() }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <table style="border: 1px solid gray;">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Rating</th>
                                    <th>Based on Rating</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $categories = [
                                        'Price' => 'price_rating',
                                        'Product' => 'product_rating',
                                        'Shipping Speed' => 'shipping_speed_rating',
                                        'Communication' => 'communication_rating',
                                    ];
                                @endphp

                                @foreach ($categories as $categoryName => $columnName)
                                    @php
                                        // Calculate the average rating for the current category
                                        $averageRating = $product->reviews->avg($columnName);

                                        // Check if the average rating is not null before rounding
                                        $roundedRating = !is_null($averageRating) ? round($averageRating, 2) : null;
                                    @endphp

                                    <tr>
                                        <td style="font-weight: bold; font-size:1.2rem; color:inherit;">
                                            {{ $categoryName }}</td>
                                        <td>{{ $roundedRating ?? 'N/A' }} ⭐</td>
                                        <td>({{ $product->reviews->count() }})</td>
                                    </tr>
                                @endforeach
                            </tbody>

                        </table>
                    </div>
                    <h3 style="text-transform: capitalize; text-align: center;">
                        <span style="color:#28a745">
                            Listing's Reviews
                        </span>
                        <hr>
                    </h3>
                    @forelse ($product->reviews()->paginate(1) as $review)
                        <div class="displayed-reviews">
                            <div class="reviewer-info">
                                <img src="data:image/png;base64,{{ $icon['user'] }}" class="icon-filter"
                                    width="25">
                                <p><span>{{ $review->user->public_name }}</span></p>
                            </div>
                            <div class="reviewer-reviews">
                                <div class="reviews-rating">
                                    <div>
                                        <span>{{ $review->created_at->format('d/m/y') }}</span>
                                    </div>
                                    <div class="three" style="margin-top: .4em">
                                        @if ($review->feedback === 'positive')
                                            <span class="pstv">Positive</span>
                                        @elseif ($review->feedback === 'neutral')
                                            <span class="ntrl">Neutral</span>
                                        @elseif ($review->feedback === 'negative')
                                            <span class="ngtv">Negative</span>
                                        @endif

                                    </div>
                                </div>
                                <div class="rating-texts">
                                    <p style="margin-top: 5px;"> {{ $review->comment }} <br>
                                    <p style='color: #4682B4; text-align: right;'> Date:
                                        {{ $review->created_at->format('d/m/y') }}</p>
                                    </p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p>No review found for this product, buy this product to leave a review!</p>
                    @endforelse
                </div>
            </div>

            {{-- {{ $product->reviews->links('vendor.pagination.custom_pagination') }} --}}
        </div>
    </div>

    @include('User.footer')
</body>

</html>
