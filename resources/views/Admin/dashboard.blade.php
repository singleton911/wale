{{-- @include('Store.news')
<div class="latest-orders">
    <div class="title-latest">
        <h4>LATEST ORDERs</h4>
        <div class="view-latest">
            <a href="/orders">VIEW ALL</a>
        </div>
    </div>
    <div>
        <table>
            <thead>
                <tr>
                    <th>Listing</th>
                    <th>Buyer</th>
                    <th>No. Items</th>
                    <th>Time</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($store->orders()->orderBy('updated_at', 'desc')->paginate(5) as  $order)
                <tr>

                    <td>{{ $order->product->product_name }}</td>
                    <td>{{ $order->user->public_name }}</td>
                    <td>{{ $order->quantity }}</td>
                    <td>{{ \Carbon\Carbon::parse($order->created_at)->diffForHumans() }}</td>
                    <td class="order-status-cls">{{ $order->status }}</td>
                    <td>
                        <a href="/store/order/{{ $order->id }}" style="background-color: rgb(0, 75, 128); color: #f1f1f1; cursor:pointer; padding: 5px; border: none; border-radius: .5rem;">View</a>
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
<div class="top-products">
    <div class="title-latest">
        <h4>STORE TOP 5 PRODUCTS</h4>
        <div class="view-latest">
            <a href="/store/{{ $store->store_name }}/products">VIEW ALL</a>
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
                @forelse ($store->products()->orderBy('sold', 'desc')->paginate(5) as $product)
                <tr>
                    <td style="text-transform: uppercase;">#WM{{ strtotime($product->created_at) }}</td>
                    <td class="product-img"><img src="'" alt="" srcset=""></td>
                    <td>{{ $product->product_name }}</td>
                    <td> {{ '$'.$product->price }}</td>
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
</div> --}}
