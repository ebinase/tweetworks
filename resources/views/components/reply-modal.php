<?php//$_token必須?>
<div class="modal fade" id="reply-modal" tabindex="-1" role="dialog" aria-labelledby="label1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form action="<?= url('/reply/post'); ?>" method="post">
                <div class="modal-header border-0">
                    <h5 class="modal-title" id="label1">reply</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="reply">
                        <input type="hidden" name="_token" value="<?= $this->escape($_token['/reply/post']);?>">
                        <input id="reply-to-id" type="hidden" name="tweet_id" value="">
                        <textarea class="w-100" rows="5" name="text"></textarea>
                    </div>
                </div>
                <div class="modal-footer  border-0">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">キャンセル</button>
                    <button type="submit" class="btn btn-primary">返信</button>
                </div>
            </form>
        </div>
    </div>
</div>
