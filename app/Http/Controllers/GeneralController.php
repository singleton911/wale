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
use OpenPGP_LiteralDataPacket;
use OpenPGP_Message;
use OpenPGP_SecretKeyPacket;
use OpenPGP_PublicKeyPacket;

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

    public function pgpKeySystem(Request $request){
        return "Working on it.";
    }




    public static function generateKeyPair()
    {

    }
}
