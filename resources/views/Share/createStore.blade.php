<h3>Creating New Store</h3>
<hr>
@if ($errors->any())
    <ul style="list-style: none">
        @foreach ($errors->all() as $error)
            <li style="color:red;">{{ $error }}</li>
        @endforeach
    </ul>
@endif
@if (session('success'))
    <p style="color:green; text-align:center;">{{ session('success') }}</p>
@endif
@if ($user->store_status == 'in_active')
<div>
    <form action="" method="post" enctype="multipart/form-data">
        @csrf
        <span style="color: red;">Remove all meta data from your images!</span><br><br>
        <input type="text" name="storeName" placeholder="Your store name...(*)" required><br><br>
        <div style="border:1px solid gray; margin:.2em; border-radius:.5rem; text-align:left; padding: .5em"> Store
            Profile Image*:
            <input type="file" name="storeProfile" accept="image/png, image/jpeg, image/jpg" required>
        </div><br>
        <input type="text" name="selling"
            placeholder="What are you going to sell on Whales Market? Use commas (,) to separate the words."><br><br>
        <input type="text" name="shipto"
            placeholder="Where will you ship to? Default: (Worldwide). Use commas (,) to separate the countries."><br><br>
        <input type="text" name="shipfrom"
            placeholder="Where do you ship your products from? Default: (Unknown). Only 1 country needed!"><br><br>
        <textarea name="storeDesc" cols="30" rows="10" style="width: 100%; margin-bottom: 1em;"
            placeholder="Your Store description..." required></textarea>
        <textarea name="sellOn" cols="30" rows="10" style="width: 100%;"
            placeholder="Which markets do you have products on...(Required for old vendors)"></textarea>
        <p><span style="color: red;">Proof of product ownership: Your store name + Whales Market + timestamp! Be a great
                vendor, do it in bulk. ^_~</span>
        </p>
        <div style="border:1px solid gray; margin:.2em; border-radius:.5rem; text-align:left; padding: .5em">Products
            proof 1:
            <input type="file" name="proof1" accept="image/png, image/jpeg, image/jpg" required>
        </div>
        <div style="border:1px solid gray; margin:.2em; border-radius:.5rem; text-align:left; padding: .5em">Products
            proof 2:
            <input type="file" name="proof2" accept="image/png, image/jpeg, image/jpg" required>
        </div>
        <div style="border:1px solid gray; margin:.2em; border-radius:.5rem; text-align:left; padding: .5em">Products
            proof 3:
            <input type="file" name="proof3" accept="image/png, image/jpeg, image/jpg" required>
        </div>
        <input type="submit" name="sbmit-form" class="submit-nxt" value="Send">
    </form>
</div>

@elseif ($user->store_status == 'pending')
<style>
    .lds-ring {
        display: inline-block;
        position: relative;
        width: 80px;
        height: 80px;
    }

    .lds-ring div {
        box-sizing: border-box;
        display: block;
        position: absolute;
        width: 64px;
        height: 64px;
        margin: 10px;
        border: 7px solid #0b3996;
        border-radius: 50%;
        animation: lds-ring 1.2s cubic-bezier(0.5, 0, 0.5, 1) infinite;
        border-color: #0b3996 transparent transparent transparent;
    }

    .lds-ring div:nth-child(1) {
        animation-delay: -0.45s;
    }

    .lds-ring div:nth-child(2) {
        animation-delay: -0.3s;
    }

    .lds-ring div:nth-child(3) {
        animation-delay: -0.15s;
    }

    @keyframes lds-ring {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    .container-ring {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    .status {
        text-align: center;
        margin-top: 20px;
        font-family: Verdana, Geneva, Tahoma, sans-serif;
    }

    .status h1 {
        font-size: 24px;
        font-weight: bold;
    }

    .status h2 {
        font-size: 18px;
    }
</style>
<div class="container-ring">
    <div class="lds-ring">
        <div></div>
        <div></div>
        <div></div>
    </div>
    <div class="status">
        <h1>You have successfully created a store. It is under review.</h1>
        <p style="text-align: center; color: green;">Admin or Moderators will review your store as soon as possible they will message you!</p>
        <h2>*^____^*</h2>
    </div>
    </div>
</div>
@endif
