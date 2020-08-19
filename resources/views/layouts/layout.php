<html lang="ja">
<head>
    <title>tweetworks</title>
    <link rel="stylesheet" href="<?=url('/css/stylesheet.css') ?>">
</head>
<body>
    <header>
        <div class="container">
            <div class="header-container">
                <div class="header-logo-container">
                    <a class="logo-header logo" href="<?= url('/') ?>">Tweetworks</a>
                </div>
            </div>
        </div>
    </header>
    <div class="container">
        <?= $_content ?>
    </div>
<!--    <footer style="background-color: #cecece">-->
<!--        <div class="container">-->
<!--            ここはフッターです。-->
<!--        </div>-->
<!--    </footer>-->
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
</body>
</html>