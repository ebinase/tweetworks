<style>
    label {
        display: block;
    }
</style>

<!-- TODO: old()機能の実装-->

<h1>ユーザー登録</h1>
<?php if (isset($error['general'])){ echo "<p>エラー：{$error['general']}</p>";}?>
<form action="sign-up/confirm" method="post">
    <input type="hidden" name="_token" value="<?= $this->escape($_token);?>">
    <div>
        <label>ユーザー名：<input type="text" name="name"></label>
        <label>Twitter ID：@<input type="text" name="unique_name"></label>
    </div>
    <div>
        <label>email：<input type="email" name="email"></label>
        <label>password：<input type="password" name="password"></label>
    </div>
    <input type="submit" value="確認画面へ">
</form>