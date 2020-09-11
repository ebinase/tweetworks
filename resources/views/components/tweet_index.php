<style>
    a.tweet-link:hover {
        color: #353535;
        text-decoration: none;
    }

    .tweet-container {
        padding: 8px;
    }

    .tweet-container:hover {
        background-color: #fcfcfc;
    }

    .tweet-user-name {
        font-weight: bold;
    }

    .icon-container {
        margin-top: 8px;
    }

    .dropdown-toggle:after {
        display: none;
    }

    .tweet-text {
        word-wrap: break-word;
    }

</style>

<?php//$tweetsと$_tokenが必須＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝ ?>
<div class="container">
<?php foreach ($tweets as $tweet) {?>
    <a class="tweet-link" href="<?= url('/detail'); ?>/<?= $tweet['id'] ?>">
        <div class="row  border-top tweet-container">
            <div class="col-2">
                <div class="icon-container">
                    <object><!--aタグのネストを実現するためにobjectで囲む-->
                        <a href="<?=url('/user/').$tweet['unique_name'];?>">
                            <i class="fas fa-user fa-2x"></i>
                        </a>
                    </object>
                </div>
            </div>
            <div class="col-10">
                <div class="container">
                    <div class="row tweet-name justify-content-between align-content-center">
                        <div>
                            <object><!--aタグのネストを実現するためにobjectで囲む-->
                                <a href="<?=url('/user/').$tweet['unique_name'];?>">
                                    <span class="tweet-user-name"><?= $tweet['name'] ?></span>
                                      @<?= $tweet['unique_name'] ?>
                                </a>
                            </object>
                            <span>...<?=$tweet['created_at']?></span>
                        </div>
                        <object>
                            <div class="dropdown">

                                    <a class="dropdown-toggle" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-caret-down"></i>
                                    </a>

                                <div id="dropdown-menu" class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <?php if (\App\System\Classes\Facades\Auth::info('unique_name') == $tweet['unique_name']) {?>
                                        <div class="">
                                            <!--削除ボタン-->
                                            <form action="<?= url('/tweet/delete'); ?>" method="post" onsubmit="return check()">
                                                <input type="hidden" name="_token" value="<?= $this->escape($_token['/tweet/delete']);?>">
                                                <input type="hidden" name="tweet_id" value="<?=$tweet['id']?>">
                                                <input class="dropdown-item" type="submit" value="削除">
                                            </form>
                                        </div>
                                        <div class="dropdown-divider"></div>
                                    <?php } ?>
                                    <object><a class="dropdown-item">閉じる</a></object>
                                </div>
                            </div>
                        </object>
                    </div>

                    <div class="row">
                        <p class="tweet-text w-100"><?=  nl2br($tweet['text']); ?></p>
                    </div>

                    <div class="row align-items-center">
                        <div class="col-4 reply">
                            <a class="btn btn-reply text-muted" type="button"
                                    data-toggle="modal" data-target="#reply-modal"
                                    data-tweet-id="<?=$tweet['id']?>">
                                <i class="far fa-comment"></i>
                                <span class="reply-num"><?=$tweet['replies']?></span>
                            </a>
                        </div>
                        <div class="col-4 retweet">
                            <a class="btn btn-retweet text-muted">
                                <i class="fas fa-retweet"></i>
                                <span class="retweet-num"></span>
                            </a>
                        </div>
                        <div class="col-4 favorite">
                            <a class="btn btn-fav text-muted"
                                    data-tweet-id="<?=$tweet['id']?>"
                                    data-address="<?=url('/favorite/update');?>">
                                <i class="far fa-star <?=$tweet['my_fav'] == 1 ? 'fav-active' : '';?>"></i>
                                <span class="fav-num"><?=$tweet['favs']?></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </a>
<?php
}
?>
</div>
<!--返信モーダル-->
<?= $this->render('components/reply-modal', [
    '_token' => $_token
]);?>