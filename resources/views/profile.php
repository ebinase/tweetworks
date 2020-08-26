<?php $this->setLayoutVar('page_title', $user['name'].'さんのプロフィール');?>
<style>
    #profile-background {
        height: 10%;
    }

    h2 {
        font-size: 1.3rem;
        font-weight: bold;
    }

    h3 {
        font-size: 1rem;
    }

    .btn-follow {
        background-color: white;
        color: #00acee;
        border: #00acee 1px solid;
        border-radius: 20px;
    }

    .bio-text {
        word-wrap: break-word;
    }
</style>

<div class="container">
    <div id="profile-background" class="row bg-light"></div>

    <div class="row mt-3">
        <div class="col-9">
            <h2 class=""><?=$user['name'];?></h2>
            <h3 class="text-muted">@<?=$user['unique_name'];?></h3>
        </div>

        <div class="col-3">
            <form action="<?=url('/follow/update')?>" method="post">
                <input type="hidden" name="user_id_followed" value="<?=$user['id']?>">
                <input type="hidden" name="_token" value="<?=$_token['/follow/update']?>">
                    <button class="btn-follow" type="submit">フォロー</button>
            </form>
        </div>
    </div>

    <p class="bio-text">biooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooo</p>


    <div class="row">
        <div class="col-3">
            <a href="<?=url('/user/'). $user['unique_name'].'/follows'?>">
                <span class="text-muted">フォロー</span><strong><?=$follow['follows'];?>人</strong>
            </a>
        </div>
        <div class="col-3">
            <a href="<?=url('/user/'). $user['unique_name'].'/followers'?>">
                <span class="text-muted">フォロワー</span><strong><?=$follow['followers'];?>人</strong>
            </a>
        </div>
    </div>

    <div class="row text-center mt-2">
        <div class="col-4 pt-3 pb-3"><a class="card-link" href="<?=url('/user/').$user['unique_name'];?>">ツイート</a></div>
        <div class="col-4 pt-3 pb-3"><a class="card-link" href="<?=url('/user/').$user['unique_name'].'?content=replies';?>">返信</a></div>
        <div class="col-4 pt-3 pb-3"><a class="card-link" href="<?=url('/user/').$user['unique_name'].'?content=favorites';?>">お気に入り</a></div>
    </div>

    <div class="row">
        <?=$this->render('components/tweet_index', [
            'tweets' => $tweets,
            '_token' => $_token
        ]) ?>
    </div>
</div>
