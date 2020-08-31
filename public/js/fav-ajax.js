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

            // 詳細ページとツイート一覧でお気に入りの表示箇所を変える
            const detail_favs = $('#detail-favs');
            if (detail_favs.length > 0) {
                //詳細ページだった場合
                detail_favs.text(data['favs']);
            } else {
                //その他のページだった場合
                fav_button.children('span').text(data['favs']);
            }

        })

        .fail(function() {
            window.alert('データの取得に失敗しました。');
        });
    })

});