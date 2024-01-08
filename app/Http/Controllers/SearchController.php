<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Notification;
use App\Models\Order;
use App\Models\Product;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SearchController extends Controller
{


    public function quickSearch(Request $request)
    {
        //check if the user has 2fa enable and if they has verified it else redirect them to /auth/pgp/verify
        if (auth()->user()->twofa_enable == 'yes' && !session('pgp_verified')) {
            return redirect('/auth/pgp/verify');
        }

        if ($request->has('advance-search')) {
            return redirect()->back()->with('advance_search', true);
        }

        $is_parent_category = false;
        $is_sub_category = false;
        $categoryName = null;

        $validatedData = $request->validate([
            'search_type' => 'required|in:product,store',
            'pn' => 'nullable|string',
            'pf' => 'nullable|numeric|min:0',
            'pt' => 'nullable|numeric|min:0',
            'sf' => 'nullable|string',
            'st' => 'nullable|string',
            'auto_shop' => 'nullable',
            'desc'  => 'nullable',
            'payment_type' => 'nullable|in:Escrow,FE',
            'filter-product' => 'nullable|in:best-match,newest,oldest,Cheapest,highest',
            'parent_category' => 'nullable|exists:categories,id',
            'sub_category' => 'nullable|exists:categories,id',
            'pt2' => 'nullable|in:all,digital,physical',
        ]);

        $searchType = $validatedData['search_type'];
        $productName = $validatedData['pn'];
        $minPrice = $validatedData['pf'];
        $maxPrice = $validatedData['pt'];
        $sortBy = $validatedData['filter-product'];
        $parent_categoryId = $validatedData['parent_category'] ?? '';
        $sub_categoryId = $validatedData['sub_category'] ?? '';
        $ship_from  = $validatedData['sf'] ?? '';
        $ship_to = $validatedData['st'] ?? '';
        $auto_shop = $validatedData['auto_shop'] ?? '';
        $desc = $validatedData['desc'] ?? '';
        $payment_type = $validatedData['payment_type'] ?? '';
        $productType = $validatedData['pt2'] ?? '';

        // Perform search based on the selected search type
        if ($searchType == 'product') {
            $query = Product::query()->where('status', 'Active');
            $products = $this->productSearchQuery($query, $productName, $minPrice, $maxPrice, $sortBy, $parent_categoryId, $sub_categoryId, $productType, $ship_from, $ship_to, $auto_shop, $desc, $payment_type);
        } elseif ($searchType == 'store') {
            $query = $this->storeQuery($productName);
        }

        // Execute the query and get the search results
        $results = $products->get();

        // For example, you can return a view with the search results
        return view('User.search', [
            'search_products' => $results,
            'user'  => auth()->user(),
            'icon' => GeneralController::encodeImages(),
            'product_image' => GeneralController::encodeImages('Product_Images'),
            'upload_image' => GeneralController::encodeImages('Upload_Images'),
            'action' => 'users',
            'name' => 'Users',
            'parentCategories' => Category::whereNull('parent_category_id')->get(),
            'subCategories' => Category::whereNotNull('parent_category_id')->get(),
            'categories' => Category::all(),
            'is_parent_category' => $is_parent_category,
            'is_sub_category' => $is_sub_category,
            'categoryName' => $categoryName,
        ]);
    }



    private function productSearchQuery($query, $productName, $minPrice, $maxPrice, $sortBy, $parent_categoryId, $sub_categoryId, $productType, $ship_from, $ship_to, $auto_shop, $desc, $payment_type)
    {
        if (!empty($productName)) {
            $query->where('product_name', 'like', '%' . $productName . '%');
        }

        if (!empty($minPrice)) {
            $query->where('price', '>=', $minPrice);
        }

        if (!empty($maxPrice)) {
            $query->where('price', '<=', $maxPrice);
        }


        if (!empty($sortBy)) {
            // Sorting logic based on $sortBy
            switch ($sortBy) {
                case 'best-match':
                    $query->orderBy('sold', 'desc');
                    break;
                case 'newest':
                    $query->orderBy('created_at', 'desc');
                    break;
                case 'oldest':
                    $query->orderBy('created_at', 'asc');
                    break;
                case 'Cheapest':
                    $query->orderBy('price', 'asc');
                    break;
                case 'highest':
                    $query->orderBy('price', 'desc');
                    break;
                default:
                    // Default sorting to random
                    $query->inRandomOrder();
            }
        }

        if (!empty($ship_from)) {
            $query->where('ship_from', $ship_from);
        }

        if (!empty($ship_to)) {
            $query->where('ship_to', $ship_to);
        }

        if (!empty($auto_shop)) {
            $query->where('auto_delivery_content', '!=', NULL);
        }

        if (!empty($desc)) {
            $query->orWhere('product_description', 'like', '%' . $productName . '%');
        }




        if (!empty($payment_type)) {
            $query->where('payment_type', $payment_type);
        }

        if (!empty($parent_categoryId)) {
            $query->where('parent_category_id', $parent_categoryId);
        }

        if (!empty($sub_categoryId)) {
            $query->where('sub_category_id', $sub_categoryId);
        }

        if (!empty($productType) && $productType != 'all') {
            $query->where('product_type', $productType);
        }

        // Execute the query and return the result set
        return $query;
    }

    private function storeQuery($productName)
    {
        $query = Store::query();
        // Add conditions specific to the Store model
        // For example:
        if (!empty($productName)) {
            $query->where('store_name', $productName);
        }

        return $query;
    }



    // store searching products
    public function storeProductsSearch($actionName, Request $request)
    {
        //check if the user has 2fa enable and if they has verified it else redirect them to /auth/pgp/verify
        if (auth()->user()->twofa_enable == 'yes' && !session('pgp_verified')) {
            return redirect('/auth/store/pgp/verify');
        }
        // Validate the incoming request data
        $store = auth()->user()->store;
        $request->validate([
            'sort_by' => ['nullable', Rule::in(['newest', 'popular', 'price_highest', 'price_lowest', 'oldest'])],
            'number_of_rows' => ['nullable', 'integer', Rule::in([50, 100, 150, 250])],
            'payment_type' => ['nullable', 'string', Rule::in(['all', 'Escrow', 'FE'])],
            'status' => ['nullable', Rule::in(['all', 'Active', 'Pending', 'Rejected', 'Paused'])],
            'search_term' => ['nullable', 'string'],
        ]);

        // Retrieve validated search parameters from the request
        $sort_by = $request->sort_by;
        $number_of_rows = $request->number_of_rows;
        $status = $request->status;
        $search_term = $request->search_term;
        $payment_type = $request->payment_type;

        // Build the query based on the search parameters
        $query = Product::query()->where('store_id', $store->id);

        // Assuming $query is an instance of Eloquent query builder
        if (!empty($sort_by)) {
            switch ($sort_by) {
                case 'newest':
                    $query->orderBy('created_at', 'desc'); // Change to 'desc' for newest
                    break;

                case 'oldest':
                    $query->orderBy('created_at', 'asc'); // Change to 'asc' for oldest
                    break;

                case 'popular':
                    $query->orderBy('sold', 'desc'); // Assuming 'popular' means highest sold
                    break;

                case 'price_lowest':
                case 'price_highest':
                    $orderDirection = ($sort_by == 'price_lowest') ? 'asc' : 'desc';
                    $query->orderBy('price', $orderDirection);
                    break;

                default:
                    break;
            }
        }

        if ($payment_type !== 'all') {
            $query->where('payment_type', $payment_type);
        }

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        if (!empty($search_term)) {
            $query->where('product_name', 'like', '%' . $search_term . '%');
        }

        // Execute the query to retrieve products
        $products = $query->paginate($number_of_rows);

        // Return the products to the view
        return redirect()->back()->with('products', $products);
    }


    public function storeOrdersSearch($actionName, Request $request)
    {
        //check if the user has 2fa enable and if they has verified it else redirect them to /auth/pgp/verify
        if (auth()->user()->twofa_enable == 'yes' && !session('pgp_verified')) {
            return redirect('/auth/store/pgp/verify');
        }

        // Validate the incoming request data
        $store = auth()->user()->store;
        $request->validate([
            'sort_by' => ['nullable', Rule::in(['newest', 'highest_quantity', 'lowest_quantity', 'oldest'])],
            'number_of_rows' => ['nullable', 'integer', Rule::in([50, 100, 150, 250])],
            'payment_type' => ['nullable', 'string', Rule::in(['all', 'Escrow', 'FE'])],
            'status' => ['nullable', Rule::in(['all', 'pending', 'processing', 'shipped', 'delivered', 'dispute', 'sent', 'dispatched', 'cancelled', 'completed'])],
        ]);

        // Retrieve validated search parameters from the request
        $sort_by = $request->sort_by;
        $number_of_rows = $request->number_of_rows;
        $status = $request->status;
        $payment_type = $request->payment_type;

        // Build the query based on the search parameters
        $query = Order::query()->where('store_id', $store->id);

        // Assuming $query is an instance of Eloquent query builder
        if (!empty($sort_by)) {
            switch ($sort_by) {
                case 'newest':
                    $query->orderBy('created_at', 'desc');
                    break;

                case 'oldest':
                    $query->orderBy('created_at', 'asc');
                    break;

                case 'highest_quantity':
                    $query->orderBy('quantity', 'desc');
                    break;

                case 'lowest_quantity':
                    $query->orderBy('quantity', 'asc');
                    break;

                default:
                    break;
            }
        }

        if ($payment_type !== 'all') {
            $query->whereHas('product', function ($productQuery) use ($payment_type) {
                $productQuery->where('payment_type', $payment_type);
            });
        }

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        // Execute the query to retrieve orders
        $orders = $query->paginate($number_of_rows);

        // Return the orders to the view
        return redirect()->back()->with('orders', $orders);
    }


    public function storeNotificationsSearch(Request $request)
    {
        //check if the user has 2fa enable and if they has verified it else redirect them to /auth/pgp/verify
        if (auth()->user()->twofa_enable == 'yes' && !session('pgp_verified')) {
            return redirect('/auth/store/pgp/verify');
        }

        // Validate the incoming request data
        $store = auth()->user()->store;
        $request->validate([
            'sort_by' => ['nullable', Rule::in(['newest', 'oldest'])],
            'number_of_rows' => ['nullable', 'integer', Rule::in([50, 100, 150, 250])],
            // 'type' => ['nullable', 'string', Rule::in(['all', 'orders', 'wallet', 'account', 'news', 'share', 'referral', 'listings', 'reports', 'bugs'])],
            'status' => ['nullable', Rule::in(['all', 'read', 'unread'])],
            'action' => ['nullable', Rule::in(['show', 'read_all', 'delete', 'clear'])],
        ]);

        // Retrieve validated search parameters from the request
        $sort_by = $request->sort_by;
        $number_of_rows = $request->number_of_rows;
        $status = $request->status;
        $action  = $request->action;

        // Build the query based on the search parameters
        $query = Notification::query()->where('user_id', $store->user_id);

        // Assuming $query is an instance of Eloquent query builder
        if (!empty($sort_by)) {
            switch ($sort_by) {
                case 'newest':
                    $query->orderBy('created_at', 'desc');
                    break;

                case 'oldest':
                    $query->orderBy('created_at', 'asc');
                    break;
                default:
                    break;
            }
        }


        if ($status == 'read') {
            $query->where('is_read', 1);
        }

        if ($status == 'unread') {
            $query->where('is_read', 0);
        }

        // if ($action == 'read_all') {
        //     foreach ($query as $key) {
        //         # code...
        //     }
        //     $query->where('is_read', 0);
        // }

        // Execute the query to retrieve orders
        $orders = $query->paginate($number_of_rows);

        // Return the orders to the view
        return redirect()->back()->with('notifications', $orders);
    }
}
