<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\MarketKey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;

use gnupg;

class GeneralController extends Controller
{

    public static function encodeImages($filesFolder = "Market_Images")
    {
        $marketImages = [];

        // Get all files from the specified folder
        $files = Storage::disk('public')->files($filesFolder);

        foreach ($files as $file) {
            // Get the icon name without extension
            $iconName = pathinfo($file, PATHINFO_FILENAME);

            // Read the file content and encode it to base64
            $base64Image = base64_encode(Storage::disk('public')->get($file));

            // Add the base64 encoded image to the array with icon name as key
            $marketImages[$iconName] = $base64Image;
        }

        // Return the array with key 'Icons' containing the encoded icons
        return $marketImages;
    }


    public static function processAndStoreImage($file, $folder)
    {
        // Ensure that $file is a valid file object
        if (!is_file($file)) {
            throw new \InvalidArgumentException('Invalid file provided.');
        }

        // Use hashName() to generate a unique, hashed filename
        $uniqueFilename = time() . '_' . $file->hashName();

        // Construct the full path where the image will be stored
        $folderPath = storage_path("app/public/{$folder}");
        $imagePath = "{$folderPath}/{$uniqueFilename}";

        // Check if the specified folder exists, and create it if not
        if (!file_exists($folderPath)) {
            mkdir($folderPath, 0755, true); // Adjust the permission based on your needs
        }

        // Move the uploaded file to the specified folder
        $moveSuccess = $file->move($folderPath, $uniqueFilename);

        // Check if the file move operation was successful
        if (!$moveSuccess) {
            throw new \RuntimeException('Failed to move the file to the destination folder.');
        }
        $iconName = pathinfo($uniqueFilename, PATHINFO_FILENAME);
        // Return only the filename
        return $iconName;
    }


    public function canary()
    {
                //check if the user has 2fa enable and if they has verified it else redirect them to /auth/pgp/verify
                if (auth()->user()->twofa_enable == 'yes' && !session('pgp_verified')) {
                    return redirect('/auth/pgp/verify');
                }
        $user = auth()->user();
        return view('User.canary', [
            'user' => $user,
            'parentCategories' => Category::whereNull('parent_category_id')->get(),
            'subCategories' => Category::whereNotNull('parent_category_id')->get(),
            'categories' => Category::all(),
            'icon' => GeneralController::encodeImages(),
            'canaries'  => MarketKey::all(),
        ]);
    }

    public function pgpKeySystem(Request $request)
    {
        $user = auth()->user();


        if ($request->has('skip')) {
            // Flush the 'ask_pgp' session
            Session::forget('ask_pgp');

            return redirect('/');
        } elseif ($request->has('pgp_token')) {
            // validate the user token
            $request->validate([
                'pgp_token' => 'required|min:10|max:10',
            ]);

            if ($request->pgp_token !== session('global_token')) {
                return redirect()->back()->withErrors('Invalid token, check you pgp key well.');
            }

            $enable2fa = $request->has('enable2fa');
            $public_key  = session('public_key');

            return $this->addPgpKey($public_key, $enable2fa ?? false);

            // validate the user pgp key.
        } elseif ($request->has('public_key')) {
            // Validate the request
            $request->validate([
                'public_key' => 'required',
            ]);

            try {
                // Initialize GnuPG
                $gpg = new gnupg();

                // Set error mode to exception
                $gpg->seterrormode(gnupg::ERROR_EXCEPTION);

                // Import the public key and get the key fingerprint
                $importedKey = $gpg->import($request->public_key);
                $fingerprint = $importedKey['fingerprint'];

                // Get information about the key using the fingerprint
                $keyInfo = $gpg->keyinfo($fingerprint);
                $userName    = $keyInfo[0]['uids'][0]['name'];
                $expired     =  $keyInfo[0]['subkeys'][0]['expired'];
                $is_secret   = $keyInfo[0]['subkeys'][0]['is_secret'];
                $invalid   = $keyInfo[0]['subkeys'][0]['invalid'];

                // Validate each field
                $this->validateField($userName, 'Name', $user->public_name);
                $this->validateExpiration($expired);
                $this->validateSecret($is_secret);
                $this->validateInvalid($invalid);

                // set the public key in a session for later
                session(['public_key' => $request->public_key]);

                return redirect()->back()->with('encrypted_message', $this::encryptPGPMessage($request->public_key))->with('encrypted_message_verify', true);
                // Do further processing with the key information
            } catch (\Exception $e) {
                // If an exception occurs, redirect back with the error message
                return redirect()->back()->withErrors([$e->getMessage()]);
            }
        }

        return abort(404);
    }

