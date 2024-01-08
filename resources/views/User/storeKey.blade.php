{{-- <p
    style="text-align: center; width: 100%; background-color: darkgreen; padding: 5px; color:#f1f1f1; border-radius: .5rem;">
    Please check you notification you will see a notification that has your store key there!</p>
<p
    style="text-align: center; width: 100%; background-color: darkred; padding: 5px; color:#f1f1f1; border-radius: .5rem;">
    Opps you do not have the required sum of 2 XMR, You currently have 1.8 XMR.</p>

Hello there <br> <br> thank you for opening a store here is your store key <br><br>$currentUser->storeKey<br><br> please
remove all your money [coin] on this market account also complet all orders,
chat or anything you've started because once you've actavated your store you will not be able to access this account any
more. <br><br> please do not replay to this message.<br>
<br><br> Regards <br> AutoMod --}}

<style>
    form {
        text-align: center;
        background-color: inherit;
    }

    h1 {
        color: var(--main-color);
        font-size: 2em;
        margin-bottom: 1em;
        font-family: Verdana, Geneva, Tahoma, sans-serif;
    }

    .accpet-and-continue {
        background-color: #0b3996;
        color: var(--dark-color-text);
        padding: 0.5em 1em;
        border: none;
        border-radius: 5px;
        font-size: 1.2em;
        cursor: pointer;
        transition: background-color 0.2s ease-in-out;
        border-radius: 0.5rem;
        box-shadow: 0 1px 1px 0 rgba(48, 48, 48, .30), 0 1px 3px 1px rgba(48, 48, 48, .15);
        box-sizing: border-box;
        overflow-wrap: break-word;
        margin: 10px;
    }

    ol {
        text-align: left;
        color: var(--dark-color-text);
        font-family: Arial, Helvetica, sans-serif;
    }

    ol>li {
        line-height: 1.8;
        overflow-wrap: break-word;
    }

    .complete label {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 1.2rem;
        color: #0b3996;
    }

    .complete input[type="checkbox"] {
        appearance: none;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        border: 2px solid #0b3996;
        outline: none;
        cursor: pointer;
    }

    .complete input[type="checkbox"]:checked::before {
        content: "\2714";
        display: block;
        text-align: center;
        font-size: 1.5rem;
        line-height: 1;
        color: var(--dark-color-text);
        background-color: #555;
        border-radius: 50%;
        width: 20px;
        height: 20px;
    }

    .complete input[type="checkbox"]:focus-visible {
        box-shadow: 0 0 0 2px #ddd;
    }

    .help-area {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .help-area>span {
        font-size: 1rem;
        font-family: Verdana, Geneva, Tahoma, sans-serif;
        line-height: 2;
        color: var(--dark-color-text);
    }

    .help-area>span>a {
        font-size: 1rem;
    }
</style>

<div class="main-div">
    <div class="notific-container">
        <form action="" method="post">
            @csrf
            <h1>STORE RULES</h1>
            <p>
                @if ($errors->any())
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li style="color:red;">{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif
            </p>
            <p style="color: green; text-align: center;">{{ session('success') }}</p>
            <div class="s-rules">
                <ol>
                    <li>You need to deposite 2 Monero to your account And pgp enable for you to proceed.</li>
                    <li>Wales Market has only 5% commission fee for each successful sale.</li>
                    <li>Store fee is not refundable, To protect our market.</li>
                    <li>No Guns Listings.</li>
                    <li>No CP (Child pornography) Listings.</li>
                    <li>No Covid-19 Vaccien Listings.</li>
                    <li>No Assassination Service.</li>
                    <li>No Explosives, Fentanyl Listings.</li>
                    <li>No Poisons, Acids Listings.</li>
                    <li>Do not create a store to sale any killing stuffs.</li>
                    <li>No Hitmans, Murders, Snuffs is allowed.</li>
                    <li>Do not sell products that will result in a death of others.</li>
                    <li>If you tried to buy you own product, autmatically you will get banned.</li>
                    <li>Store products must be descriptive and unique.</li>
                    <li>Publishing or displaying contact information in a listing, is not allowed.</li>
                    <li>Dealing outside of the market is not allowed, Store caught doing so will result in store banned.</li>
                    <li>If we see 50 bad reviews and we verified it, Your store will get escalated and all the money in your
                        escrow account will be return to the verious owners.</li>
                    <li>If your store got escalated all your products will be hide and no one can reach your store.</li>
                    <li>Digital orders auto-finalize after 4 days if not pending or diputed, and physical orders auto-finalize after 15 days if not pending or disputed.</li>
                    <li>Fernalize earlier is given to verified stores with thousands sales and above 4.5 rating!
                    </li>
                    <li>Store less then 2.5 rating will be banned.</li>
                    <li>If you're not an established vendor with good reviews, you have to take a picture of your product with
                        your store name and Whales market written on a paper near the product.</li>
                    <li>We are all humns so let love, respect each others.</li>
                    <li>These rules are subject to change but if we do change them We'll notice all stores and users.</li>
                    <li>Thank you for reading.</li>
        
                </ol>
            </div>
            {{-- @if ($user->twofa_enable == 'yes') --}}
            <div class="complete">
                <label>
                    <input type="checkbox" name="complete" required>
                    <span>I have read everything and understood, and I agree to the rules.</span>
                </label>
                <input type="submit" class="accpet-and-continue" name="accetp-and-Continue" value="Pay 2 XMR & Continue">
            </div>
            <div class="help-area">
                <span>You need a support? <a href="/ticket">[enter here]</a></span>
                <span>Looking for store waiver? <a href="/store/waiver">[enter here]</a> </span>
            </div>
            {{-- @else
            PLease Enable 2FA to continue...
            @endif --}}
        </form>
    </div>
</div>
