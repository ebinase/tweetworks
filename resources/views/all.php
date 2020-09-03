<?php
$this->setLayoutVar('page_title', 'WORLD');
echo $this->render('components/tweet_index', [
    'tweets' => $data,
    '_token' => $_token
]);
?>

<div class="text-center w-100 border-top">
    <?= \App\System\Classes\Facades\Paginate::renderPageList($paginate)?>
</div>