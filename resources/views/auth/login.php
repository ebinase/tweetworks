<style>
    label {
        display: block;
    }
</style>

<h1>ログイン</h1>
<?php if (isset($error['csrf'])){ echo "<p>エラー：{$error['csrf']}</p>";}?>
<?php if (isset($error['login'])){ echo "<p>エラー：{$error['login']}</p>";}?>
<form action="./login/auth" method="post">
    <input type="hidden" name="_token" value="<?= $this->escape($_token);?>">
    <label>TW ID：@<input type="text" name="unique_name"></label>
    <label>password：<input type="password" name="password"></label>
    <input type="submit" value="ログイン">
</form>
