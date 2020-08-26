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
                fav_button.addClass('fav-active');
            } else {
                fav_button.removeClass('fav-active');
            }
            fav_button.next('span').text(data['favs']);
        })

        .fail(function() {
            window.alert('データの取得に失敗しました。');
        });
    })
});