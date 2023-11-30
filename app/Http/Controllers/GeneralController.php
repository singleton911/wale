<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\Label\LabelAlignment;
use Endroid\QrCode\Label\Font\NotoSans;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\PngWriter;

use OpenPGP;
use OpenPGP_Crypt_RSA;
use OpenPGP_Crypt_Symmetric;
use OpenPGP_Message;
use OpenPGP_Packet;
use OpenPGP_PublicKeyPacket;
use OpenPGP_S2K;

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
        // Open an image file
        $image = Image::make($file);

        // Encode the image to a different format to remove metadata
        $image->encode('data-url');

        // Use hashName() to generate a unique, hashed filename
        $uniqueFilename = time() . '_' . $file->hashName();

        // Save the modified image in the specified folder
        $imagePath = $image->save(storage_path("app/public/{$folder}/" . $uniqueFilename));

        return $imagePath;
    }


    public function generateQrCode()
    {
        $result = Builder::create()
            ->writer(new PngWriter())
            ->writerOptions([])
            ->data('Custom QR code contents')
            ->encoding(new Encoding('UTF-8'))
            ->errorCorrectionLevel(ErrorCorrectionLevel::Low)
            ->size(300)
            ->margin(10)
            ->roundBlockSizeMode(RoundBlockSizeMode::Margin)
            ->logoResizeToWidth(50)
            ->logoPunchoutBackground(true)
            ->labelFont(new NotoSans(20))
            ->labelAlignment(LabelAlignment::Center)
            ->validateResult(false)
            ->build();

        return ['qrcode' => $result->getDataUri()];
    }


    public function EncryptPGPMessage(Request $request)
    {
        // try {
        //     // Generate a random verification code
        //     $verificationCode = random_int(10, 20);

        //     // Construct the message
        //     $message = 'Your Whales Market verifying Code Is: ' . $verificationCode;

        //     // Get the PGP public key from the request
        //     $pubkey = $request->input('pgp_key_tex');

        //     // Parse the PGP public key
        //     $key = OpenPGP_Message::parse(
        //         OpenPGP::unarmor($pubkey, 'PGP PUBLIC KEY BLOCK')
        //     );

        //     // Create a literal data packet with the message
        //     $data = new OpenPGP_LiteralDataPacket($message, ['format' => 'u']);

        //     // Encrypt the message
        //     $encrypted = OpenPGP_Crypt_Symmetric::encrypt(
        //         $key,
        //         new OpenPGP_Message([$data])
        //     );

        //     // Armor the encrypted message
        //     $armored = OpenPGP::enarmor($encrypted->to_bytes(), 'PGP MESSAGE');

        //     // Redirect back with the encrypted message
        //     return redirect()->back()->with('encryptedMessage', $armored);
        // } catch (\Exception $e) {
        //     // Handle exceptions (e.g., log or display an error)
        //     return redirect()->back()->with('error', 'Error encrypting message: ' . $e->getMessage());
        // }
    }

    /**
     * Validate a PGP key and extract information.
     *
     * @param string $pgpKey The PGP key to validate and extract information from.
     * @return array|null An array containing extracted information or null if the key is invalid.
     */
    public function validateAndExtractInfo(Request $request)
    {
        $privateKey = new OpenPGP;
        return dd();
        //return dd($request);
    }



    public function search(Request $request)
    {
        $searchType = $request->input('search_type');
        $productName = $request->input('pn');
        $minPrice = $request->input('pf');
        $maxPrice = $request->input('pt');
        $sortBy = $request->input('filter-product');
        $categoryId = $request->input('category');
        $productType = $request->input('pt2');
    
        // Choose the model based on the search type
        $model = $searchType === 'store' ? Store::query() : Product::query();
    
        // Build your search query based on the input parameters
        $query = $model;
    
        if ($productName) {
            $query->where('name', 'like', '%' . $productName . '%');
        }
    
        if ($minPrice) {
            $query->where('price', '>=', $minPrice);
        }
    
        if ($maxPrice) {
            $query->where('price', '<=', $maxPrice);
        }
    
        // Add more conditions based on other form inputs...
    
        // Execute the query
        $results = $query->get();
    
        // Pass the results to your view or do whatever you want with them
        return view('User.search', ['products' => $results, 'resultType' => $searchType]);
    }  
    
    
    public function team(){
        $user = auth()->user();
        return view('User.team', [
            'user' => $user,
            'parentCategories' => Category::whereNull('parent_category_id')->get(),
            'subCategories' => Category::whereNotNull('parent_category_id')->get(),
            'categories' => Category::all(),
            'icon' => GeneralController::encodeImages(),
        ]);
    }


    public function canary(){
        $user = auth()->user();
        return view('User.canary', [
            'user' => $user,
            'parentCategories' => Category::whereNull('parent_category_id')->get(),
            'subCategories' => Category::whereNotNull('parent_category_id')->get(),
            'categories' => Category::all(),
            'icon' => GeneralController::encodeImages(),
        ]);
    }
}
