<style>
    h1 {
        text-align: center;
        color: #445;
        font-size: 2em;
        margin-bottom: 1em;
        font-family: Verdana, Geneva, Tahoma, sans-serif;
    }

    p {
        color: #443;
        font-family: Arial, Helvetica, sans-serif;
    }

    form {
        text-align: center;
    }

    input[type="number"],
    input[type="password"],
    input[type="text"] {
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
</style>



<div class="main-div">

    <div class="notific-container">
        <h1>CHANGE PASSWORD</h1>
        @if (session('success'))
        <p style="text-align: center; color:green;">{{ session('success') }}</p>
    @endif
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <p style="text-align: center; color:red;">{{ $error }}</p>
        @endforeach
    @endif
        <form action="" method="POST">
            @csrf
            <input type="password" name="old-passwrd" placeholder="Old password" required><br><br>
            <input type="password" name="new-passwrd" placeholder="New password" required><br><br>
            <input type="password" name="confirm-new-passwrd" placeholder="Confirm New password" required><br><br>
            <input type="number" name="secret_code" placeholder="Enter Secret code" required><br><br>
            <div class="two-btns">
                <input type="submit" class="save-pgp" name="save-pass" value="Save">
            </div>
        </form>
    </div>
</div>
