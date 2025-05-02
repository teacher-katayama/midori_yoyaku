<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>お客様を選択する</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
        crossorigin="anonymous"></script>
</head>

<body class="bg-body-tertiary">
    <div class="container">
        <nav class="navbar navbar-expand-lg bg-body-tertiary" data-bs-theme="dark">
            <div class="container-fluid">
                <div class="navbar-brand">✨ 新しい予約を受け付ける</div>
                <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarScroll"
                    aria-controls="navbarScroll" aria-expanded="false" aria-label="ナビゲーションバーの切替">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarScroll">
                    <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px">
                        <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px">
                            <li class="nav-item">
                                <a class="nav-link" href="./yoyakutop.html" data-bs-toggle="modal">ご来店予約を管理する</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="./index.html" data-bs-toggle="modal">トップメニュー</a>
                            </li>
                        </ul>
                    </ul>
                </div>
            </div>
        </nav>

        <hr class="my-4" />

        <main>
            <div class="col-md-10 col-lg-12">
                <div class="row g-3">
                    <div class="col-12">
                        <label>お客様</label>
                        <select class="form-select" aria-label=".form-select example" name="member" id="member">
                            <?php include('./MakeMemberSelect.php'); ?>
                        </select>
                    </div>
                </div>

                <hr class="my-4" />

                <form id="form" method="POST" action="NewResavation_SelectDetail.php">
                    <input type="hidden" id="MemberNo" name="MemberNo" value="" />
                    <input type="hidden" id="MemberInfo" name="MemberInfo" value="" />
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">🗓️ご希望の日時やメニュー等を選ぶ</button>
                    </div>
                </form>
            </div>
        </main>

        <footer class="my-5 pt-5 text-body-secondary text-center text-small">
            <p class="mb-1">&copy; 2024 大阪情報専門学校 チームA</p>
            <ul class="list-inline">
                <li class="list-inline-item">
                    <a href="#outside" data-bs-toggle="modal">プライバシー</a>
                </li>
                <li class="list-inline-item">
                    <a href="#outside" data-bs-toggle="modal">条項</a>
                </li>
                <li class="list-inline-item">
                    <a href="#outside" data-bs-toggle="modal">サポート</a>
                </li>
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
                <div class="modal-body">【OK】で戻ってください。</div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="nomember" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">操作エラー</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">お客様を選択してください</div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous">
    </script>

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