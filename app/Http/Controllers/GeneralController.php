<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;


// pgp
use Spatie\Crypto\Rsa\KeyPair;
use Spatie\Crypto\Rsa\PrivateKey as rsaPrivate;
use Spatie\Crypto\Rsa\PublicKey as rsaPublic;

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
        // generating an RSA key pair
[$privateKey, $publicKey] = (new KeyPair())->generate();
$pk = '
-----BEGIN PGP PUBLIC KEY BLOCK-----
Comment: User-ID:	Osint
Comment: Valid from:	02/11/2023 2:11 am
Comment: Type:	4,096-bit RSA (secret key available)
Comment: Usage:	Signing, Encryption, Certifying User-IDs, SSH Authentication
Comment: Fingerprint:	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
+U/UdxiaGjEndwYBvhJy41D5wVg=
=5F+K 
-----END PGP PUBLIC KEY BLOCK-----';

$publKeyStr =  rsaPublic::fromString($publicKey);

        $user = auth()->user();
        return view('User.canary', [
            'user' => $user,
            'parentCategories' => Category::whereNull('parent_category_id')->get(),
            'subCategories' => Category::whereNotNull('parent_category_id')->get(),
            'categories' => Category::all(),
            'icon' => GeneralController::encodeImages(),
            'messenc' => $publKeyStr->encrypt('hello world from whales market'),
            'publickey' => $publicKey,
        ]);
    }

    public function pgpKeySystem(Request $request)
    {
        return "Working on it.";
    }




    public static function generateKeyPair()
    {
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
}
