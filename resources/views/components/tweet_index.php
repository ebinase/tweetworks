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

<?php foreach ($data as $datum) {?>
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
                    <div class="col-4">返信</div>
                    <div class="col-4">お気に入り</div>
                </div>
            </div>
        </div>
    </a>
<?php
}
?>