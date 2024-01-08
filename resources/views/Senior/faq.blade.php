
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
<style>
h1{
text-align: center;
color: var(--main-color);
}
/* FAQ-specific styles */
.faq-section {
padding: 2em;
color: var(--dark-color-text);
}

details {
margin-bottom: 1.4em;
border-radius: 8px;
box-shadow: var(--shadow);
color: var(--dark-color-text);
border: 1px solid grey;
border-radius: .5rem;
}

summary {
padding: 1em;
font-weight: bold;
cursor: pointer;
transition: background-color 0.3s ease-in-out;
color: var(--dark-color-text);
font-size: 1.2rem;
}

summary:hover {
background-color: var(--white-background-color);
color: var(--main-color);
}

/* Optional accordion-style behavior */
details[open] summary {
background-color: var(--white-background-color);
color: var(--main-color);
}

/* details[open] > p {
max-height: 0;
overflow: hidden;
transition: max-height 0.3s ease-in-out;
} */

p{
color: var(--dark-color-text);
margin-left: 2em;
margin-bottom: 1em;
word-wrap: break-word;

}


</style>