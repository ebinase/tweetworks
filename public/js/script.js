//レイアウト=========================================================================
$(function() {
    //リプライボタンを押したときのモーダルの挙動
    $('.btn-reply').on('click', function () {
        let reply_to_id = $(this).attr('data-tweet-id');
        $('#reply-to-id').val(reply_to_id);
    });

    //プロフィール編集ボタンを押したときにモーダルにデフォルトの値を設定
    $('#profile-edit-btn').on('click', function () {
        const name = $('#profile-name').text();
        const bio = $('#profile-bio').text();

        //モーダルに設定
        $('#profile-modal-input-name').val(name);
        $('#profile-modal-input-bio').val(bio);
    });

    //画面右側の鳥マークやインフォメーション
    $('#info-cancel-btn').on('click', function () {
        $('#info-modal').css('display', 'none');
    });

    $('#character').on('click', function () {
        $('#info-modal').css('display', 'block');
    });
});

//ツイートの削除ボタン
function check(){
    return window.confirm('削除してよろしいですか？');
}