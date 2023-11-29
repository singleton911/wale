<div class="first-container">
    <legend style="font-family: Verdana, Geneva, Tahoma, sans-serif; font-size: 2rem; text-align: center;">Physical
        Product Information</legend>

</div>
@if(session('success') != NULL)
    {{ session('success') }}
@endif
<div>
    @if ($errors->any())
        <ul style="margin: auto; list-style-type: none; padding: 0; text-align: center;">
            @foreach ($errors->all() as $error)
                <li style="color: red;">{{ $error }}</li>
            @endforeach
        </ul>
    @endif

</div>
<form method="post" class="form-container" enctype="multipart/form-data">

    @csrf

@if (session('next-form'))
    

    <table>
        <tr>
            <th>Shipping Extra/Options (Blank is free)</th>
            <th>Cost</th>
        </tr>
        <tr>
            <td><input type="text" class="form-input" name="shipping_method1" placeholder="Shipping Option"></td>
            <td><input type="number" class="form-input" name="shipping_cost1" min="0" placeholder="Price">
            </td>
        </tr>
        <tr>
            <td><input type="text" class="form-input" name="shipping_method2" placeholder="Shipping Option"></td>
            <td><input type="number" class="form-input" name="shipping_cost2" min="0" placeholder="Price">
            </td>
        </tr>
        <tr>
            <td><input type="text" class="form-input" name="shipping_method3" placeholder="Shipping Option"></td>
            <td><input type="number" class="form-input" name="shipping_cost3" min="0" placeholder="Price">
            </td>
        </tr>
        <tr>
            <td><input type="text" class="form-input" name="shipping_method4" placeholder="Shipping Option"></td>
            <td><input type="number" class="form-input" name="shipping_cost4" min="0" placeholder="Price">
            </td>
        </tr>
        <tr>
            <td><input type="text" class="form-input" name="shipping_method5" placeholder="Shipping Option"></td>
            <td><input type="number" class="form-input" name="shipping_cost5" min="0" placeholder="Price">
            </td>
        </tr>
        <tr>
            <td><input type="text" class="form-input" name="shipping_method6" placeholder="Shipping Option"></td>
            <td><input type="number" class="form-input" name="shipping_cost6" min="0" placeholder="Price">
            </td>
        </tr>
        <tr>
            <td><input type="text" class="form-input" name="shipping_method7" placeholder="Shipping Option"></td>
            <td><input type="number" class="form-input" name="shipping_cost7" min="0" placeholder="Price">
            </td>
        </tr>
        <tr>
            <td><input type="text" class="form-input" name="shipping_method8" placeholder="Shipping Option">
            </td>
            <td><input type="number" class="form-input" name="shipping_cost8" min="0" placeholder="Price">
            </td>
        </tr>
        <tr>
            <td><input type="text" class="form-input" name="shipping_method9" placeholder="Shipping Option">
            </td>
            <td><input type="number" class="form-input" name="shipping_cost9" min="0" placeholder="Price">
            </td>
        </tr>
        <tr>
            <td><input type="text" class="form-input" name="shipping_method10" placeholder="Shipping Option">
            </td>
            <td><input type="number" class="form-input" name="shipping_cost10" min="0" placeholder="Price">
            </td>
        </tr>
    </table>
    <input type="submit" name="done" class="submit-nxt" value="Done">

    @else

    <label for="product_name" class="form-label">Product Name:</label>
    <input type="text" id="product_name" class="form-input" name="product_name"
        placeholder="Product name should be descriptive" required>

    <span style="text-align: center; color: darkred;">--Sellers are advised to make good documentation for their
        item ( with photo timestames: include a piece of paper with Whale Market, Store Name and date in the
        pictures)</span>

    <label for="product_description" class="form-label">Product Description:</label>
    <textarea id="product_description" class="form-textarea" name="product_description"
        placeholder="Describe your product well here... " required></textarea>

    <label for="price" class="form-label">Price USD:</label>
    <input type="text" id="price" class="form-input" name="price" placeholder="$0.00" required>

    <label for="quantity" class="form-label">Quantity:</label>
    <input type="number" id="quantity" class="form-input" name="quantity" min="1" placeholder="eg, 10000000"
        required>

    <label for="origin_country" class="form-label">Origin Country:
        <select name="ship_from" class="form-select" required="" id="origin_country" required>
            <option value="{{ $store->ship_from }}">Default: ({{ $store->ship_from }})</option>
        </select>
    </label>

    <label for="payment_type" class="form-label">Payment System Type:
        <select name="payment_type" class="form-select" id="" required>
            <option value="Escrow">Escrow</option>
        </select>
    </label>
    <label for="ship_to" class="form-label">Ship To:
        <input type="text" class="form-input" id="ship_to" name="ship_to"
            placeholder="eg. canada, germany.... Default: World Wide " value="WorldWide">
    </label>
    <label for="parent_category" class="form-label">Parent Category:
        <select name="parent_category_id" class="form-select" id="" required>
            <option value="">----Select----</option>
            @foreach ($categories->where('parent_category_id', null) as $category)
                <option value="{{ $category->id }}">
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
    </label>
    <input type="hidden" name="product_type" value="physical">
    <label for="parent_category" class="form-label">Sub Category ( parent category > sub category ):
        <select name="sub_category_id" class="form-select" required="required" title="Please seletct the right sub category, base on your parent category.">
            <option value="">----Select----</option>
            @foreach ($categories->where('parent_category_id', '!=', NULL) as $category)
                <option value="{{ $category->id }}">
                    {{ $category->category }} > {{ $category->name }}
                </option>
            @endforeach
        </select></label>
    <label for="image_path1" class="form-label">First Image (required)<span style="color: red;">*</span>:</label>
    <input type="file" class="form-input" id="image_path1" name="image_path1" accept="image/png, image/jpeg, image/jpg"
        required><br>

    <label for="image_path2" class="form-label">Second Image:</label>
    <input type="file" id="image_path2" class="form-input" name="image_path2"
        accept="image/png, image/jpeg, image/jpg"><br>

    <label for="image_path3" class="form-label">Third Image:</label>
    <input type="file" id="image_path3" class="form-input" name="image_path3"
        accept="image/png, image/jpeg, image/jpg"><br>

    <label for="return_policy" class="form-label">Condition in which return is allow (Optional):</label>
    <input type="text" class="form-input" name="return_policy" placeholder="Write it here this product return policy...">
    <input type="hidden" name="store_id" value="{{ $store->id }}">

    <input type="submit" name="next" class="submit-nxt" value="Next">

    @endif
</form>
