<html lang="ja">
<head>
    <title>tweetworks</title>

    <meta charset="utf-8">
    <!--bootstrap-->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

    <link rel="stylesheet" href="<?=url('/css/stylesheet.css') ?>">
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-3 pt-3">
                <nav class="nav flex-column position-fixed">
                    <a href="<?= url('/') ?>" class="nav-item theme-color brand-logo">
                        T<span class="d-none d-xl-inline">weetworks</span>
                    </a>
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link tw-heading" href="">#<span class="d-none d-lg-inline">話題を検索</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link tw-heading" href="<?=url('/all')?>">#<span class="d-none d-lg-inline">WORLD</span></a>
                        </li>
                        <?php if ( auth() ) { ?>
                            <li class="nav-item">
                                <a class="nav-link tw-heading" href="<?=url('/user/') . userInfo('unique_name');?>">
                                    #<span class="d-none d-lg-inline">プロフィール</span>
                                </a>
                            </li>
                        <?php }?>

                        <li class="nav-item">
                            <a class="nav-link tw-heading" href="#more-list" data-toggle="collapse">More</a>
                            <div id="more-list" class="collapse flex-row">
                                <?php if ( auth() ) { ?>
                                    <div class="card nav-user-info">
                                        <div class="card-title"><?=\App\System\Classes\Facades\Auth::info('name')?></div>
                                        <div class="card-subtitle">@<?=\App\System\Classes\Facades\Auth::info('unique_name')?></div>
                                    </div>
                                    <div><a class="nav-item" href="<?= url('/logout'); ?>">ログアウト</a></div>
                                <?php } else {?>
                                    <div><a class="nav-item" href="<?= url('/sign-up'); ?>">新規登録</a></div>
                                    <div><a class="nav-item" href="<?= url('/login'); ?>">ログイン</a></div>
                                <?php }?>
                            </div>
                        </li>

                        <li class="nav-item">
                        <?php if ( auth() ) { ?>
                                <button class="nav-link btn btn-tweet" type="button"
                                        data-toggle="modal" data-target="#tweet-modal">
                                    ツイートする
                                </button>
                        <?php } else {?>
                            <a href="<?=url('/login')?>" class="nav-link btn btn-tweet" type="button">
                                ログイン
                            </a>
                            <div class="w-100 text-center mt-2">
                                <a href="<?= url('/sign-up')?>" class="">新規登録</a>
                            </div>
                        <?php }?>
                        </li>
                    </ul>
                </nav>

            </div>

            <!--中央部分-->
            <div id="#center-container" class="col-7 pt-3 border-left border-right min-vh-100">
                <h1 class="row tw-heading center-heading">
                    <?= $page_title ?><!--各テンプレート内で、$this->setLayoutVar()で設定-->
                </h1>
                <div class="row">
                    <?= $_content ?>
                </div>
            </div>

            <!--右側-->
            <div class="col-2 pt-3">
                <div class="container position-fixed">
<!--                    <div class="row">-->
<!--                        <i class="fab fa-twitter fa-5x"></i>-->
<!--                    </div>-->
<!--                    <div class="row">-->
<!--                        <i class="fab fa-twitter fa-4x"></i>-->
<!--                    </div>-->
                    <div class="row">
                        <i id="character" class="fab fa-twitter fa-3x"></i>
                    </div>
<!--                    <div class="row">-->
<!--                        <i class="fab fa-twitter fa-2x"></i>-->
<!--                    </div>-->

                    <?php $info_state = \App\System\Classes\Facades\Messenger\Info::has() ? 'info-active' : 'info-passive'; ?>
                    <div id="info-modal" class="row <?=$info_state?>">
                        <div class="col-3">
                            <div class="info-container bg-light border">
                                <button id="info-cancel-btn">x</button>
                                <div class="info-contents">
<!--                                    <div class="font-weight-bold">Infomation</div>-->
                                    <?=\App\System\Classes\Facades\Messenger\Info::showAllInfo('info-text')?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <?= $this->render('components/tweet-modal', [
        '_token' => $_token
    ]);?>

<!--    <footer style="background-color: #cecece">-->
<!--        <div class="container">-->
<!--            ここはフッターです。-->
<!--        </div>-->
<!--    </footer>-->
    <!--  bootstrap  -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>

<!--    本田さん-->
    <script src=""></script>
<!--    蛯名-->
    <script src="<?=url('/js/fav-ajax.js')?>"></script>
<!--全般的なjs-->
    <script src="<?=url('/js/script.js')?>"></script>

</body>
</html>