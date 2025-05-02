<?php include('./MakeResavationTable.php'); ?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>希望日を選ぶ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
        crossorigin="anonymous"></script>

        <!-- tableタグのヘッダー行を固定する -->
    <link rel="stylesheet" type="text/css" href="table_sticky.css" />
    <style>
        #myTable {
            display: table;
        }
    </style>
    <script>
        function toggleTable() {
            let table = document.getElementById("myTable");
            if (table.style.display === "none") {
                table.style.display = "table";
            } else {
                table.style.display = "none";
            }
        }
    </script>
</head>

<body class="bg-body-tertiary">
    <div class="container">
        <nav class="navbar navbar-expand-lg bg-body-tertiary" data-bs-theme="dark">
            <div class="container-fluid">
                <div class="navbar-brand">🗓️ ご希望の日時やメニュー等を選ぶ</div>
                <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarScroll"
                    aria-controls="navbarScroll" aria-expanded="false" aria-label="ナビゲーションバーの切替">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarScroll">
                    <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px">
                        <li class="nav-item">
                            <a class="nav-link" href="./NewResavation_SelectMember.php"
                                data-bs-toggle="modal">新しい予約を受け付ける</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="./yoyakutop.html" data-bs-toggle="modal">ご来店予約を管理する</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="./index.html">トップメニュー</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <main>
            <hr class="my-4" />
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
            <hr class="my-4" />

            <div class="d-grid gap-3">
                <button type="button" id="checkAvailability" class="btn btn-primary btn-lg">予約状況を確認する</button><br />
            </div>
            <hr class="my-4" />

            <div class="table-wrapper">
                <table class="table table-striped" id="scheduleTable">
                    <!-- ここに予約状況を埋め込む -->
                </table>
            </div>

            <div id="selectOther" style="display:none">
                <!-- 初期表示時は非表示 -->
                <hr />
                <label>メニュー</label>
                <table class="table" id="menuTable">
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
                <hr class="my-4">

                <label for="targetTime">ご希望の開始時刻</label>
                <select id="targetTime"></select>
                <hr class="my-4">
                
                <div class="d-grid gap-3">
                    <button type="button" id="confirmReservation" class="btn btn-primary btn-lg">この情報で予約する</button><br />
                </div>
            </div>
        </main>

        <footer class="my-5 pt-5 text-body-secondary text-center text-small">
            <p class="mb-1">&copy; 2024 大阪情報専門学校 チームA</p>
            <ul class="list-inline">
                <li class="list-inline-item"><a href="#outside" data-bs-toggle="modal">プライバシー</a></li>
                <li class="list-inline-item"><a href="#outside" data-bs-toggle="modal">条項</a></li>
                <li class="list-inline-item"><a href="#outside" data-bs-toggle="modal">サポート</a></li>
            </ul>
        </footer>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="outside" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">未実装です‥🙇🏻‍♂️</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    【OK】で戻ってください。
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
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