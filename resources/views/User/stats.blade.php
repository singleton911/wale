<div class="main-div">
    <div class="notific-container">
        
    </div>
</div>



<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f0f0f0;
        /* Set a background color for the body */
        margin: 0;
        /* Remove default margin */
        padding: 0;
        /* Remove default padding */
    }

    .chat-container {
        display: flex;
        flex-flow: column nowrap;
        max-height: 20em;
        overflow-y: scroll;
    }

    .chat-message {
        margin: 10px 0;
        position: relative;
        display: block;
        max-width: 100%;
        /* Full width for left messages */
    }

    .chat-message p {
        margin: 5px 0;
        padding: 10px;
        border-radius: 8px;
    }

    .chat-message-right {
        text-align: right;
        margin-left: auto;
        /* Pushes the right messages to the right */
        max-width: 75%;
        /* Maximum width for right messages */
    }

    .chat-message-left {
        text-align: left;
        margin-right: auto;
        max-width: 75%;
        /* Full width for left messages */
    }

    .owner {
        font-size: 0.8em;
        color: #555;
        /* Change the color of the owner text */
        margin: 5px 0;
        /* Add some margin for spacing */
    }

    /* Customize the colors as needed */
    .chat-message-right p:first-child {
        background-color: #5cb85c;
        color: #fff;
    }

    .chat-message-left p:first-child {
        background-color: #d3d3d3;
        color: #333;
    }

    .chat-message-left p:last-child,
    .chat-message-right p:last-child {
        margin: 0;
        padding: 2px;
    }
</style>



{{-- <body  = 'footer'"> --}}
<div class="chat-container">
    <div class="chat-message chat-message-right">
        <p><span>Hi all. Just wanted to let you all know that we will be heading out for lunch on Friday
                next week</span></p>
        <p class="owner">Daniel Sun 27/2/22 10:20 am</p>
    </div>
    <div class="chat-message chat-message-left">
        <p><span style="">Cool, can't wait!</span></p>
        <p class="owner">Cath Sun 27/2/22 10:25 am</p>
    </div>
    <div class="chat-message chat-message-right">
        <p><span style="">????</span></p>
        <p class="owner">James Sun 27/2/22 10:39 am</p>
    </div>
    <div class="chat-message chat-message-right">
        <p><span style="">I can't make it sorry, thanks for the invite though.</span></p>
        <p class="owner">Mary Sun 27/2/22 10:45 am</p>
    </div>
    <div class="chat-message chat-message-right">
        <p><span style="">All good Mary, thanks for letting me know.</span></p>
        <p class="owner">Daniel Sun 27/2/22 2:49 pm</p>
    </div>
    <div class="chat-message chat-message-left">
        <p><span style="">Hey Daniel, will there be vegetarian options available?</span></p>
        <p class="owner">Cath Mon 28/2/22 8:58 am</p>
    </div>
    <div class="chat-message chat-message-right">
        <p><span style="">Yes they cater to vegetarians and vegans. There is a menu online, I'll
                email you further details</span></p>
        <p class="owner">Daniel Mon 28/2/22 9:05 am</p>
    </div>
    <div class="chat-message chat-message-left">
        <p><span style="">Thanks!</span></p>
        <p class="owner">Cath Mon 28/2/22 10:41 am</p>
    </div>
    <div class="chat-message chat-message-right">
        <p><span style="">I'm off for a run</span></p>
        <p class="owner">James Mon 28/2/22 12:30 pm</p>
    </div>
</div>
{{-- </body> --}}



