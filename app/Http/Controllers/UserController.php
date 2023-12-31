<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Category;
use App\Models\MessageStatus;
use App\Models\News;
use App\Models\NewStore;
use App\Models\Notification;
use App\Models\NotificationType;
use App\Models\Product;
use App\Models\Referral;
use App\Models\Store;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

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
            'referral_link'     => $request->public_name,
            'password'          => bcrypt($request->password),
        ]);

        if (!empty($request->referred_link) && $request->referred_link != null) {
            $referred_by = User::where('public_name', $request->referred_link)->first();
            $new_referral = new Referral();
            $new_referral->user_id = $referred_by->id;
            $new_referral->referred_user_id = $user->id;
            $rs = $new_referral->save();
            $notificationType = NotificationType::where('action', 'used')->where('icon', 'referral')->first();

            if ($rs && $notificationType) {
                NotificationController::create($referred_by->id, null, $notificationType->id);
            }
        }
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

        session(['signup' => true]);

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
            'private_name' => 'required|string|min:3|max:80',
            'password' => 'required|string|min:8|max:128',
        ]);

        $request->validate([
            'session_timer' => 'required|min:2|max:3',
            'captcha' =>  'required|min:8|max:8',
        ]);

        if ($request->has('captcha')) {
            if (session('captcha_time') < strtotime(now())) {
                return redirect()->back()->withErrors(['login' => 'Captch code expired.']);
            }

            if ($request->captcha !== session('captcha')) {
                return redirect()->back()->withErrors(['login' => 'Captch code is invalid.']);
            }
        }

        // Check if the user exists
        $user = User::where('private_name', $data['private_name'])->first();

        // Check if the user is banned
        if ($user && $user->status == 'banned') {
            return redirect()->back()->withErrors(['login' => 'This account has been banned.']);
        }

        if (Auth::attempt($data)) {
            $request->session()->regenerate();
            $user->last_seen = now();
            $user->save();

            if (session('signup')) {
                session(['let_welcome' => true]);
            }

            // kick out timer
            session(['session_timer' => ($request->session_timer * 60)]);


            // Redirect to the desired location after successful login
            return redirect('/');
        }

        // Authentication failed
        return redirect()->back()->withErrors(['login' => 'Invalid private name or password.']);
    }

    public function openstore(Request $request)
    {
        $user = auth()->user();  

            $data = $request->validate([
                'storeProfile' => 'required|image|mimes:png,jpg,jpeg|max:2048',
                'selling' => 'required|string|max:5000',
                'shipto' => 'sometimes|nullable|string|',
                'shipfrom' => 'sometimes|nullable|string|',
                'storeDesc' => 'required|string|min:50|max:5000',
                'sellOn' => 'sometimes|nullable|string|min:1',
                'proof1' => 'required|image|mimes:png,jpg,jpeg|max:2048',
                'proof2' => 'required|image|mimes:png,jpg,jpeg|max:2048',
                'proof3' => 'required|image|mimes:png,jpg,jpeg|max:2048',
                'store_key' => 'required|string|min:64|max:256',
            ]);

            if ($data['store_key'] != $user->store_key) {
                return redirect()->back()->withErrors('Invalid store key, too much fail attempt might get your account banned!!!');
            }

            if ($user->store_status == 'pending') {
                return redirect()->back()->withErrors('Your store is still pending, too much fail attempt might get your account banned!!!');
            }

            $newStore = new NewStore();
            $newStore->store_name = $user->public_name;
            $newStore->user_id = $user->id;
            $newStore->selling = $data['selling'];
            $newStore->ship_to = $data['shipto'] ?? 'worldwide';
            $newStore->ship_from = $data['shipfrom'] ?? 'worldwide';
            $newStore->store_description = $data['storeDesc'];
            $newStore->sell_on = $data['sellOn'];

            // Process and store images
            $newStore->proof1 = GeneralController::processAndStoreImage($data['proof1'], 'Upload_Images');
            $newStore->proof2 = GeneralController::processAndStoreImage($data['proof2'], 'Upload_Images');
            $newStore->proof3 = GeneralController::processAndStoreImage($data['proof3'], 'Upload_Images');
            $newStore->avater = GeneralController::processAndStoreImage($data['storeProfile'], 'Upload_Images');

            // Save the new store
            $newStore->save();

            $user->store_status = 'pending';
            $user->save();

        return redirect()->back()->with('success', 'Your store has been added please wait for apporval.');
    }

    public function userLogout()
    {
        // Log out the authenticated user
        auth()->logout();

        // Redirect the user back to the previous page
        return redirect()->back();
    }


    // private function adminIndex($action, $name, $user)
    // {
    //     $is_parent_category = false;
    //     $is_sub_category = false;

    //     $products = $this->getProductsByCategory($action);
    //     $categoryName = null;

    //     return view('Admin.index', [
    //         'user' => $user,
    //         'parentCategories' => Category::whereNull('parent_category_id')->get(),
    //         'subCategories' => Category::whereNotNull('parent_category_id')->get(),
    //         'categories' => Category::all(),
    //         'icon' => GeneralController::encodeImages(),
    //         'product_image' => GeneralController::encodeImages('Product_Images'),
    //         'upload_image' => GeneralController::encodeImages('Upload_Images'),
    //         'action' => $action,
    //         'name' => $name,
    //         'products' => $products,
    //         'is_parent_category' => $is_parent_category,
    //         'is_sub_category' => $is_sub_category,
    //         'categoryName' => $categoryName,
    //     ]);
    // }

    private function userIndex($action, $name, $user)
    {
        $is_parent_category = false;
        $is_sub_category = false;

        $products = Product::inRandomOrder()->where('status', 'Active')->paginate(20);
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

        if (auth()->check()) {
            //check if the user has 2fa enable and if they has verified it else redirect them to /auth/pgp/verify
            $role = auth()->user()->role;
            if (auth()->user()->twofa_enable == 'yes' && !session('pgp_verified')) {
                switch ($role) {
                    case 'user':
                        return redirect('/auth/pgp/verify');
                        break;

                    case 'share':
                        return redirect('/auth/share/pgp/verify');
                        break;

                    case 'store':
                        return redirect('/auth/store/pgp/verify');
                        break;

                    case 'junior':
                        return redirect('/auth/staff/junior/pgp/verify');
                        break;

                    case 'senior':
                        return redirect('/auth/staff/senior/pgp/verify');
                        break;

                    case 'admin':
                        return redirect('/auth/staff/admin/pgp/verify');
                        break;
                    default:
                        return redirect('/auth/pgp/verify');
                        break;
                }
            }

            $user = auth()->user();
            if ($user->role == 'user') {
                return $this->userIndex($action, $name, $user);
            } elseif ($user->role == 'store') {

                $store = Store::where('user_id', auth()->user()->id)->first();
                return redirect('/store/' . $store->store_name . '/show');
            } elseif ($user->role == 'junior') {

                return redirect('/junior/staff/' . $user->public_name . '/show');
            } elseif ($user->role == 'senior') {

                return redirect('/senior/staff/' . $user->public_name . '/show');
            } elseif ($user->role == 'admin' && $user->id < 10) {

                return redirect('whales/admin/' . $user->public_name . '/show');

                //return $this->adminIndex($action, $name, $user)->with('news', $news);

            } else {
                return redirect('/ddos');
            }
        } else {
            return redirect('/ddos');
        }
    }


    public function theme($user=null)
    {
        //check if the user has 2fa enable and if they has verified it else redirect them to /auth/pgp/verify
        if (auth()->user()->twofa_enable == 'yes' && !session('pgp_verified')) {
            return redirect('/auth/pgp/verify');
        }

        $user = auth()->user();

        if ($user->theme == 'white') {
            $user->theme = 'dark';
            $user->save();
            return redirect()->back();
        } elseif ($user->theme == 'dark') {
            $user->theme = 'white';
            $user->save();
            return redirect()->back();
        }
        return abort(404);
    }


    public function welcome($user, Request $request)
    {
        // Check if the 'understood' token is present in the request
        if ($request->has('understood')) {

            // Flush the 'let_welcome' session
            Session::forget('let_welcome');

            // Flush the 'signup' session
            Session::forget('signup');

            session(['ask_pgp' => true]);
            // Redirect to '/'
            return redirect('/');
        }

        // If the token is not present, return the original request
        return abort(404);
    }

    public function kickout()
    {
        // Flush all session data
        Session::flush();

        // Regenerate the session ID to enhance security
        Session::regenerate();

        // Redirect users back to a specific location
        return Redirect::to('/');
    }


    // 2fa display
    public function pgpVerify()
    {
        //check if the user has 2fa enable and if they has verified it else redirect them to /auth/pgp/verify
        if (auth()->user()->twofa_enable == 'yes' && session('pgp_verified')) {
            return redirect()->back();
        }

        $user = auth()->user();
        session(['encrypted_message' => GeneralController::encryptPGPMessage($user->pgp_key)]);

        return view('User.verify_2fa');
    }


    // 2fa code verify
    public function pgpCodeVerify(Request $request)
    {
        $user = auth()->user();

        if ($request->pgp_token == session('global_token')) {
            session(['pgp_verified' => true]);
            return redirect('/');
        }



        session(['encrypted_message' => GeneralController::encryptPGPMessage($user->pgp_key)]);

        return redirect('/auth/pgp/verify');
    }

    public function storeKey(Request $request)
    {
        $user = auth()->user();
        if ($user->twofa_enable == 'no') {
            return redirect()->back()->withErrors('Enable 2FA to proceed please.');
        }

        if ($user->show_key) {
            return redirect()->back()->withErrors('Your store key has been already been generated, please check your notifications.');
        }

        if ($user->wallet->balance < 400) {
            return redirect()->back()->withErrors('Your store key cannot be generated due to insufficent funds.');
        }

            $notificationType = NotificationType::where('action', 'key')->where('icon', 'store')->first();
            if ($notificationType) {
                NotificationController::create($user->id, null, $notificationType->id);
            }

            $user->show_key = true;
            $user->save();

         return redirect()->back()->with('success', 'Congratulations your store key has been generated successfully, please check you notifications.');
    }
}
