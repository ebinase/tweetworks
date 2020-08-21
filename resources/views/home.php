<h1>ホーム画面</h1>

<form action="<?= url('/tweet/post'); ?>" method="post">
    <input type="hidden" name="_token" value="<?= $this->escape($_token['tweet/post']);?>">
    <label><input type="text" name="text"></label>
    <input type="submit" value="ツイート">
</form>


<?= $this->render('components/tweet_index', [
        'data' => $tweets,
        '_token' => $_token
]);?>

<script type="text/javascript">
    function check(){
        if(window.confirm('削除してよろしいですか？')){ // 確認ダイアログを表示
            return true; // 「OK」時は送信を実行
        }
        else{ // 「キャンセル」時の処理
            return false; // 送信を中止
        }
    }
</script>