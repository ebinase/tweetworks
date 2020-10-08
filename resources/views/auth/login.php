<style>
    label {
        display: block;
    }

</style>

<?php $this->setLayoutVar('page_title', 'ログイン');?>

<div class="container">
    <form action="<?= url('/login/auth'); ?>" method="post">
        <label>TW ID：@<input type="text" name="unique_name" value="unique_name1"></label>
        <label>password：<input type="password" name="password" value="password"></label>
        <input type="submit" value="ログイン">
    </form>
</div>