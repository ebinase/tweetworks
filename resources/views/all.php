<?php
$this->setLayoutVar('page_title', 'WORLD');
echo $this->render('components/tweet_index', [
    'tweets' => $data,
    '_token' => $_token
]);