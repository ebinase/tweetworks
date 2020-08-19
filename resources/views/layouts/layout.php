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
    <header>
        <div class="container">
            <div class="header-container">
                <div class="header-logo-container">
                    <a class="logo-header logo" href="<?= url('/') ?>">Tweetworks</a>
                </div>
                <ul>
                    <?php if (\App\System\Classes\Facades\Auth::check()) { ?>
                        <li><a href="<?= url('/logout'); ?>">ログアウト</a></li>
                    <?php } else {?>
                        <li><a href="<?= url('/login'); ?>">ログイン</a></li>
                    <?php }?>
                </ul>
            </div>
        </div>
    </header>
    <div class="container">
        <div class="row">
            <nav class="col-1">
                <div class="row"><a href="<?= url('/home'); ?>">ホーム</a></div>
                <div class="row"><a href="">検索</a></div>
                <div class="row"><a href="">プロフィール</a></div>
            </nav>
            <div class="col-11">
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