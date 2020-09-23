<style>
    label {
        display: block;
    }
</style>

<div class="container">
    <form action="<?= url('/admin/login/auth'); ?>" method="post">
        <label>パスフレーズ：<input type="password" name="password" value=""></label>
        <input type="submit" value="管理者ログイン">
    </form>
    <?=\App\System\Classes\Facades\Admin::check() === true ? 'ログイン済み' : '未ログイン' ;?>
</div>