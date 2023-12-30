<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Whales Market | {{ $user->public_name }} > Market Canary</title>
    <link rel="stylesheet" href="{{ asset('market.white.css') }}">
    <link rel="stylesheet" href="{{ asset('filter.css') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
</head>

<body>
    @include('User.navebar')
    <div class="container">
        <div class="main-div">
            <div class="notific-container">
                <header>
                    <h1>Frequently Asked Questions</h1>
                  </header>
                  <main>
                    <section class="faq-section">
                      <details>
                        <summary>How does this service work?</summary>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam faucibus sapien eu neque sagittis, ut ullamcorper lectus condimentum.</p>
                      </details>

                      <details>
                        <summary>What are the benefits of using this service?</summary>
                        <p>Maecenas semper eros quis leo euismod, eget elementum odio faucibus. Sed eu mauris et eros ullamcorper accumsan.</p>
                      </details>

                      <details>
                        <summary>What are the pricing options?</summary>
                        <p>Donec tincidunt mauris lectus, vitae scelerisque quam ullamcorper eget. Nullam faucibus sapien eu neque sagittis.</p>
                      </details>
                      </section>
                  </main>
            </div>
        </div>
    </div>
    <style>
        h1{
            text-align: center;
        }
/* FAQ-specific styles */
.faq-section {
  padding: 2em;
}

details {
  margin-bottom: 1em;
  border-radius: 8px;
  box-shadow: var(--shadow);
}

summary {
  padding: 1em;
  font-weight: bold;
  cursor: pointer;
  transition: background-color 0.3s ease-in-out;
}

summary:hover {
  background-color: var(--bg-secondary);
}

/* Optional accordion-style behavior */
details[open] summary {
  background-color: var(--bg-secondary);
}

/* details[open] > p {
  max-height: 0;
  overflow: hidden;
  transition: max-height 0.3s ease-in-out;
} */

p{
  transition: max-height 0.3s ease-in-out;
  display: block;
  height: 4px;

}


    </style>
    @include('User.footer')
</body>

</html>
