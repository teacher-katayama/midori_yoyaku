<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8" />
    <title>お客様を選択する</title>
</head>

<body>
    <h1>新しい予約を受け付ける</h1>
    <a href="index.html">トップメニュー</a> &gt; <a href="index.html">ご来店予約を管理する</a> &gt;
    新しい予約を受け付ける<br /><br />
    <label for="member">お客様:</label><br />
    <select id="member" name="member">
        <?php include('./MakeMemberSelect.php'); ?>
    </select><br /><br />

    <form id="form" method="POST" action="NewResavation_SelectDetail.php">
        <input type="hidden" id="MemberNo" name="MemberNo" value="" />
        <input type="hidden" id="MemberInfo" name="MemberInfo" value="" />
        <button type="submit">ご希望の日時やメニュー等を選ぶ</button>
    </form>

    <script>
        // イベントハンドラ: 「ご希望の日時やメニュー等を選ぶ」ボタンをクリックした
        document.getElementById('form').addEventListener('submit', () => {
            // 選択中のお客様Noとお客様情報(読み仮名以外)を引き継ぐ
            let selectedOption = document.getElementById('member').selectedOptions[0];
            let selectedValue = selectedOption.value;
            let selectedName = selectedOption.getAttribute('data-name');
            document.getElementById('MemberNo').value = selectedValue;
            document.getElementById('MemberInfo').value = selectedName;
        });
    </script>
</body>

</html>