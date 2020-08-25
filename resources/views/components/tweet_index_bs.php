<style>
    .tweet-container:last-child {
        border-bottom: none;
    }

    .icon {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        background-color: #6e6e6e;
    }

    .btn-follow {
        background-color: white;
        color: #00acee;
        border: #00acee 1px solid;
        border-radius: 20px;
    }
</style>

<div class="card">
<?php foreach ($tweets as $tweet) {?>
    <div class="card-body tweet-container border-bottom">
        <div class="row">
            <div class="col-2">
                <div class="icon"></div>
            </div>
            <div class="col-10">
                <div class="card-title"><?=$user['name'];?> <span style="color: #6e6e6e">@<?=$user['unique_name'];?></span></div>
                <div class="card-text"><?=$tweet['text'];?></div>
            </div>
        </div>
    </div>
<?php } ?>
</div>
