<style>
    .container-team {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        color: #ecf0f1;
        font-family: 'Arial', sans-serif;
    }

    .member {
        width: 300px;
        margin: 20px;
        background-color: #34495e;
        border-radius: 10px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .member:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
    }

    .member img {
        width: 100%;
        height: auto;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
    }

    .member-details {
        padding: 15px;
    }

    .member-name {
        font-size: 22px;
        font-weight: bold;
        margin-top: 10px;
    }

    .member-role {
        font-size: 18px;
        color: #95a5a6;
        margin-top: 5px;
    }
</style>
<div class="main-div">
    <div class="notific-container">
        <form action="" method="post">
            @csrf
            <div class="container-team">
                <div class="member">
                    <img src="data:image/png;base64,{{ $icon['osint'] }}">
                    <div class="member-details">
                        <div class="member-name">White Theme</div>
                        <div class="member-role">Active</div>
                    </div>
                </div>
                <button class="member" style="submit">
                    <img src="data:image/png;base64,{{ $icon['osint'] }}">
                    <div class="member-details">
                        <div class="member-name">Whale Theme</div>
                        <div class="member-role">Under Developement</div>
                    </div>
                </button>
                <div class="member">
                    <img src="data:image/png;base64,{{ $icon['osint'] }}">
                    <div class="member-details">
                        <div class="theme-name">Dark Theme</div>
                        <div class="member-role">In Active</div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
