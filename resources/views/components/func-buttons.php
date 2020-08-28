<?php//$tweet['id']必須 ?>
<div class="row">
    <div class="col-4 reply">
        <button class="btn btn-reply" type="button"
                data-toggle="modal" data-target="#reply-modal"
                data-tweet-id="<?=$tweet['id']?>">
            <i class="far fa-comment"></i>
        </button>
    </div>
    <div class="col-4 retweet">
        <button class="btn"><i class="fas fa-retweet"></i></button>
    </div>
    <div class="col-4 favorite">
        <button class="btn btn-fav"
                data-tweet-id="<?=$tweet['id']?>"
                data-address="<?=url('/favorite/update');?>">
            <i class="far fa-star"></i>
        </button>
        <span></span>
    </div>
</div>