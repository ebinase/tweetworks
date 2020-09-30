$(function() {
    $('.js-btn-follow').on('click', function () {
        let follow_button = $(this)
        let user_id_followed = $(this).attr('data-follow-id');
        let address = $(this).attr('data-address');
        $.ajax({
                url: address,
                type: 'post',
                data: { 'user_id_followed' : user_id_followed },
                dataType: 'json'
            }
        )

            .done(function(data) {
                if (data['result'] === 'set') {
                    follow_button.addClass('follow-active').text('フォロー中');
                } else if(data['result'] === 'unset') {
                    follow_button.removeClass('follow-active').text('フォローする');
                } else if (data['result'] === 'self-follow') {
                    window.alert('自分自身をフォローすることはできません。');
                }
            })

            .fail(function() {
                window.alert('データの取得に失敗しました。');
            });
    })
});