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

<div class="row">
    <a href="<?=prevUrl()?>" class="back">←戻る</a>
</div>
<div class="card">
    <div class="card-body border-bottom">
        <div class="row">
            <div class="col-9">
                <h5 class="card-title"><?=$user['name'];?></h5>
                <h6 class="card-subtitle mb-2 text-muted">@<?=$user['unique_name'];?></h6>
            </div>
            <div class="col-3">
                <button class="btn-follow">フォロー</button>
            </div>
        </div>
        <p class="card-text">biooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooo</p>

        <div>
            <a href="<?=url('/user/'). $user['unique_name'].'/follows'?>">
                フォロー<?=$follow['follows'];?>人
            </a>
            <span>  </span>
            <a href="<?=url('/user/'). $user['unique_name'].'/followers'?>">
                フォロワー<?=$follow['followers'];?>人
            </a>
        </div>

        <div class="row text-center">
            <div class="col-4"><a class="card-link">ツイート</a></div>
            <div class="col-4"><a class="card-link">返信</a></div>
            <div class="col-4"><a class="card-link">お気に入り</a></div>
        </div>
    </div>
</div>
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