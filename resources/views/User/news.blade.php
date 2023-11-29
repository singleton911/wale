<div class="container">
    <div class="main-div">
        <div class="dir">
            <div class="dir-div">
                <a href="{{ url()->current() }}" style="font-size:.8rem;">/</a> }}---
                <span style="color: darkgreen; font-size:.8rem;">Your login phrase is
                    `{{ $user->login_passphrase }}`</span>
            </div>
            <div class="prices-div">
                <span>BTC/USD: <span class="usd">$0.00</span></span>
                <span>XMR/USD: <span class="usd">$0.00</span></span>
            </div>

        </div>
        <div class="top-div">
            <div style="display: flex; gap:1em;" >
                <div  class="left-news-div">
                    <div>
                        <a href="">How to make it</a>
                    </div>
                    <div>
                        <a href="">How to make it</a>
                    </div>
                </div>
                <div class="news-div">
                    <h2 class="news-title" style="">{{ $news->title }}</h2>

                    <div style="text-align: center; margin-bottom: 1em; font-size: .8rem; color: #acacac;">
                        Last updated on <span>{{ $news->created_at->format('l jS \o\f F Y') }}</span> by 
                        <span
                            class="{{ $news->user->role }}">/{{ $news->user->role }}/{{ $news->user->public_name }}</span>
                        
                    </div>
                    <p class="news-content">{{ $news->content }} </p>
                </div>
            </div>
        </div>
    </div>
</div>
