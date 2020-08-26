$(function() {
    $('.btn-fav').on('click', function () {
        $.ajax({
                url:'<?=url('/favorite/update');?>',
                type: 'post',
                data: {  },
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