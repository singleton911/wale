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
