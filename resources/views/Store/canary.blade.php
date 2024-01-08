
        <div class="notific-container">
            <h1>Canary's</h1>
            {{-- @foreach ($canaries as $canary) --}}
                <div class="canary-div">
                    <p>Title</p>
                    <p>contents</p>
                </div>
            {{-- @endforeach --}}
        </div>
    </div>


<style>
    h1{
        text-align: center;
        color: var(--main-color);
    }


.canary-div {
margin-bottom: 1.4em;
border-radius: 8px;
box-shadow: var(--shadow);
color: var(--dark-color-text);
border: 1px solid grey;
border-radius: .5rem;
}

p{
color: var(--dark-color-text);
margin-left: 2em;
margin-bottom: 1em;
word-wrap: break-word;

}


</style>