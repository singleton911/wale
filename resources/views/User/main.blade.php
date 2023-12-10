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
            <div style="display: flex; gap:1em;">
                @include('User.categories')

                <div class="news-div">
                        <h2 class="news-title" style="text-decoration: underline"><img src="data:image/png;base64,{{ $icon['news'] }}"
                            class="icon-filter" width="25"> {{ $news->title }} <img src="data:image/png;base64,{{ $icon['news'] }}"
                            class="icon-filter" width="25"></h2>
                        <p class="news-content">{{ Str::limit($news->content, 150, '...') }} </p>
                        <div style="text-align:right; margin-right:5px; font-size: .8rem; color: #acacac;">
                            <a href="/news/"
                                style="font-size: .8rem; margin-right:1em; text-decoration:underline">Clcik
                                here to real full news</a>
                            Author:
                            <span
                                class="{{ $news->user->role }}">/{{ $news->user->role }}/{{ $news->user->public_name }}</span>
                            <span>Date: {{ $news->created_at->diffForHumans() }}</span>
                        </div>
                </div>

            </div>
            <div class="search-div">
                <h3>Quick Search Listings</h3>
                <form action="/search" method="post" class="search-form">
                    {{-- @csrf --}}
                    <input type="text" class="search_name" name="pn"
                        placeholder="Quick search (product.., store...)" value="">
                    <div class="price-range">
                        Price:
                        <input type="number" name="pf" min="1" placeholder="min $0.0" id="price-input"
                            value="">
                        <input type="number" name="pt" min="1" placeholder="max $0.0" id="price-input"
                            value="">
                    </div>
                    <div style="display: flex; gap:1em">
                        <select name="search_type">
                            <option value="product">Search Products</option>
                            <option value="store">Search Stores</option>
                        </select>

                    </div>
                    <div style="display: flex; gap:1em">
                        <select name="filter-product" id="">
                            <option value="">---Sort By---</option>
                            <option value="best-match">Best Match</option>
                            <option value="newest">Newest listed</option>
                            <option value="oldest">Oldest listed</option>
                            <option value="Cheapest">price + Shipping: lowest first</option>
                            <option value="highest">Price + Shipping: highest first</option>
                        </select>
                        <select name="category" id="">
                            <option value="">---Select category---</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>

                        <div class="product-type">
                            Product type:
                            <label><input type="radio" name="pt2" value="all">All</label>
                            <label><input type="radio" name="pt2" value="digital">Digital</label>
                            <label><input type="radio" name="pt2" value="physical">Physical</label>
                        </div>
                        <button type="submit" name="search-button" class="search-button">Search</button>
                    </div>
                    <div style="max-width: 50%; text-align:right">
                        <button type="submit" name="advance-search-disp" class="search-button">Advance
                            Search</button>
                    </div>
                </form>
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

        <div class="listing-name">
            <h3 style="color: #f5a623;">Sticky Listings</h3>
        </div>

        <div class="products-grid">
            <p style="padding:0px; margin:0px;">No sticky listing yet...</p>
        </div>


        <div class="listing-name">
            <h3 style="color: #3498db;">
                @if ($is_parent_category)
                    {{ 'Category > ' . $categoryName }}
                @elseif($is_sub_category)
                    {{ 'Category > ' . $categoryName }}
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
