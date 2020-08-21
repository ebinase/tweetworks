<style>
    label {
        display: block;
    }

    .container {
        text-align: center;
    }

    li {
        list-style: none;
    }
</style>
<div class="container">
<h1>ログイン</h1>
<form action="<?= url('/login/auth'); ?>" method="post">
    <input type="hidden" name="_token" value="<?= $this->escape($_token);?>">
    <label>TW ID：@<input type="text" name="unique_name" value="unique_name1"></label>
    <label>password：<input type="password" name="password" value="password"></label>
    <input type="submit" value="ログイン">
</form>
<div>
    <ul>
        <li><a href="<?= url('/login')?>">ログイン</a></li>
        <li><a href="<?= url('/register')?>">新規登録</a></li>
        <li><a href="<?= url('/all')?>">全ツイート表示</a></li>
    </ul>
</div>
</div>