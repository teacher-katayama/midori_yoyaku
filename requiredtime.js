function calculateScore() {
    let ret = 0;

    // チェックボックスaがチェック状態の場合
    if (document.getElementById("cut").checked) {
        ret += 30;
    }

    // チェックボックスbがチェック状態の場合
    if (document.getElementById("perm").checked) {
        ret += 60;
    }

    // チェックボックスcがチェック状態の場合
    if (document.getElementById("color").checked) {
        ret += 60;
    }

    // チェックボックスdがチェック状態の場合
    if (document.getElementById("treatment").checked) {
        ret += 30;
    }

    // 変数retを表示
    let hour = Math.floor(ret / 60);
    let min = ret - hour * 60;
    let buf = "";
    if (hour == 0) {
        buf = String(min) + "分";
    } else if (min == 0) {
        buf = String(hour) + "時間";
    } else {
        buf = String(hour) + "時間 " + String(min) + "分";
    }
    document.getElementById("requiredtime").textContent = buf;
}
