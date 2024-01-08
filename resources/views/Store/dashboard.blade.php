<div class="latest-orders">
    @if (session('success'))
        <p style="color: green; text-align:center; margin:0px;">{{ session('success') }}</p>
    @endif
    <div class="title-latest">
        <h4>LATEST ORDERs</h4>
        <div class="view-latest">
            <a href="/store/{{ $store->store_name }}/show/orders">VIEW ALL</a>
        </div>
    </div>
    <div>
        <table>
            <thead>
                <tr>
                    <th>Listing</th>
                    <th>Buyer</th>
                    <th>No. Items</th>
                    <th>Last Updated</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($store->orders()->orderBy('updated_at', 'desc')->paginate(20) as  $order)
                    <tr>

                        <td>{{ Str::limit($order->product->product_name, 30, '...') }}</td>
                        <td>{{ $order->user->public_name }}</td>
                        <td>{{ $order->quantity }}</td>
                        <td>{{ $order->updated_at->diffForHumans() }}</td>
                        <td>{{ $order->product->product_type }}</td>
                        <td class="{{ $order->status }}">{{ $order->status }}</td>
                        <td>
                            <form action="/store/{{ $store->store_name }}/do" method="post">
                                @csrf
                                <input type="hidden" name="order_id" value="{{ Crypt::encrypt($order->id) }}">

                                @if ($order->status == 'pending')
                                    <a href="/store/{{ $store->store_name }}/show/order/{{ $order->created_at->timestamp }}/{{ $order->id }}"
                                        style="font-size: .7rem; background-color: rgb(0, 75, 128); color: #f1f1f1; cursor:pointer; padding: 5px; border: none; border-radius: .5rem;">View</a>
                                    <button type="submit"
                                        style="font-size: .7rem; background-color: darkgreen; color: #f1f1f1; cursor:pointer; padding: 5px; border: none; border-radius: .5rem;"
                                        name="accept">Accept</button>
                                    <button type="submit"
                                        style="font-size: .7rem; background-color: darkred; color: #f1f1f1; cursor:pointer; padding: 5px; border: none; border-radius: .5rem;"
                                        name="cancel">Cancel</button>
                                @elseif($order->status == 'processing' && $order->product->product_type == 'physical')
                                    <a href="/store/{{ $store->store_name }}/show/order/{{ $order->created_at->timestamp }}/{{ $order->id }}"
                                        style="font-size: .7rem; background-color: rgb(0, 75, 128); color: #f1f1f1; cursor:pointer; padding: 5px; border: none; border-radius: .5rem;">View</a>
                                    <button type="submit"
                                        style="font-size: .7rem; background-color: darkgreen; color: #f1f1f1; cursor:pointer; padding: 5px; border: none; border-radius: .5rem;"
                                        name="shipped">Shipped</button>
                                    <button type="submit"
                                        style="font-size: .7rem; background-color: darkorange; color: #f1f1f1; cursor:pointer; padding: 5px; border: none; border-radius: .5rem;"
                                        name="dispute">Dispute</button>
                                @elseif($order->status == 'processing' && $order->product->product_type == 'digital')
                                    <a href="/store/{{ $store->store_name }}/show/order/{{ $order->created_at->timestamp }}/{{ $order->id }}"
                                        style="font-size: .7rem; background-color: rgb(0, 75, 128); color: #f1f1f1; cursor:pointer; padding: 5px; border: none; border-radius: .5rem;">View</a>
                                    <button type="submit"
                                        style="font-size: .7rem; background-color: darkgreen; color: #f1f1f1; cursor:pointer; padding: 5px; border: none; border-radius: .5rem;"
                                        name="sent">Sent</button>
                                    <button type="submit"
                                        style="font-size: .7rem; background-color: darkorange; color: #f1f1f1; cursor:pointer; padding: 5px; border: none; border-radius: .5rem;"
                                        name="dispute">Dispute</button>
                                @elseif($order->status == 'shipped')
                                    <a href="/store/{{ $store->store_name }}/show/order/{{ $order->created_at->timestamp }}/{{ $order->id }}"
                                        style="font-size: .7rem; background-color: rgb(0, 75, 128); color: #f1f1f1; cursor:pointer; padding: 5px; border: none; border-radius: .5rem;">View</a>
                                    <button type="submit"
                                        style="font-size: .7rem; background-color: darkgreen; color: #f1f1f1; cursor:pointer; padding: 5px; border: none; border-radius: .5rem;"
                                        name="delivered">Delivered</button>
                                    <button type="submit"
                                        style="font-size: .7rem; background-color: darkorange; color: #f1f1f1; cursor:pointer; padding: 5px; border: none; border-radius: .5rem;"
                                        name="dispute">Dispute</button>
                                @elseif($order->status == 'sent' || $order->status == 'delivered' || $order->status == 'dispatched')
                                    <a href="/store/{{ $store->store_name }}/show/order/{{ $order->created_at->timestamp }}/{{ $order->id }}"
                                        style="font-size: .7rem; background-color: rgb(0, 75, 128); color: #f1f1f1; cursor:pointer; padding: 5px; border: none; border-radius: .5rem;">View</a>
                                    <button type="submit"
                                        style="font-size: .7rem; background-color: darkorange; color: #f1f1f1; cursor:pointer; padding: 5px; border: none; border-radius: .5rem;"
                                        name="dispute">Dispute</button>
                                @elseif($order->status == 'dispute')
                                <a href="/store/{{ $store->store_name }}/show/order/{{ $order->created_at->timestamp }}/{{ $order->id }}"
                                    style="font-size: .7rem; background-color: darkorange; color: #f1f1f1; cursor:pointer; padding: 5px; border: none; border-radius: .5rem;">See dispute</a>
                                @elseif($order->status == 'completed')
                                    Order Completed
                                @elseif($order->status == 'cancelled')
                                    Order Cancelled
                                @endif
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">Looks like you don't have any order yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- when store try to click cancel warn him with this below --}}
@if (session('cancel'))
<div class="alert-box-div">
    <form action="" method="post">
    <div class="alert-box">
        
        <legend>Order Cancellation</legend>
        <h3 style="font-size: .8rem;"> Are you sure you want to do this?
            <hr>
        </h3>
        <span>The user will get back his/her money 100%.</span>
       
            @csrf
            <input type="hidden" name="user" value="{{ session('user_id') }}">
            <input type="submit" name="cancel_yes" class="submit-nxt" value="Yes" style="width: max-content;">
        <input type="submit" name="canacel_no" class="submit-nxt" style="background-color: red; width: max-content;" value="No">
    
    </div>
</form>
</div>
@endif

<div class="top-products">
    <div class="title-latest">
        <h4>STORE TOP 10 PRODUCTS</h4>
        <div class="view-latest">
            <a href="/store/{{ $store->store_name }}/show/products">VIEW ALL</a>
        </div>
    </div>
    <div>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Sales</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($store->products()->orderBy('sold', 'desc')->paginate(10) as $product)
                    <tr>
                        <td style="text-transform: uppercase;">#WM{{ strtotime($product->created_at) }}</td>
                        <td>
                            @if (!empty($product->image_path1))
                                <img src="data:image/png;base64,{{ $product_image[$product->image_path1] }}"
                                    width="30">
                            @else
                                <img src="data:image/png;base64,{{ $icon['default'] }}" width="30">
                            @endif
                        </td>
                        <td>{{ Str::limit($product->product_name, 50, '...') }}</td>
                        <td> {{ '$' . $product->price }}</td>
                        <td>{{ $product->sold }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">Looks like you don't have any active listings yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
</div>
