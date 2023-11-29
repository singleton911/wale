<div class="cart-div">
    {{ session('test') }}
    <div class="notific-container">
        <h1 class="notifications-h1">Shopping Cart</h1>
        <p class="notifications-p">For any change made to the cart please try to update it, else changes will not
            take
            effect! <br>
            Please encrypt all your address or any note for your own security, we check if you note is not encrypted
            and we do it for you but still please do it your self which is <span style="background-color: yellow">highly
                recommended!!!</span>
        </p>
        <p>
            @if ($errors->any())
                <ul>
                    @foreach ($errors->all() as $error)
                        <li style="color:red;">{{ $error }}</li>
                    @endforeach
                </ul>
            @endif
        </p>
        <p style="color: green; text-align: center;">{{ session('success') }}</p>
        <p style="color: red; text-align: center;">{{ session('delete') }}</p>
        <table>
            <thead style="font-family: Helvetica, sans-serif;">
                <tr>
                    <th>--{ }--</th>
                    <th>Name</th>
                    <th>Quantity</th>
                    <th>Extra/Shipping</th>
                    <th>Price/Item</th>
                    <th>Discount</th>
                    <th>Note/Address</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody style="font-family: Helvetica, sans-serif;">
                @forelse ($user->carts as $cart)
                    <form action="/cart/{{ $cart->id }}" method="post">
                        @csrf
                        @method('patch')
                        <tr class="self-container">
                            <td>
                                <img src="data:image/png;base64,{{ $icon['osint'] }}" width="70">
                            </td>
                            <input type="hidden" name="user_id" value="{{ $cart->user_id }}">
                            <input type="hidden" name="cart_id" value="{{ $cart->id }}">
                            <input type="hidden" name="product_id" value="{{ $cart->product_id }}">
                            <td><a
                                    href="/Item/{{ strtotime($cart->product->created_at) }}">{{ Str::limit($cart->product->product_name, 20, '...') }}</a>
                            </td>
                            <td><input type="number" name="quantity" id="" min="1"
                                    value="{{ $cart->quantity }}"></td>
                            <td>+{{ $cart->extraShipping->cost ?? '$0.00' }}</td>
                            <td>${{ $cart->product->price }}</td>
                            <th>
                                @php
                                    $discount = $user->usedPromocodes->where('cart_id', $cart->id)->first();
                                @endphp

                                @if ($discount != null && $discount->promocode->code_type == 'fixed')
                                    {{ '-$' . round($discount->discount, 2) }}
                                @elseif ($discount != null && $discount->promocode->code_type == 'percentage')
                                    {{ '-' . $discount->discount . '%' }}
                                @else
                                    {{ '-$0.00' }}
                                @endif
                            </th>
                            <td>
                                <textarea name="note" id="" style="width:100%;"
                                    placeholder="Write here you note like: address or any note to send to this product owner." rows="2">{{ $cart->note != null ? $cart->note : '' }}</textarea>
                            </td>
                            <td>
                                <input type="submit" name="remove" value="❌"
                                    style="cursor: pointer; padding: 3px; border: none; background-color: darkred; color:#f1f1f1; font-size: 1rem; border-radius: .3rem; margin-bottom:10px;">
                                <input type="submit" name="update" value="✔️"
                                    style="cursor: pointer; padding: 3px; border: none; background-color: darkgreen; color:#f1f1f1; font-size: 1rem; border-radius: .3rem;">
                            </td>
                        </tr>
                    </form>
                @empty

                    <tr>
                        <td colspan="5">
                            <p class="no-notification">Cart is empty.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="left-side-div">
        <div class="notific-container">
            <h1 class="notifications-h1">Cart Summary</h1>
            <table style=" font-family: Helvetica, sans-serif;">
                <tbody>
                    <tr style="font-size: 0.8rem;">
                        <td><strong>Sub Total: </strong></td>
                        @php
                            $total = 0;
                        @endphp

                        @foreach ($user->carts as $cart)
                            @if ($cart->product)
                                @php
                                    $total += $cart->product->price * $cart->quantity;
                                @endphp
                            @endif
                        @endforeach

                        <td>${{ round($total, 2) }}</td>
                    </tr>
                    <tr style="font-size: 0.8rem;">
                        <td><strong>Extra/Shipping Fees: </strong></td>
                        <td>${{ $user->carts->sum('extraShipping.cost') }}</td>
                    </tr>
                    <tr style="font-size: 0.8rem;">
                        {{-- @php
                            $discount_total = $user->usedPromocodes->where('cart_id', $cart->id)->first();
                        @endphp
                        @foreach ($discount_total->count as $discount)
                            @if ($discount)
                                @php
                                    $discount_total += $discount;
                                @endphp
                            @endif
                        @endforeach --}}
                        <td><strong>Discounts: </strong></td>
                        <td>${{ $discount_total = 0 }}</td>
                    </tr>
                    <tr style="font-size: 0.8rem;">
                        <td><strong>Total Cost USD: </strong></td>
                        <td>${{ $user->carts->sum('extraShipping.cost') + $total }}</td>
                    </tr>
                    <tr style="font-size: 0.8rem;">
                        <td><strong>Total Cost Monro: </strong></td>
                        <td>0.00000 XMR</td>
                    </tr>
                </tbody>
            </table>
            <hr>
            <form action="/apply/promocode" method="post">
                @if (session('validPromo'))
                    <p style="color:green">{{ session('validPromo') }}</p>
                @endif
                @if (session('emptycart'))
                    <p style="color:red">{{ session('emptycart') }}</p>
                @endif
                @if (session('alreadyused'))
                    <p style="color:red">{{ session('alreadyused') }}</p>
                @endif
                @if (session('invalidPromo'))
                    <p style="color:red">{{ session('invalidPromo') }}</p>
                @endif
                @csrf

                <div class="coupon-code" style="margin: 2em;">
                    <input type="text" name="promocode" placeholder="Enter code: " pattern="[A-Za-z0-9]+"
                        class="apply_now_copons_text" style="margin-bottom: 2em;">
                    <input type="submit" name="action" class="apply_now_copons_btn" value="Apply Now">
                </div>
                <div class="proceed-now">
                    <img src="data:image/png;base64,{{ $icon['xmr'] }}" width="20">
                    <input type="submit" name="checkout_cart" value="CheckOut Cart">
                </div>
            </form>
        </div>
    </div>
</div>
