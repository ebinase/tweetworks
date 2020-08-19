<style>
    .logo-wrapper {
        height: 60%;
        display: flex;
        justify-content: center;
        align-content: center;
    }

    .links-wrapper {
        text-align: center;
    }

</style>

<div class="container">
    <div class="logo-wrapper">
        <h1 class="logo logo-top">Tweetworks</h1>
    </div>
    <div class="links-wrapper">
        <ul>
            <li><a href="<?= url('/login')?>">ログイン</a></li>
            <li><a href="<?= url('/register')?>">新規登録</a></li>
            <li><a href="<?= url('/all')?>">全ツイート表示</a></li>
        </ul>
    </div>
</div>