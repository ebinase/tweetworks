<style>
    table {

    }

    .main-tweet-container {
        width: 50%;
        border: #6e6e6e solid 1px;
        margin-bottom: 5px;
        padding: 5px;
    }

    .reply-container {
        width: 40%;
        margin-left: 10%;
    }

    .reply-wrapper {
        border-bottom: #6e6e6e solid 1px;
    }

    .reply-wrapper:last-child {
        border-bottom: none;
    }

    .buttons-wrapper {
        display: flex;
        justify-content: space-between;
    }

    .hide {
        display: none;
    }
</style>

<div class="container">
    <h1>ツイート詳細</h1>
    <div class="main-tweet-container">
        <div class="tweet-wrapper">
            <table>
                <tr>
                    <th>id</th><td><?= $data['id'] ?></td>
                </tr>
                <tr>
                    <th>user_id</th><td><?= $data['user_id'] ?></td>
                </tr>
                <tr>
                    <th>ツイート内容</th><td><?= $data['text'] ?></td>
                </tr>
                <tr>
                    <th>日時</th><td><?= $data['created_at'] ?></td>
                </tr>
            </table>
        </div>

        <div class="buttons-wrapper">
            <div class="reply">
                <form action="<?= url('/reply/post'); ?>" method="post">
                    <input type="hidden" name="_token" value="<?= $this->escape($_token['/reply/post']);?>">
                    <input type="hidden" name="tweet_id" value="<?= $data['id'];?>">
                    <input type="text" name="text">
                    <input type="submit" value="返信">
                </form>
            </div>
            <div class="delete">
                <!--削除ボタン-->
                <form action="<?= url('/tweet/delete'); ?>" method="post" onsubmit="return check()">
                    <input type="hidden" name="_token" value="<?= $this->escape($_token['/tweet/delete']);?>">
                    <input type="hidden" name="tweet_id" value="102">
                    <input type="submit" value="削除">
                </form>
            </div>
        </div>
    </div>

    <div class="reply-container">
    <?php foreach ($replies as $reply) { ?>
        <div class="reply-wrapper">
            <table class="reply-table">
                <tr>
                    <th>reply_to</th><td><?= $reply['reply_to_id'] ?></td>
                </tr>
                <tr>
                    <th>id</th><td><?= $reply['id'] ?></td>
                </tr>
                <tr>
                    <th>user_id</th><td><?= $reply['user_id'] ?></td>
                </tr>
                <tr>
                    <th>ツイート内容</th><td><?= $reply['text'] ?></td>
                </tr>
                <tr>
                    <th>日時</th><td><?= $reply['created_at'] ?></td>
                </tr>
            </table>

            <div class="buttons-wrapper hide">
                <div class="reply">
                    <form action="<?= url('/reply/post'); ?>" method="post">
                        <input type="hidden" name="_token" value="<?= $this->escape($_token['/reply/post']);?>">
                        <input type="hidden" name="tweet_id" value="<?= $data['id'];?>">
                        <input type="text" name="text">
                        <input type="submit" value="返信">
                    </form>
                </div>
                <div class="delete">
                    <!--削除ボタン-->
                    <form action="<?= url('/tweet/delete'); ?>" method="post" onsubmit="return check()">
                        <input type="hidden" name="_token" value="<?= $this->escape($_token['/tweet/delete']);?>">
                        <input type="hidden" name="tweet_id" value="102">
                        <input type="submit" value="削除">
                    </form>
                </div>
            </div>
        </div>
    <?php } ?>
    </div>
</div>


<!--<script type="text/javascript">-->
<!--    (document).ready(function(){-->
<!--        -->
<!--    });$-->
<!--</script>-->

<script type="text/javascript">
    function check(){
        if(window.confirm('削除してよろしいですか？')){ // 確認ダイアログを表示
            return true; // 「OK」時は送信を実行
        }
        else{ // 「キャンセル」時の処理
            window.alert('キャンセルされました'); // 警告ダイアログを表示
            return false; // 送信を中止
        }
    }
</script>

