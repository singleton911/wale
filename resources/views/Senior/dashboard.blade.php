<?php
use app\Models\news\News;
use app\Models\User\User;

?>
<div class="news-div">
            <h3>Daily News </h3>
                <?php
                isset($_SESSION['welcome']) ? $latestNews = News::read(1) : $latestNews = News::getLatest(1);
                
                foreach ($latestNews as $news) {
                    $date = new DateTime($news['created_at']);
                    $formattedDate = $date->format("F j, Y");
                    //echo $news['id'].'<br>';
                    if ($news['title'] == 'Welcome' || $news['title'] == "welcome") {
                        echo '<p><span style="color: #0080ff;">Welcome, '. (isset($currentUser) ? $currentUser->publicName : "") .'</span></p>';
                    } else {
                        echo "<p><span style='color: #0080ff;'>" . $news['title'] . "</span></p>";
                    }
                    $content = $news['content'];
                    if (strlen($content) > 500) {
                        $content = substr($content, 0, strpos($content, ' ', 500));
                        $content .= '...';
                        echo '<a href="/newspaper/'.encodeId($news['id']).'">[Read more]</a>';
                    }
                    echo '<p class="news-content">' . $content . '</p>';
                    echo '<a href="/create/news/">[Create News]</a>';
                    echo '<p id="provided-by">News provided by ' . User::findByID($conn, $news['author_id'])->publicName .' '. $formattedDate .'</p>';
                }
                ?>
        </div>
<div class="latest-orders">
    <div class="title-latest">
        <h4>Store Open Tickets</h4>
        <div class="view-latest">
            <a href="?action=view-all-store-tickets">VIEW ALL</a>
        </div>
    </div>
    <div>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Store</th>
                    <th>Resolved By</th>
                    <th>Subject</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>No ticket found</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<div class="latest-orders">
    <div class="title-latest">
        <h4>Market Open Tickets</h4>
        <div class="view-latest">
            <a href="?action=view-all-market-tickets">VIEW ALL</a>
        </div>
    </div>
    <div>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User</th>
                    <th>Resolved By</th>
                    <th>Subject</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>No ticket found</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>