<html lang="ja">
<head>
    <title>tweetworks</title>
    <link rel="stylesheet" href="<?=url('/css/stylesheet.css') ?>">

    <!--bootstrap-->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container">
        <div class="row">
            <nav class="col-2">
                <div class="row logo-container">
                    <a class="logo-header logo" href="<?= url('/') ?>">Tweetworks</a>
                </div>
                <?php if ( auth() ) { ?>
                    <div class="row card">
                        <div class="card-title"><?=\App\System\Classes\Facades\Auth::info('name')?></div>
                        <div class="card-subtitle">@<?=\App\System\Classes\Facades\Auth::info('unique_name')?></div>
                    </div>
                <?php }?>
                <div class="row"><a href="">検索</a></div>
                <div class="row"><a href="<?=url('/all')?>">WORLD</a></div>
                <?php if ( auth() ) { ?>
                    <div class="row"><a href="<?= url('/home'); ?>">ホーム</a></div>
                    <div class="row"><a href="<?=url('/user/') . userInfo('unique_name');?>">プロフィール</a></div>
                    <div class="row" style="margin-top: 0.5rem"><a href="<?= url('/logout'); ?>">ログアウト</a></div>
                <?php } else {?>
                    <div class="row" style="margin-top: 0.5rem"><a href="<?= url('/sign-up'); ?>">新規登録</a></div>
                    <div class="row"><a href="<?= url('/login'); ?>">ログイン</a></div>
                <?php }?>
            </nav>
            <div class="col-10">
                <?= $_content ?>
            </div>
        </div>
    </div>
<!--    <footer style="background-color: #cecece">-->
<!--        <div class="container">-->
<!--            ここはフッターです。-->
<!--        </div>-->
<!--    </footer>-->
</body>
</html>