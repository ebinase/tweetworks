<style>
    .tweet-container {
        padding: 8px;
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

</style>

<?php//$tweetsと$_tokenが必須＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝ ?>
<div class="container">
<?php foreach ($tweets as $tweet) {?>
    <a href="<?= url('/detail'); ?>/<?= $tweet['id'] ?>">
        <div class="row  border-top tweet-container">
            <div class="col-2">
                <div class="icon-container">
                    <i class="fas fa-user fa-2x"></i>
                </div>
            </div>
            <div class="col-10">
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
                </div>

                <div class="row tweet-text">
                    <p><?= $tweet['text'] ?></p>
                </div>

                <div class="row">
                    <div class="col-4 reply">
                        <button class="btn" type="button" data-toggle="modal" data-target="#reply-modal"><i class="far fa-comment"></i></button>
                    </div>
                    <div class="col-4 retweet">
                        <button class="btn"><i class="fas fa-retweet"></i></button>
                    </div>
                    <div class="col-4 favorite">
                        <button class="btn btn-fav" data-tweet-id="<?=$tweet['id']?>" data-address="<?=url('/favorite/update');?>">
                            <i class="far fa-star"></i>
                        </button>
                    </div>
                </div>

                <!--返信モーダル-->
                <!--TODO: JSでツイートのidを動的に取得して、モーダルを繰り返しレンダリングしなくても済むように-->
                <div class="modal fade" id="reply-modal" tabindex="-1" role="dialog" aria-labelledby="label1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <form action="<?= url('/reply/post'); ?>" method="post">
                                <div class="modal-header border-0">
                                    <h5 class="modal-title" id="label1">reply</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="reply">
                                        <input type="hidden" name="_token" value="<?= $this->escape($_token['/reply/post']);?>">
                                        <input type="hidden" name="tweet_id" value="<?= $tweet['id'];?>">
                                        <textarea class="w-100" rows="5" name="text"></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer  border-0">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">キャンセル</button>
                                    <button type="submit" class="btn btn-primary">返信</button>
                                </div>
                            </form>
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
