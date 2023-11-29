<style>
    .container-pgp {
        display: flex;
        justify-content: center;
        border-radius: .5rem;
    }

    form {
        max-width: 500px;
        text-align: center;
    }

    h1 {
        color: #443;
        font-size: 1.2em;
        margin-bottom: 1em;
        font-family: Verdana, Geneva, Tahoma, sans-serif;
    }

    textarea {
        width: 100%;
        height: 50vh;
        padding: 0.5em;
        border: none;
        margin-bottom: 1em;
        border-radius: 0.5rem;
        box-sizing: border-box;
        outline: none;
        border-radius: 0.5rem;
        box-shadow: 0 1px 1px 0 rgba(48, 48, 48, .30), 0 1px 3px 1px rgba(48, 48, 48, .15);
        box-sizing: border-box;
    }

    textarea:focus {
        border: 1px solid gray;
        outline: none;
    }

    input[type="number"] {
        padding: 15px;
        width: calc(100% - 20%);
        font-family: Verdana, Geneva, Tahoma, sans-serif;
        font-size: 20px;
        color: #444;
        outline: none;
        background-color: white;
        border: none;
        border-radius: 0.5rem;
        box-shadow: 0 1px 1px 0 rgba(48, 48, 48, 0.3),
            0 1px 3px 1px rgba(48, 48, 48, 0.15);
        box-sizing: border-box;
    }

    .two-btns {
        display: flex;
        justify-content: center;
        margin-top: 2em;
    }

    label {
        color: #443;
    }

    .save-pgp {
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
    .save-pgp:hover {
        background-color: #238c4b;
    }

    .close:hover {
        background-color: rgba(224, 8, 8, 0.801);
    }
</style>


<div class="main-div">
    <div class="notific-container">
        <pre>
            {{ session('encryptedMessage') }}
        </pre>
        
        <p>{{ session('error') }}</p>
        <div class="container-pgp">
            <form action="" method="post">
                @csrf
            <h1>PGP KEY [2FA]</h1>
                <textarea name="pgp_key" id="" cols="60" rows="10" placeholder="-----BEGIN PGP PUBLIC KEY BLOCK----- ...,                    The User-ID must be the same as your Public Name..."></textarea><br><br>
                {{-- <input type="number" name="secret-code" placeholder="Enter Secret code"><br><br> --}}
                {{-- <div id="capatcha-code-img">
                        <img src="/captcha" alt="none yet" srcset="">
                        <input type="text" id="captcha" maxlength="6" minlength="6" name="captcha" placeholder="Captcha">
                </div><br> --}}
                {{-- <label for="2fa" title="If you enable 2FA when loggin you need to decrept a pgp sign message to log in!">Enable 2FA? 
                    <input type="checkbox" title="If you enable 2FA when loggin you need to decrept a pgp sign message to log in!" class="enable2fa" name="updating2fa">
                </label> --}}
                <div class="two-btns">
                    <input type="submit" class="save-pgp" value="Update">
                </div>
            </form>
        </div>
    </div>
</div>