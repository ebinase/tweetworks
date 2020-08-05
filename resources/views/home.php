<h1>ホーム画面</h1>
<ul>
    <li><a href="./login">ログイン</a></li>
    <li><a href="./logout">ログアウト</a></li>
    <li><a href="./sign-up">ユーザー登録</a></li>
</ul>
<form action="./tweet/post" method="post">
    <input type="hidden" name="_token" value="<?= $this->escape($_token['tweet/post']);?>">
    <label><input type="text" name="text"></label>
    <input type="submit" value="ツイート">
</form>

<form action="./tweet/delete" method="post" onsubmit="return check()">
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