    private function validateField($value, $fieldName, $expectedValue = null)
    {
        if ($value != $expectedValue) {
            throw new \Exception("Validation failed for $fieldName: Your public name doesn't match the public pgp key user.");
        }
    }

    private function validateExpiration($expired)
    {
        if ($expired) {
            throw new \Exception("Validation failed: Key has expired.");
        }
    }

    private function validateSecret($is_secret)
    {
        if ($is_secret) {
            throw new \Exception("Validation failed: Key is marked as secret.");
        }
    }

    private function validateInvalid($invalid)
    {
        if ($invalid) {
            throw new \Exception("Validation failed: Key is marked as invalid.");
        }
    }

    private function addPgpKey($key, $fa = false)
    {
        // Retrieve the authenticated user
        $user = auth()->user();

        // Check if the user is authenticated
        if ($user) {
            if ($fa) {
                $user->twofa_enable = true;
            }

            // Update the pgp_key attribute
            $user->pgp_key = $key;

            // Save the user model
            $user->save();

            // Flush the 'ask_pgp and public key' session
            Session::forget('ask_pgp');
            Session::forget('public_key');
            session(['pgp_verified' => true]);

            // Optionally, you can return a success message or do other tasks
            return redirect()->back()->with('success', "PGP key added successfully.");
        } else {
            // If the user is not authenticated, return an error message
            return redirect()->back()->withErrors("Error: User not authenticated.");
        }
    }

