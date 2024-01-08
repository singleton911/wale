<style>

    /* Style the container */
    .container {
        position: relative;
        align-items: center;
        align-content: center;
        justify-content: center;
        margin: auto;
        width: 50vw;
        border-radius: 0.5rem;
        box-shadow: var(--shadow);
        box-sizing: border-box;
        padding: 20px;
        margin-bottom: 2rem;
        background-color: var(--secondary-white-bg);
        color: var(--dark-color-text) !important;
    }

    /* Style the top section */
    .cls-1 {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .cls-1 img {
        height: 40px;
    }

    .cls-1 h3 {
        font-family: Verdana, Geneva, Tahoma, sans-serif;
        font-size: 1.5rem;
        color: var(--main-color);
    }

    /* Style the heading */
    h3 {
        font-size: 1.2rem;
        font-weight: bold;
        margin-top: 1.5rem;
        margin-bottom: 1rem;
        color: var(--main-color);
    }

    p {
        color: var(--dark-color-text) !important;
        font-family: 'Courier New', Courier, monospace;
        font-weight: 600;
        line-height: 20px;
        word-break: 5px;
    }

    .general-rules>h3::after {
        content: "\1F50D";
        color: red;
        width: 30px;
        height: 30px;
        text-align: center;
        font-size: 1.5rem;
    }

    span {
        color: #0b3996;
    }

    /* Style the rules list */
    ol {
        margin-left: 1.5rem;
    }

    ol li {
        margin-bottom: 0.5rem;
        color: var(--dark-color-text) !important;
        font-family: 'Courier New', Courier, monospace;
        font-weight: 500;
        line-height: 20px;
        word-break: 5px;
    }

    .how-to-wiki>h3::after {
        content: "\2764";
        color: red;
        width: 30px;
        height: 30px;
        text-align: center;
        font-size: 1.5rem;
    }

    /* Style the submit buttons */
    input[type="submit"] {
        background-color: var(--main-color);
        border: none;
        color: #ddd;
        font-size: 1rem;
        font-weight: bold;
        padding: 0.5rem 1rem;
        border-radius: 5px;
        cursor: pointer;
        transition: all 0.2s;
    }

    input[type="submit"]:hover {
        background-color: #08418a;
    }

    /* Style the payment section */
    .payment {
        margin-top: 2rem;
        border-top: 1px solid #c1c1c1;
        padding-top: 2rem;
    }

    .payment p {
        margin-bottom: 1rem;
    }

    .payment li {
        margin-bottom: 0.5rem;
    }

    .payment span {
        color: var(--main-color);
    }

    .store>h3::after {
        content: "\1F3EC";
        text-align: center;
        font-size: 1.1rem;
        line-height: 1;
        width: 20px;
        height: 20px;
        color: #0b3996;
    }

    .highly-recommend-stuffs>h3::after {
        content: "\2714";
        text-align: center;
        font-size: 1.5rem;
        line-height: 1;
        width: 20px;
        height: 20px;
        color: #0b3996;
    }

    .payment>h3::after {
        content: "\1F4B0";
        text-align: center;
        font-size: 1.5rem;
        line-height: 1;
        width: 20px;
        height: 20px;
        color: #0b3996;
    }

    /* Style the recommended list */
    .highly-recommend-stuffs ol {
        /* list-style-type: none; */
        list-style: square;
        padding-left: 0;
    }

    .highly-recommend-stuffs li {
        margin-bottom: 0.5rem;
    }

    .highly-recommend-stuffs input[type="submit"] {
        background-color: transparent;
        color: var(--main-color);
        border: none;
        padding: 0;
        text-decoration: underline;
        font-size: 1rem;
        font-weight: bold;
        cursor: pointer;
        transition: all 0.2s;
    }

    .highly-recommend-stuffs input[type="submit"]:hover {
        color: #08418a;
    }

    .complete label {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 1.2rem;
        color: var(--dark-color-text) !important;
    }

    .complete input[type="checkbox"] {
        appearance: none;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        border: 2px solid #555;
        outline: none;
        cursor: pointer;
    }

    .complete input[type="checkbox"]:checked::before {
        content: "\2714";
        display: block;
        text-align: center;
        font-size: 1.5rem;
        line-height: 1;
        color: var(--dark-color-text) !important;
        background-color: #555;
        border-radius: 50%;
        width: 20px;
        height: 20px;
    }

    .complete input[type="checkbox"]:focus-visible {
        box-shadow: 0 0 0 2px #ddd;
    }
</style>

<form action="/market/welcome/{{ $user->public_name }}/read" method="post">
    @csrf
    <div class="container">
        <div class="cls-1">
            <img src="" alt="🤝" srcset="" style="font-size: 2em;">
            <h3>WELCOME, {{ $user->public_name }}</h3>
        </div>
        <hr>
        <div class="general-rules">
            <h3>General Site Rules</h3>
            <ol>
                <li>Always treat other users with respect and kindness.</li>
                <li>Provide fair and honest feedback, understand possible issues on the other end. </li>
                <li>Describe your goods properly, tell others the truth while maintaining your OPSEC standards.
                </li>
                <li>Report violations, provide guidance for those in need. We are stronger together. </li>
                <li>Everything related to cp(child porn), racism, weapons, poisons and scam is strictly forbidden.
                </li>
                <li> Insults, personal attacks or any similar negative behavior is not being tolerated. </li>
                <li>Performing un wanted actions on the website is strictly forbidden (E.g.,Editing forms, send bad requests, ....).</li>
                <li>For every 404 page you sow will be recoded and this will cause your account to be banned by our auto ban system!</li>
            </ol>
        </div>
        <div>
            <h3>Vendors Account ~ Stores</h3>
            <p>What is a store in the Whales Marketplace? A store is like being a vendor in any other market. Store
                bonds cost <span>2 XMR</span>, which is non-refundable to protect Whales Market from scammers. </p>
            <p>To pay for a store bond, you need to:</p>
            <ol>
                <li>Have a PGP key in your market account and Enable 2FA!!!</li>
                <li>Deposit money into your market wallet.</li>
                <li>Go to "Settings > Wallet > Deposit" and follow the instructions.</li>
                <li>Go to "Settings > Store Key" and click on it to read every detail of the Store Rules.</li>
                <li>Answer some questions.</li>
                <li>Proceed to accept and pay.</li>
                <li>If your wallet has the required sum of 2 XMR, you will receive a notification with your store
                    key.</li>
                <li>After that copy the key into your computer note pad.</li>
                <li>Then click on the "store + icon" then enter the key if the key is valid you will be ask to
                    provide your store info.</li>
            </ol>
        </div>
        <div class="highly-recommend-stuffs">
            <h3>Highly Recommended Things</h3>
            <ol>
                <li>Use only "Tail OS" to access DW, search on google if you don't know about it.</li>
                <li>PGP keys (Enabling 2FA) are highly recommended.</li>
                <li>Disabling Javascript is highly recommended.</li>
                <li>If you are new to the DW read the "Drugs User Bible and DarkNet User Bible" you can find it on dread forum!</li>
                <li>Be part of our community on dread forum "any_dread_url/whalesMarket".</li>
                <li>Always stay sefe.</li>
            </ol>
        </div>
        <div class="payment">
            <h3>Payment Method</h3>
            <p>For the safety and privacy of our customers, Whales market accepts only Monero cryptocurrency as
                payment. This is because:</p>
            <ol>
                <li>Monero offers greater anonymity and privacy compared to other cryptocurrencies like Bitcoin.
                </li>
                <li>Transactions made with Monero are untraceable and cannot be linked to the user's identity.</li>
                <li>Monero uses advanced cryptography to ensure the security of transactions.</li>
            </ol>
            <p>These are only few thing Why we accept monero as a payment method.</p>
        </div>
        <div class="complete">
            <label>
                <input type="checkbox" name="understood" required>
                <span>I have read everything and understood, and I agree to the rules.</span>
            </label>
            <div style="text-align: center;">
                <input type="submit" name="proceed-next" value="Proceed">
            </div>
        </div>
    </div>
</form>
