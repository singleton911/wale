<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Whales Market | {{ $user->public_name }} > {{ $name }} > {{ $action }}</title>
    @if ($user->theme == 'dark')
    <link rel="stylesheet" href="{{ asset('dark.theme.css') }}">
@else
    <link rel="stylesheet" href="{{ asset('white.theme.css') }}">
@endif
<link rel="stylesheet" href="{{ asset('market.white.css') }}">
<meta http-equiv="refresh" content="{{ session('session_timer') }};url=/kick/{{ $user->public_name }}/out">

    <link rel="stylesheet" href="{{ asset('filter.css') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
</head>

<body>
    @include('User.navebar')

    <div class="container">
        <div class="main-div">
            <div class="dir">
                <div class="dir-div">
                    <a href="{{ url()->current() }}" style="font-size:.8rem;">/</a> }}---
                    <span style="color: darkgreen; font-size:.8rem;">Your login phrase is
                        `{{ $user->login_passphrase }}`</span>
                </div>
                <div class="prices-div">
                    <span>BTC/USD: <span class="usd">$0.00</span></span>
                    <span>XMR/USD: <span class="usd">$0.00</span></span>
                </div>

            </div>
            <div class="top-div">
                @include('User.categories')
                <div>


                    <div class="categories search-div">
                        @if (session('advance_search'))
                            <h3>Advance Search Listings/Stores ℹ️<br>

                            </h3>
                        @else
                            <h3>Quick Search Listings
                                <form action="/search" method="get" class="search-form" style="padding: .5em;">
                                    @csrf
                                    <button type="submit" name="advance-search" style="margin:0px;"
                                        class="search-button">Go Advance
                                        Search</button>
                                </form>
                            </h3>
                        @endif

                        <form action="/search" method="get" class="search-form">
                            @csrf
                            <input type="text" class="search_name" name="pn"
                                placeholder="Quick search with product name..." value="">
                            <div class="price-range">
                                Price:
                                <input type="number" name="pf" min="0" placeholder="min $0.0"
                                    id="price-input" value="">
                                <input type="number" name="pt" min="0" placeholder="max $0.0"
                                    id="price-input" value="">
                            </div>
                            @if (session('advance_search'))
                                {{-- <p>NOTE: search store mean getting only the store and it products (only enter the store name)!</p> --}}
                                <div class="price-range">
                                    Location:
                                    <input type="text" name="sf" placeholder="Ship from...." id="price-input"
                                        value="">
                                    <input type="text" name="st" placeholder="Ship to..." id="price-input"
                                        value="">
                                </div>
                                <div>
                                    AutoShop:
                                    <input type="checkbox" name="auto_shop" id="price-input">
                                    <label>Search include descriptions: <input type="checkbox" name="desc"></label>
                                </div>
                                <div style="display: flex; gap:1em">
                                    <select name="search_type">
                                        <option value="product">Search Products</option>
                                        <option value="store">Search Stores</option>
                                    </select>
                                    <select name="filter-product" id="">
                                        <option value="">---Sort By---</option>
                                        <option value="best-match">Best Match</option>
                                        <option value="newest">Newest listed</option>
                                        <option value="oldest">Oldest listed</option>
                                        <option value="Cheapest">price + Shipping: lowest first</option>
                                        <option value="highest">Price + Shipping: highest first</option>
                                    </select>
                                </div>
                                <div style="display: flex; gap:1em;">
                                    <select name="parent_category" id="">
                                        <option value="">---Select Parent Category---</option>
                                        @foreach ($categories->where('parent_category_id', null) as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    <select name="sub_category" id="">
                                        <option value="">---Select Sub Category---</option>
                                        @foreach ($categories->where('parent_category_id', '!=', null) as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div style="display: flex; gap:1em">
                                    <select name="payment_type">
                                        <option value="">---Payment System---</option>
                                        <option value="Escrow">Escrow</option>
                                        <option value="FE">Finalize Early</option>
                                    </select>
                                </div>
                            @else
                                <input type="hidden" name="search_type" value="product">
                                <select name="filter-product" id="">
                                    <option value="">---Sort By---</option>
                                    <option value="best-match">Best Match</option>
                                    <option value="newest">Newest listed</option>
                                    <option value="oldest">Oldest listed</option>
                                    <option value="Cheapest">price + Shipping: lowest first</option>
                                    <option value="highest">Price + Shipping: highest first</option>
                                </select>
                            @endif
                            <div style="display: flex; gap:1em">
                                <div class="product-type">
                                    Product type:
                                    <label><input type="radio" name="pt2" value="all" checked>All</label>
                                    <label><input type="radio" name="pt2" value="digital">Digital</label>
                                    <label><input type="radio" name="pt2" value="physical">Physical</label>
                                </div>
                                <button type="submit" class="search-button">Search</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @if ($user->twofa_enable === 'no')
                <div>
                    <p
                        style="background-color: rgb(255, 239, 238); padding: 8px; border: 1px solid rgb(90, 8, 1); margin-bottom: 16px; box-sizing: border-box; border-radius: 5px; color: rgb(90, 8, 1); font-family:Verdana, Geneva, Tahoma, sans-serif;">
                        Two-Factor Authentication is Disabled, add your public pgp key that match your public name and
                        check
                        the
                        `enable 2FA box` to enable 2FA!</p>
                </div>
            @endif

            {{-- <div class="listing-name">
                <h3 style="color: #f5a623;">Sticky Listings</h3>
            </div>

            <div class="products-grid">
                <p style="padding:0px; margin:0px;">No sticky listing yet...</p>
            </div> --}}


            <div class="listing-name">
                <h3 style="color: #3498db;">
                    @if ($is_parent_category)
                        {{ 'Parent > Category > ' . $categoryName }}
                    @elseif($is_sub_category)
                        {{ 'Sub > Category > ' . $categoryName }}
                    @else
                        Random > Listings
                    @endif
                </h3>
            </div>

            <div class="products-grid">
                @forelse ($products as $product)
                    @include('User.products')
                @empty
                    No product found.
                @endforelse
            </div>

            {{ $products->links('vendor.pagination.custom_pagination') }}

        </div>
    </div>
    @include('User.footer')
</body>

</html>
