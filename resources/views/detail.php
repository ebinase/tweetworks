<?php $this->setLayoutVar('page_title', 'ホーム');?>

<style>

/*   tweet-index.phpと共通=================== */
    .tweet-container {
        padding: 8px;
    }

    .icon-container {
        margin-top: 8px;
    }

    .dropdown-toggle:after {
        display: none;
    }

    /*profile.phpと共通*/
    h2 {
        font-size: 1rem;
        font-weight: bold;
    }

    h3 {
        font-size: 1rem;
    }

/*    detail.phpオリジナル*/
    .main-tweet-text {
        font-size: 1.2rem;
    }

    .tweet-date {
        font-size: 0.9rem;
    }

</style>

<div class="container">
<!--    <div class="row  border-top tweet-container">-->
        <div class="row border-top tweet-container">
            <div class="col-1">
                <div class="icon-container">
                    <i class="fas fa-user fa-2x"></i>
                </div>
            </div>
            <div class="col-10">
                <div class="row justify-content-between align-content-center">
                    <div>
                        <a href="<?=url('/user/').$tweet['unique_name'];?>">
                            <h2 class="mt-1 mb-0"><?=$tweet['name'];?></h2>
                            <h3 class="p-0 text-muted">@<?=$tweet['unique_name'];?></h3>
                        </a>
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
            </div>
        </div>


        <div class="tweet-text main-tweet-text">
            <p><?= $tweet['text'] ?></p>
        </div>

        <div class="tweet-date text-muted">
            <?=$tweet['created_at']?>
        </div>

    <div class="container border-top border-bottom  mt-3 mb-3 pt-2 pb-2">
        <div class="row">
            <strong></strong><span class="text-muted">　コメント　　</span>
            <strong></strong><span class="text-muted">　お気に入り　　</span>
        </div>
    </div>

    <div class="container mt-2 mb-2">
        <div class="row">
            <div class="col-4 reply">
                <button class="btn" type="button" data-toggle="modal" data-target="#reply-modal"><i class="far fa-comment"></i></button>
            </div>
            <div class="col-4 retweet">
                <button class="btn"><i class="fas fa-retweet"></i></button>
            </div>
            <div class="col-4 reply favorite">
                <button class="btn"><i class="far fa-star"></i></button>
            </div>
        </div>
    </div>

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

    <div class="row">
        <?= $this->render('components/tweet_index', [
            'tweets' => $replies,
            '_token' => $_token
        ]);?>
    </div>
</div>


<!--<script type="text/javascript">-->
<!--    (document).ready(function(){-->
<!--        -->
<!--    });$-->
<!--</script>-->


