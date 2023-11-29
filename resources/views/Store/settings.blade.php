

<legend>Store Settings (Edit)</legend>
<form action="" method="post" class="form-container">
    <label for="store_description" class="form-label">Store Description (Bio):</label>
    <textarea id="store_description" class="form-textarea" name="store_description" required placeholder="Store bio...">{{ $store->store_description }}</textarea>

    <label for="store_description" class="form-label">Store PGP key:</label>
    <textarea id="store_pgp" name="store_pgp"  class="form-textarea" required placeholder="-----BEGIN PGP PUBLIC KEY BLOCK-----        -----END PGP PUBLIC KEY BLOCK-----">{{ $store->store_pgp }}</textarea>

    <label for="store_description" class="form-label">Selling:</label>
    <textarea id="store_pgp" name="selling"  class="form-textarea" required placeholder="Selling">{{ $store->selling }}</textarea>

    <label for="store_description" class="form-label">Ship From:</label>
    <textarea id="store_pgp" name="ship-from"  class="form-textarea" required placeholder="Ship from default 'unkwonn'">{{ $store->ship_from }}</textarea>

    <label for="store_description" class="form-label">Ship To:</label>
    <textarea id="store_pgp" name="ship-to"  class="form-textarea" required placeholder="Ship to default 'Worldwide'">{{ $store->ship_to}}</textarea>

    <label for="store_description" class="form-label">Store Status:</label>
    <select name="store_status" class="form-select" id="">
        <option value="{{ $store->status }}" style="text-transform: capitalize;">{{ $store->status }}</option>
        <option value="{{ ($store->status == 'active' ? 'vacation' : 'active') }}">{{ $store->status == 'active' ? 'Vacation' : 'Activate' }}</option>
    </select>

    <input type="number" id="security-code" class="form-input" name="security-code" placeholder="Enter security code" required>
    <input type="submit" class="submit-nxt"  name="" value="Save Changes">
</form>