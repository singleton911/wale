<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Whales Market | {{ $name }} > {{ $action }}</title>
    <link rel="stylesheet" href="{{ asset('market.white.css') }}">
    <link rel="stylesheet" href="{{ asset('filter.css') }}">
</head>

<body>
    @include('User.navebar')

    <div class="container">
        <div class="main-div">
            <h3 style="text-align:center;">Reviews > <a
                    href="/listing/{{ $product->created_at->timestamp }}/{{ $product->id }}">{{ $product->product_name }}</a>
            </h3>
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
                @forelse ($product->reviews()->paginate(100) as $review)
                    <div class="displayed-reviews">
                        <div class="reviewer-info">
                            <img src="data:image/png;base64,{{ $icon['user'] }}" class="icon-filter" width="25">
                            <p><span>{{ substr($review->user->public_name, 0, 1) . str_repeat('*', max(strlen($review->user->public_name) - 2, 0)) . substr($review->user->public_name, -1) }}</span>
                            </p>
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
                                <p style='color: #4682B4; text-align: right;'> Last Updated:
                                    {{ $review->updated_at->format('d/m/y') }}</p>
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Display here store replies --}}
                    @if ($review->reply && $review->reply->count() > 0)
                        <div class="displayed-reviews" style="margin-left: 1em; border: 2px solid #4682B4;">
                            <div class="reviewer-info">
                                <img src="data:image/png;base64,{{ $icon['reply'] }}" class="icon-filter"
                                    width="25">
                                <p><span>{{ $product->store->store_name }}</span>
                                </p>
                            </div>
                            <div class="reviewer-reviews">
                                <div class="reviews-rating">
                                    <div>
                                        <span>{{ $review->created_at->format('d/m/y') }}</span><br>
                                        <span>Store Reply</span>
                                    </div>
                                </div>
                                <div class="rating-texts">
                                    <p style="margin-top: 5px;"> {{ $review->reply->reply }} <br>
                                    <form action="" method="post" style="margin:0px; padding:0px;">
                                        <p style='color: #4682B4; text-align: right; margin:0px; margin-top:12px;'>

                                            Last Updated: {{ $review->reply->updated_at->format('d/m/y') }}
                                        </p>
                                    </form>
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif
                @empty
                    <p>No review found for this product, buy this product to leave a review!</p>
                @endforelse
            </div>
        </div>
    </div>

    @include('User.footer')
</body>

</html>
