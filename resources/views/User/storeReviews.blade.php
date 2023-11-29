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
            <div class="notific-container">
                <h3 style="text-transform: capitalize; text-align: center;">
                    <span style="color:#28a745">
                       {{ $store->store_name }} > Listing's Reviews
                    </span>
                    <hr>
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
                                    <td>{{ $store->reviews->where('feedback', 'positive')->whereBetween('created_at', [now()->subMonth(), now()])->count() }}</td>
                                    <td>{{ $store->reviews->where('feedback', 'positive')->whereBetween('created_at', [now()->subMonths(6), now()])->count() }}</td>
                                    <td>{{ $store->reviews->where('feedback', 'positive')->whereBetween('created_at', [now()->subYear(), now()])->count() }}</td>
                                </tr>
                                <tr>
                                    <td style="font-size: 1.3rem; text-align:center;">⏹️</td>
                                    <td style="font-weight: bold; font-size:1.2rem; color:inherit;">Neutral</td>
                                    <td>{{ $store->reviews->where('feedback', 'neutral')->whereBetween('created_at', [now()->subMonth(), now()])->count() }}</td>
                                    <td>{{ $store->reviews->where('feedback', 'neutral')->whereBetween('created_at', [now()->subMonths(6), now()])->count() }}</td>
                                    <td>{{ $store->reviews->where('feedback', 'neutral')->whereBetween('created_at', [now()->subYear(), now()])->count() }}</td>
                                </tr>
                                <tr>
                                    <td style="font-size: 1.3rem; text-align:center;">⛔</td>
                                    <td style="font-weight: bold; font-size:1.2rem; color:inherit;">Negative</td>
                                    <td>{{ $store->reviews->where('feedback', 'negative')->whereBetween('created_at', [now()->subMonth(), now()])->count() }}</td>
                                    <td>{{ $store->reviews->where('feedback', 'negative')->whereBetween('created_at', [now()->subMonths(6), now()])->count() }}</td>
                                    <td>{{ $store->reviews->where('feedback', 'negative')->whereBetween('created_at', [now()->subYear(), now()])->count() }}</td>
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
                                        $averageRating = $store->reviews->avg($columnName);

                                        // Check if the average rating is not null before rounding
                                        $roundedRating = !is_null($averageRating) ? round($averageRating, 2) : null;
                                    @endphp

                                    <tr>
                                        <td style="font-weight: bold; font-size:1.2rem; color:inherit;">
                                            {{ $categoryName }}</td>
                                        <td>{{ $roundedRating ?? 'N/A' }} ⭐</td>
                                        <td>({{ $store->reviews->count() }})</td>
                                    </tr>
                                @endforeach
                            </tbody>

                        </table>
                    </div>
                    @forelse ($store->reviews()->paginate(50) as $review)
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
                                    <a href="/listing/{{ $review->product->created_at->timestamp }}/{{ $review->product->id }}">{{ $review->product->product_name }}</a>
                                    <p style="margin-top: 5px;"> {{ $review->comment }} <br>
                                    <p style='color: #4682B4; text-align: right;'>
                                        Price: ${{ $review->product->price }} 
                                        Date: {{ $review->created_at->format('d/m/y') }}</p>
                                    </p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p>No review found for this store, come back later and check!</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    @include('User.footer')
</body>

</html>
