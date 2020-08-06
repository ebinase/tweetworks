<h1>ツイート詳細</h1>

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


<!--削除ボタン-->
<form action="<?= $_url('/tweet/delete') ?>" method="post" onsubmit="return check()">
    <input type="hidden" name="_token" value="<?= $this->escape($_token['tweet/delete']);?>">
    <input type="hidden" name="tweet_id" value="102">
    <input type="submit" value="削除">
</form>

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

