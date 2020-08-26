$(function() {
    $('.btn-fav').on('click', function () {
        let tweet_id = $(this).attr('data-tweet-id');
        let address = $(this).attr('data-address');
        $.ajax({
                url: address,
                type: 'post',
                data: { 'tweet_id' : tweet_id },
                dataType: 'json'
            }
        )
        // 検索成功時にはページに結果を反映
        .done(function(data) {
            $(this).children('i').css('color', 'yellow');
        })
        // 検索失敗時には、その旨をダイアログ表示
        .fail(function() {
            window.alert('正しい結果を得られませんでした。');
        });
    })
});