<?php//$_token必須?>
    <style>
        #profile-modal-input-name {
            outline: none;
        }

        #profile-modal-input-bio {
            height: 6rem;
        }
    </style>

    <div class="modal fade" id="profile-edit-modal" tabindex="-1" role="dialog" aria-labelledby="label1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form action="<?= url('/profile/update'); ?>" method="post">
                    <div class="modal-header border-0 justify-content-between">
                        <div class="mt-2">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div><button type="submit" class="btn btn-primary">保存</button></div>

                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="_token" value="<?= $this->escape($_token['/profile/update']);?>">
                        <div class="profile-modal-form bg-light p-2 mb-3">
                                <label for="profile-modal-input-name">名前</label>
                                <input type="text" id="profile-modal-input-name" class="w-100 bg-light" name="name">
                        </div>

                        <div class="profile-modal-form bg-light p-1 mb-3">
                            <label for="profile-modal-input-bio">自己紹介</label>
                            <textarea id="profile-modal-input-bio" class="w-100 bg-light" name="bio"></textarea>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php
