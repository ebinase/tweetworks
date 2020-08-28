$(function() {
    $('.btn-follow').on('click', function () {
        let follow_button = $(this)
        let follow_id = $(this).attr('data-follow-id');
        let address = $(this).attr('data-address');
        $.ajax({
                url: address,
                type: 'post',
                data: { 'follow_id' : follow_id },
                dataType: 'json'
            }
        )

            .done(function(data) {
                if (data['result'] === 'set') {
                    follow_button.addClass('follow-active');
                } else {
                    follow_button.removeClass('follow-active');
                }
                follow_button.next('span').text(data['favs']);
            })

            .fail(function() {
                window.alert('データの取得に失敗しました。');
            });
    })
});