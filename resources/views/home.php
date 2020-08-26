<?php $this->setLayoutVar('page_title', 'ホーム');?>

<div class="container">
    <div class="row">
        <form action="<?= url('/tweet/post'); ?>" method="post">
            <input type="hidden" name="_token" value="<?= $this->escape($_token['tweet/post']);?>">
            <label><input type="text" name="text"></label>
            <input type="submit" value="ツイート">
        </form>
    </div>

    <div class="row">
        <?= $this->render('components/tweet_index', [
            'tweets' => $tweets,
            '_token' => $_token
        ]);?>
    </div>

</div>