    public static function encryptPGPMessage($public_key)
    {
        $gpg = new gnupg();

        $importedKey = $gpg->import($public_key);
        $fingerprint = $importedKey['fingerprint'];

        // Add the recipient's public key for encryption
        $gpg->addencryptkey($fingerprint);


        // Message to be encrypted
        $token =  Str::random(10);
        session(['global_token' => $token]); // Store the token in the session
        $message = "
            Welcome back to Whales Market (❁´◡`❁)!
            
                 Here is your login token: $token
            
            Thank you for choosing our market, stay safe.";


        // Encrypt the message
        $encryptedMessage = $gpg->encrypt($message);

        // Define delimiters with regular expressions
        $delimiterStart = '/-----BEGIN PGP MESSAGE-----/';
        $delimiterEnd = '/-----END PGP MESSAGE-----/';

        // Add line break before and after the delimiters
        $formattedMessage = preg_replace($delimiterStart, "-----BEGIN PGP MESSAGE-----<br>", $encryptedMessage);
        $formattedMessage = preg_replace($delimiterEnd, "<br>-----END PGP MESSAGE-----", $formattedMessage);

        // If everything went well, return the encrypted message
        return  $formattedMessage;
    }

    public static function  encryptPGPNotes($note, $public_key)
    {
        $gpg = new gnupg();

        $importedKey = $gpg->import($public_key);
        $fingerprint = $importedKey['fingerprint'];

        // Add the recipient's public key for encryption
        $gpg->addencryptkey($fingerprint);


        // Encrypt the message
        $encryptedMessage = $gpg->encrypt($note);

        // Define delimiters with regular expressions
        $delimiterStart = '/-----BEGIN PGP MESSAGE-----/';
        $delimiterEnd = '/-----END PGP MESSAGE-----/';

        // Add line break before and after the delimiters
        $formattedMessage = preg_replace($delimiterStart, "-----BEGIN PGP MESSAGE-----<br>", $encryptedMessage);
        $formattedMessage = preg_replace($delimiterEnd, "<br>-----END PGP MESSAGE-----", $formattedMessage);

        // If everything went well, return the encrypted message
        return  $formattedMessage;
    }
    public function userPgpSystem(Request $request)
    {
        $user = auth()->user();
        $request->validate([
            'secret_code' => 'required|min:6|max:6',
            'captcha'     => 'required|min:8|max:8',
            'public_key' => 'required|min:100',
        ]);

        if ($request->secret_code != $user->pin_code) {
            return redirect()->back()->withErrors('Invalid secret code.');
        }

        if ($request->has('public_key')) {
            session(['public_key' => $request->public_key]);
        }
        if ($request->captcha != session('captcha')) {
            return redirect()->back()->withErrors('Invalid captcha code.');
        }

        try {
            // Initialize GnuPG
            $gpg = new gnupg();

            // Set error mode to exception
            $gpg->seterrormode(gnupg::ERROR_EXCEPTION);

            // Import the public key and get the key fingerprint
            $importedKey = $gpg->import($request->public_key);
            $fingerprint = $importedKey['fingerprint'];

            // Get information about the key using the fingerprint
            $keyInfo = $gpg->keyinfo($fingerprint);
            $userName    = $keyInfo[0]['uids'][0]['name'];
            $expired     =  $keyInfo[0]['subkeys'][0]['expired'];
            $is_secret   = $keyInfo[0]['subkeys'][0]['is_secret'];
            $invalid   = $keyInfo[0]['subkeys'][0]['invalid'];

            // Validate each field
            $this->validateField($userName, 'Name', $user->public_name);
            $this->validateExpiration($expired);
            $this->validateSecret($is_secret);
            $this->validateInvalid($invalid);

            return redirect()->back()->with('encrypted_message', $this::encryptPGPMessage($request->public_key))->with('encrypted_message_verify', true);
            // Do further processing with the key information
        } catch (\Exception $e) {
            // If an exception occurs, redirect back with the error message
            return redirect()->back()->withErrors([$e->getMessage()]);
        }

        return abort(401);
    }

    public static function qrcode($address = "let gooooooo")
    {

        $address = "let gooooooo";

        $from = [0, 128, 255];
        $to = [11, 57, 150];

        $qrCode = QrCode::size(200)
            ->style('dot')
            ->eye('circle')
            ->gradient($from[0], $from[1], $from[2], $to[0], $to[1], $to[2], 'diagonal')
            ->margin(1)
            ->generate($address);

        return view('User.deposit_qrcode', ['qrcode' => $qrCode]);
    }

    function captcha()
    {
        // Generate a new captcha code with 6 characters
        $captcha = substr(md5(rand()), 0, 8);

        // Save the captcha code and its generation time in the session
        session(['captcha' => $captcha]);
        // Get the current time
        $currentTime = time();

        // Add 2 minutes (2 * 60 seconds) to the current time
        $newTime = $currentTime + 60;

        // Store the new time in the session
        Session::put('captcha_time', $newTime);

        // Create an image with the captcha code
        $image = imagecreate(100, 50);
        $bg_color = imagecolorallocate($image, 255, 255, 255);
        $text_color = imagecolorallocate($image, 0, 0, 0);
        imagestring($image, 20, 20, 15, $captcha, $text_color);

        // Add some random lines to the image
        for ($i = 0; $i < 10; $i++) {
            $color = imagecolorallocate($image, rand(0, 255), rand(0, 255), rand(0, 255));
            imageline($image, rand(0, 200), rand(0, 50), rand(0, 200), rand(0, 50), $color);
        }

        // Output the image
        header('Content-type: image/png');
        imagepng($image);

        // Clean up
        imagedestroy($image);
        return;
    }
}
