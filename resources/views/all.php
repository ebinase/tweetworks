<?php
$this->setLayoutVar('page_title', 'WORLD');
echo $this->render('components/tweet_index', ['tweets' => $data]);