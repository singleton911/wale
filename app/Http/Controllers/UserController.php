<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Category;
use App\Models\MessageStatus;
use App\Models\News;
use App\Models\NewStore;
use App\Models\Product;
use App\Models\Store;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return view('Admin.index', [
            'user'  => auth()->user(),
            'users' => $users,
            'icon' => GeneralController::encodeImages(),
            'product_image' => GeneralController::encodeImages('Product_Images'),
            'upload_image' => GeneralController::encodeImages('Upload_Images'),
            'action' => 'users',
            'name' => 'Users',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($action)
    {
        if ($action == 'login') {
            return view('Auth.login', ['icon' => GeneralController::encodeImages()]);
        } elseif ($action == 'signup') {
            return view('Auth.register', ['icon'   => GeneralController::encodeImages()]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        // Check if the password and confirm_password match
        if ($request->password !== $request->confirm_password) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['confirm_password' => 'The password and confirm password do not match.']);
        }

        $storeKey = Str::random(128);

        // Create the user
        $user = User::create([
            'public_name'       => $request->public_name,
            'private_name'      => $request->private_name,
            'store_key'         => $storeKey,
            'login_passphrase'  => $request->login_passphrase,
            'pin_code'          => $request->pin_code,
            'referral_link'     => $request->filled('referral_link') ? $request->referral_link : null,
            'password'          => bcrypt($request->password),
        ]);

        // Create a new wallet for the user
        $newWallet = new Wallet([
            'user_id'       => $user->id,
            'address'       => Str::random(128),
            'seed'          => Str::random(64),
            'balance'       => 1000,
            'private_key'   => Str::random(64),
            'public_key'    => Str::random(64),
        ]);

        $newWallet->save();


        return redirect('/auth/login')->with('success', 'You have successfully created an account. Please log in now!');
    }

    public function showUser($name = null, User $user)
    {

        if ($user->role == 'admin' && $user->id < 10) {
            return $this->userIndex(null, $name, $user);
        }

        return abort(403);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }

    public function authLogin(Request $request)
    {
        // Validate the login data
        $data = $request->validate([
            'private_name' => 'required|string|min:3|max:20',
            'password' => 'required|string|min:8|max:128',
        ]);

        // Check if the user exists
        $user = \App\Models\User::where('private_name', $data['private_name'])->first();

        // Check if the user is banned
        if ($user && $user->status == 'banned') {
            return redirect()->back()->withErrors(['login' => 'This account has been banned.']);
        }

        // Check if the user exists and the password is correct
        if (Auth::attempt($data)) {
            $request->session()->regenerate();
            // Redirect to the desired location after successful login
            return redirect('/');
        }

        // Authentication failed
        return redirect()->back()->withErrors(['login' => 'Invalid private name or password.']);
    }

    private function getProductsByCategory($categoryId)
    {
        $category = Category::find($categoryId);

        if ($category) {
            if ($category->parent_category_id === null) {
                return Product::where('parent_category_id', $categoryId)->paginate(20);
            } elseif ($category->parent_category_id !== null && $categoryId > 8) {
                return Product::where('sub_category_id', $categoryId)->paginate(20);
            }
        }

        return Product::inRandomOrder()->paginate(20);
    }

    public function openstore(Request $request)
    {
        $user = auth()->user();
        if ($request->store_key) {

            $data = $request->validate(['store_key' => 'required|string|min:64|max:128']);

            if ($data['store_key'] === $user->store_key && $user->store_status == 'in_active') {
                $userKey = User::find($user->id);
                $userKey->store_status = 'pending';
                $userKey->save();
                return redirect()->back()->with('success', 'Your store key has been successfully activated.');
            }
            return redirect()->back()->withErrors(['store_key' => 'Invalid store key, too much fail attempt might get your account escalated!!!']);
        } elseif ($request->storeProfile && $user->store_status == 'pending') {
            $data = $request->validate([
                'storeName' => 'required|string|min:3|max:30',
                'storeProfile' => 'required|image|mimes:png,jpg,jpeg|max:2048',
                'selling' => 'required|string|max:5000',
                'shipto' => 'sometimes|string|min:1',
                'shipfrom' => 'sometimes|string|min:1',
                'storeDesc' => 'required|string|min:50|max:5000',
                'sellOn' => 'sometimes|string|min:1',
                'proof1' => 'required|image|mimes:png,jpg,jpeg|max:2048',
                'proof2' => 'required|image|mimes:png,jpg,jpeg|max:2048',
                'proof3' => 'required|image|mimes:png,jpg,jpeg|max:2048',
            ]);
        
            $newStore = new NewStore();
            $newStore->store_name = $data['storeName'];
            $newStore->user_id = $user->id;
            $newStore->selling = $data['selling'];
            $newStore->ship_to = $data['shipto'];
            $newStore->ship_from = $data['shipfrom'];
            $newStore->store_description = $data['storeDesc'];
            $newStore->sell_on = $data['sellOn'];
        
            // Process and store images
            $newStore->proof1 = GeneralController::processAndStoreImage($data['proof1'], 'Upload_Images');
            $newStore->proof2 = GeneralController::processAndStoreImage($data['proof2'], 'Upload_Images');
            $newStore->proof3 = GeneralController::processAndStoreImage($data['proof3'], 'Upload_Images');
            $newStore->avater = GeneralController::processAndStoreImage($data['storeProfile'], 'Upload_Images');
        
            // Save the new store
            $newStore->save();
        }
        
        return redirect()->back()->with('success', 'Your store has been added please wait for apporval.');
    }

    public function userLogout()
    {
        // Log out the authenticated user
        auth()->logout();

        // Redirect the user back to the previous page
        return redirect()->back();
    }


    private function adminIndex($action, $name, $user)
    {
        $is_parent_category = false;
        $is_sub_category = false;

        $products = $this->getProductsByCategory($action);
        $categoryName = null;

        return view('Admin.index', [
            'user' => $user,
            'parentCategories' => Category::whereNull('parent_category_id')->get(),
            'subCategories' => Category::whereNotNull('parent_category_id')->get(),
            'categories' => Category::all(),
            'icon' => GeneralController::encodeImages(),
            'product_image' => GeneralController::encodeImages('Product_Images'),
            'upload_image' => GeneralController::encodeImages('Upload_Images'),
            'action' => $action,
            'name' => $name,
            'products' => $products,
            'is_parent_category' => $is_parent_category,
            'is_sub_category' => $is_sub_category,
            'categoryName' => $categoryName,
        ]);
    }

    private function userIndex($action, $name, $user)
    {
        $is_parent_category = false;
        $is_sub_category = false;

        $products = $this->getProductsByCategory($action);
        $categoryName = null;

        return view('User.index', [
            'user' => $user,
            'parentCategories' => Category::whereNull('parent_category_id')->get(),
            'subCategories' => Category::whereNotNull('parent_category_id')->get(),
            'categories' => Category::all(),
            'icon' => GeneralController::encodeImages(),
            'product_image' => GeneralController::encodeImages('Product_Images'),
            'upload_image' => GeneralController::encodeImages('Upload_Images'),
            'action' => $action,
            'name' => $name,
            'products' => $products,
            'is_parent_category' => $is_parent_category,
            'is_sub_category' => $is_sub_category,
            'categoryName' => $categoryName,
        ]);
    }

    public function changePassword(Request $request)
    {
        // Validate the form data
        $request->validate([
            'old-passwrd' => 'required|min:8|max:128|regex:/^(?=.*[a-zA-Z\d])(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/',
            'new-passwrd' => 'required|min:8|max:128|regex:/^(?=.*[a-zA-Z\d])(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/|different:old-passwrd',
            'confirm-new-passwrd' => 'required|min:8|max:128|regex:/^(?=.*[a-zA-Z\d])(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/|same:new-passwrd',
            'secret_code' => 'required|numeric|min:6',
        ]);

        // Check if the old password matches the current user's password
        if ($request->secret_code != auth()->user()->pin_code) {
            return back()->withErrors(['secret_code' => 'Secret code incorrect.']);
        }

        if (Hash::check($request->input('old-passwrd'), Auth::user()->password)) {
            // Update the user's password
            $user = User::find(auth()->user()->id);
            $user->password = bcrypt($request->input('new-passwrd'));
           $user->save();

            // Redirect or return a success response
            return redirect()->back()->with('success', 'Password changed successfully!');
        } else {
            // Old password doesn't match, return with an error message
            return back()->withErrors(['old-passwrd' => 'The old password is incorrect.']);
        }
    }
        /**
     * Display the specified resource.
     */
    public function show($name = null, $action = null)
    {
        $news = News::latest()->first();
        if (auth()->check()) {
            $user = auth()->user();
            if ($user->role == 'user') {
                return $this->userIndex($action, $name, $user)->with('news', $news);

            } elseif ($user->role == 'store') {
                
                $store = Store::where('user_id', auth()->user()->id)->first();
                return redirect('/store/'.$store->store_name.'/show');
                
            }  elseif ($user->role == 'junior') {
                
                return redirect('/junior/staff/'.$user->public_name.'/show');
                
            }  elseif ($user->role == 'senior') {
                
                return redirect('/senior/staff/'.$user->public_name.'/show');
                
            } elseif ($user->role == 'admin' && $user->id < 10) {

                return $this->adminIndex($action, $name, $user)->with('news', $news);

            }  else {
                return redirect('/ddos');
            }
        } else {
            return redirect('/ddos');
        }
    }
    
}
