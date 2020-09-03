<style>
    .container {
        text-align: center;
        height: 100%;
    }

    .logo-top {
        color: #ffa014;
        font-family: "Ubuntu", sans-serif;
        font-size: 10rem;
    }

    li {
        list-style: none;
    }
</style>

<div class="container">
    <div class="logo-wrapper">
        <h1 class="logo logo-top">Tweetworks</h1>
    </div>

    <?php $info_state = \App\System\Classes\Facades\Messenger\Info::has() ? 'info-active' : 'info-passive'; ?>
        <div class="info-contents <?=$info_state?>">
            <?=\App\System\Classes\Facades\Messenger\Info::showAllInfo('info-text')?>
        </div>

    <div class="links-wrapper">
        <ul>
            <li><a href="<?= url('/login')?>">ログイン</a></li>
            <li><a href="<?= url('/sign-up')?>">新規登録</a></li>
            <li><a href="<?= url('/all')?>">全ツイート表示</a></li>
        </ul>
    </div>
</div>