$(function() {
    $('.btn-fav').on('click', function () {
        let fav_button = $(this)
        let tweet_id = $(this).attr('data-tweet-id');
        let address = $(this).attr('data-address');
        $.ajax({
                url: address,
                type: 'post',
                data: { 'tweet_id' : tweet_id },
                dataType: 'json'
            }
        )

        .done(function(data) {
            if (data['result'] === 'set') {
                fav_button.children('i').addClass('fav-active');
            } else {
                fav_button.children('i').removeClass('fav-active');
            }
            fav_button.next('span').text(data['favs']);
        })

        .fail(function() {
            window.alert('データの取得に失敗しました。');
        });
    })

    $('.btn-reply').on('click', function () {
        let reply_to_id = $(this).attr('data-tweet-id');
        $('#reply-to-id').val(reply_to_id);
    });
});