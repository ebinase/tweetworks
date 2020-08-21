<style>
    .tweet-container {
        border: #6e6e6e solid 1px;
        display: flex;
    }

    .tweet-left {
        width: 20%;
    }

    .tweet-right {
        width: 80%;
    }
</style>

<!--<table>-->
<!--<tr>-->
<!--    <th>id</th><td>--><?//= $datum['id'] ?><!--</td>-->
<!--</tr>-->
<!--<tr>-->
<!--    <th>user_id</th><td>--><?//= $datum['user_id'] ?><!--</td>-->
<!--</tr>-->
<!--<tr>-->
<!--    <th>ツイート内容</th><td>--><?//= $datum['text'] ?><!--</td>-->
<!--</tr>-->
<!--<tr>-->
<!--    <th>日時</th><td>--><?//= $datum['created_at'] ?><!--</td>-->
<!--</tr>-->
<!--</table>-->

<?php foreach ($data as $datum) {?>
    <a href="<?= url('/detail'); ?>/<?= $datum['id'] ?>">
        <div class="tweet-container">
            <div class="tweet-left">
                アイコン
            </div>
            <div class="tweet-right">
                <div class="tweet-name">
                    <object><!--aタグのネストを実現するためにobjectで囲む-->
                        <a href="<?=url('/user/').$datum['unique_name'];?>">
                            <?= $datum['name'] ?> @<?= $datum['unique_name'] ?>
                        </a>
                    </object>
                </div>
                <div class="tweet-text">
                    <?= $datum['text'] ?>
                </div>
                <div class="tweet-func">
                    <div class="buttons-wrapper">
                        <div class="reply">
                            <form action="<?= url('/reply/post'); ?>" method="post">
                                <input type="hidden" name="_token" value="<?= $this->escape($_token['/reply/post']);?>">
                                <input type="hidden" name="tweet_id" value="<?= $datum['id'];?>">
                                <input type="text" name="text">
                                <input type="submit" value="返信">
                            </form>
                        </div>
                        <?php if (\App\System\Classes\Facades\Auth::info('unique_name') == $datum['unique_name']) {?>
                            <div class="delete">
                                <!--削除ボタン-->
                                <form action="<?= url('/tweet/delete'); ?>" method="post" onsubmit="return check()">
                                    <input type="hidden" name="_token" value="<?= $this->escape($_token['/tweet/delete']);?>">
                                    <input type="hidden" name="tweet_id" value="<?=$datum['id']?>">
                                    <input type="submit" value="削除">
                                </form>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </a>
<?php
}
?>