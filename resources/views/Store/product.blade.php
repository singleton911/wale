@foreach ($store->products as $product)

            {{-- <a href="/store/product/edit/" style="text-decoration: none; background-color: darkgreen; color: #f1f1f1; font-size: 1em; padding: 2px; border-radius: 3px; border: none; cursor: pointer;">Edit</a>  |
            <input type="submit" name="" style="'.($product->status == 'Paused' ? 'background-color: #7FFF00; color: #black;' : 'background-color: darkred; color: #f1f1f1;').' font-size: 1em; padding: 2px; border-radius: 3px; border: none; cursor: pointer;" value="'.($product->status == 'Paused' ? 'Start' : 'Pause').'"> --}}
            

      <div>
      <div class="pname">
          <p>{{ $product->product_name }}</p>
      </div>
      <div class="image">
          <img src="/public/Images/" alt="" srcset="">
      </div>
      <div class="cat-sub">
          <p class="{{ $product->payment_type }}">{{ '{'.$product->payment_type.'}' }}</p>
          <p class="parent-catg">{{ $product->parentCategory->name }}</p>
          <p class="sub-catg">{{ $product->subCategory->name }}</p>
      </div>
      <div class="price">
          <h3>Price: {{ $product->price }} USD</h3>
      </div>
      <div style="margin-bottom: 5px;">
      <span style="background-color: '.
     font-weight: bolder; padding: 2px; color: white; border-radius: 5px;">{{ $product->status }}</span>
      </div>
      <div class="buttons">
        <div>
          {{-- <form action="" method="post" style="margin-bottom: 0px;"> --}}
            <a href="/store/product/edit/" style="text-decoration: none; background-color: darkgreen; color: #f1f1f1; font-size: 1em; padding: 2px; border-radius: 3px; border: none; cursor: pointer;">Edit</a>  |
              <input type="submit" name="" style="background-color: #7FFF00; color: #black; font-size: 1em; padding: 2px; border-radius: 3px; border: none; cursor: pointer;" value="Pause">
           {{-- </form> --}}
        </div>
      </div>
      <hr style="width: 100%; border-radius: 100%; !important">
      <div class="desc">
          <img src="/public/Uploads/" alt="" srcset="">
          <span class="span1">|{{ $product->in_stocks }}|  </span>
          <span class="span2">|{{ $product->sold }}|  </span>
          <span class="span3 trust-level-t{{ $store->trust_level }}">|{{ $store->trust_level }}|</span>
      </div>
      </div>
@endforeach