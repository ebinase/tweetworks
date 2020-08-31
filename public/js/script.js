//レイアウト=========================================================================
$(function() {
//リプライボタンを押したときのモーダルの挙動
    $('.btn-reply').on('click', function () {
        let reply_to_id = $(this).attr('data-tweet-id');
        $('#reply-to-id').val(reply_to_id);
    });
});

//ツイートの削除ボタン
function check(){
    return window.confirm('削除してよろしいですか？');
}