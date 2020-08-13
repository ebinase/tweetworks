<style>
    label {
        display: block;
    }
</style>

<h1>ログイン</h1>
<form action="./login/auth" method="post">
    <input type="hidden" name="_token" value="<?= $this->escape($_token);?>">
    <label>TW ID：@<input type="text" name="unique_name" value="unique_name1"></label>
    <label>password：<input type="password" name="password" value="password"></label>
    <input type="submit" value="ログイン">
</form>
<div>
    <a href="./sign-up">ユーザー登録</a>
</div>