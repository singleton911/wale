<style>
    body {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }
    
    form {
      max-width: 500px;
      text-align: center;
    }
    
    h1 {
      font-size: 2em;
      margin-bottom: 1em;
    }
    
    textarea {
      width: 100%;
      height: 10em;
      padding: 0.5em;
      border: 2px solid #0b3996;
      margin-bottom: 1em;
      border-radius: 0.5rem;
      box-sizing: border-box;
    }
    textarea:focus{
        outline-color: #238c4b;
    }
    .two-btns {
      display: flex;
      justify-content: space-between;
      margin-top: 2em;
    }
    
    input[type=submit] {
      background-color: #2f9b5a;
      color: #fff;
      padding: 0.5em 1em;
      border: none;
      border-radius: 5px;
      font-size: 1.2em;
      cursor: pointer;
      transition: background-color 0.2s ease-in-out;
      border-radius: 0.5rem;
      box-shadow: 0 1px 1px 0 rgba(48, 48, 48, .30), 0 1px 3px 1px rgba(48, 48, 48, .15);
      box-sizing: border-box;
    }
    
    input[type=submit]:hover {
      background-color: #238c4b;
    }
    
    input[name=skip-for-now] {
      background-color: #eee;
      color: #444;
    }
    
    input[name=skip-for-now]:hover {
      background-color: #ccc;
    }
    </style>
    
    
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>WHALES MARKET - ADD PGP KEY</title>
    <body>
    
      <form action="" method="post">
        <h1>ADD PGP KEY<span style="color: red;">*</span></h1>
        <div style="margin: 10px;">
    <?php
    
    use app\Models\pgp\PGPKeyManager;
    use app\Models\User\User;
    
    if (isset($_POST['skip-for-now'])) {
        header("Location: /");
    }elseif (isset($_POST['pgp_key_text'])) {
    
      echo "<span>Skip this process for now.</span>";
      // Example usage:
    // $publicKeyData = validateUserInput($_POST['save-key'], $conn);
    // $name = User::findByID($conn, $_SESSION['user_id'])->publicName;
    
    
    // $verifyResult = PGPKeyManager::verifyPublicKey($name, $publicKeyData);
    // if (strpos($verifyResult, 'Key verification succeeded') !== false) {
    //     $privateKeyData = '-----BEGIN PGP PRIVATE KEY BLOCK ...'; // Replace with actual private key data
    //     $message = 'Hello, this is a test message.';
    
    //     $signedMessage = PGPKeyManager::signMessage($privateKeyData, null, $message); // Passphrase is optional
    
    //     if (strpos($signedMessage, 'Failed') === 0) {
    //         echo "Message signing failed: $signedMessage";
    //     } else {
    //         echo "Signed Message: \n$signedMessage\n";
    //     }
    // } else {
    //     echo "Public key verification failed: $verifyResult";
    // }
      
    }
    ?>
    
    </div>
        <textarea name="pgp_key_text" id="" cols="60" rows="10" placeholder="-----BEGIN PGP PUBLIC KEY BLOCK----- ...,                    The User-ID must be the same as your Public Name..."></textarea>
        <div class="two-btns">
          <input type="submit" name="skip-for-now" value="Skip">
          <input type="submit" name="save-key" value="Save">
        </div>
      </form>
    </body>
    
    