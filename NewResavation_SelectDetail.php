<?php include('./MakeResavationTable.php'); ?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8" />
    <title>希望日を選ぶ</title>
    <link rel="stylesheet" type="text/css" href="yoyaku.css">
</head>

<body>
    <h1>ご希望の日時やメニュー等を選ぶ</h1>
    <a href="index.html">トップメニュー</a> &gt; <a href="index.html">ご来店予約を管理する</a> &gt;
    <a href="NewResavation_SelectMember.php">新しい予約を受け付ける</a> &gt;
    ご希望の日時やメニュー等を選ぶ<br /><br />
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['MemberNo']) && isset($_POST['MemberInfo'])) {
        // 前画面からお客様情報を引き継ぐ
        $MemberNo = htmlspecialchars($_POST['MemberNo'], ENT_QUOTES, 'UTF-8');
        echo "<input type='hidden' id='MemberNo' name='MemberNo' value='" . $MemberNo . "' />";
        $MemberInfo = htmlspecialchars($_POST['MemberInfo'], ENT_QUOTES, 'UTF-8');
        echo "<h2 id='memberInfo'>" . $MemberInfo . "</h2>";
    } else {
        echo "<p>お客様が選択されていません。</p>";
    }
    ?>

    <label for="targetDate">ご希望日:</label>
    <input type="date" id="targetDate" name="targetDate" /><br />

    <button type="button" id="checkAvailability">予約状況を確認する</button><br />
    <hr />
    <table class="table1" id="scheduleTable">
        <!-- ここに予約状況を埋め込む -->
    </table>

    <div id="selectOther" style="display:none">
        <!-- 初期表示時は非表示 -->
        <!-- mock-up -->
        <hr />
        <label>メニュー</label>
        <table class="table1" id="menuTable">
            <thead>
                <tr>
                    <th>操作</th>
                    <th>メニュー</th>
                    <th>所要時間</th>
                    <th>スタイリスト</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><button class="actionBtn">追加</button></td>
                    <td>
                        <select id="menuSelect" class="menuSelect" style="display:none;">
                            <?php include('./MakeMenuSelect.php'); ?>
                        </select>
                    </td>
                    <td class="duration"></td>
                    <td>
                        <select id="stylistSelect" class="stylistSelect" style="display:none;">
                            <?php include('./MakeStylistSelect.php'); ?>
                        </select>
                    </td>
                </tr>
            </tbody>
        </table>
        <div id="totalTime">合計時間: 0分</div>
        <hr />
        <label for="targetTime">ご希望の開始時刻</label>
        <select id="targetTime"></select>
        <hr />
        <button type="button" id="confirmReservation">この情報で予約する</button><br />
    </div>

    <!-- モーダルウィンドウのHTML -->
    <div id="confirmationDialog" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <H2>予約を確定します。</H2>
            <p id="confirmMemberInfo"></p>
            <p id="confirmTargetDate"></p>
            <p id="confirmTargetTime"></p>
            <p id="confirmMenu"></p>
            <p id="confirmTotalTime"></p>
            <p id="confirmPrice"></p>
            <button type="button" id="retryButton">やり直す</button>
            <button type="button" id="finalConfirmButton">確定する</button>
        </div>
    </div>

    <script>
        // イベントハンドラ: 「予約状況を確認する」ボタンをクリックした
        document.getElementById('checkAvailability').addEventListener('click', () => {
            // ご希望日の値を設定したうえで、リロードする
            const targetDate = document.getElementById('targetDate').value;
            const xhr = new XMLHttpRequest();
            xhr.open('POST', '');
            xhr.onload = function() {
                if (xhr.status === 200) {
                    // 再表示が完了したら、指定日の予約状況をtable表示する
                    document.getElementById('scheduleTable').innerHTML = xhr.responseText;
                }
            };
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.send('targetDate=' + encodeURIComponent(targetDate));

            // 非表示にしていた項目を表示する
            let ele = document.getElementById('selectOther');
            ele.style.display = 'block';
        });
    </script>
    <script src="./dateTimeControl.js?v=202407141231"></script>
    <script src="./menuControl.js?v=202407152136"></script>
    <script src="./modalWindow.js?v=202407191750"></script>
</body>

</html>