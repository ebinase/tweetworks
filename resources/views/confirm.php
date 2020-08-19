<h1>入力内容確認</h1>
<table>
    <tr>
        <th>お名前</th><td><?= $name ?></td>
    </tr>
    <tr>
        <th>ID</th><td>@<?= $unique_name ?></td>
    </tr>
    <tr>
        <th>メールアドレス</th><td><?= $email ?></td>
    </tr>
    <tr>
        <th>パスワード</th><td><?= $secret ?></td>
    </tr>
</table>
<!-- TODO: actionを絶対パスに。できれば何らかのメソッドで。(url()など)-->
<form action="<?= url('/sign-up/register'); ?>" method="post">
    <input type="hidden" name="_token" value="<?= $this->escape($_token);?>">
    <input type="hidden" name="name" value="<?= $this->escape($name);?>">
    <input type="hidden" name="unique_name" value="<?= $this->escape($unique_name);?>">
    <input type="hidden" name="email" value="<?= $this->escape($email);?>">
    <input type="hidden" name="password" value="<?= $this->escape($password);?>">

    <input type="submit" value="登録">
</form>

<div>
    <a href="<?= url('/sign-up'); ?>">戻って修正する</a>
</div>