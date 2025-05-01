/**
 * モーダルウィンドウを表示するクラス
 */
class ModalWindow {
    /**
     * コンストラクタ
     */
    constructor() {
        this.modal = document.getElementById('confirmationDialog');
        this.closeBtn = document.querySelector('.close');

        this.init();
    }

    /**
     * 初期処理
     */
    init() {
        // イベントハンドラ：右上の[x]ボタンをクリックした
        this.closeBtn.addEventListener('click', () => this.closeModal());

        // イベントハンドラ：モーダル外をクリックした
        window.addEventListener('click', (event) => {
            if (event.target == this.modal) {
                this.closeModal();
            }
        });

        // イベントハンドラ: 「やり直す」ボタンをクリックした
        document.getElementById('retryButton').addEventListener('click', () => {
            document.getElementById('confirmationDialog').style.display = 'none';
        });

        // イベントハンドラ: 「確定する」ボタンをクリックした
        document.getElementById('finalConfirmButton').addEventListener('click', () => {
            this.addNewResavation();  // 新しい予約を登録する
            alert('予約が確定されました。');
            window.location.href = './index.html';
        });

        // イベントハンドラ: 「この情報で予約する」ボタンをクリックした
        document.getElementById('confirmReservation').addEventListener('click', () => this.handleSubmit());
    }

    /**
     * モーダルウィンドウを閉じる
     */
    closeModal() {
        this.modal.style.display = 'none';
    }

    /**
     * 必要な情報を埋め込んだモーダルウィンドウを表示する
     */
    async handleSubmit() {
        // 確認ダイアログに情報をセット
        document.getElementById('confirmMemberInfo').textContent = document.getElementById('memberInfo').textContent;
        document.getElementById('confirmTargetDate').textContent = "予約日: " + document.getElementById('targetDate').value;
        document.getElementById('confirmTargetTime').textContent = "開始時刻: " + document.getElementById('targetTime').value;
        let selectedMenuNameArray = Array.from(document.querySelectorAll('.menuSelect option:checked'))
            .map(option => option.text)
            .filter(name => name);
        selectedMenuNameArray.pop();
        let selectedStylistNameArray = Array.from(document.querySelectorAll('.stylistSelect option:checked'))
            .map(option => option.text)
            .filter(name => name);
        selectedStylistNameArray.pop();

        let buf = '';
        for (let i = 0; i < selectedMenuNameArray.length; i++) {
            buf += `${selectedMenuNameArray[i]}(${selectedStylistNameArray[i]})\u3000`;
        }
        document.getElementById('confirmMenu').textContent = "メニュー: " + buf;
        document.getElementById('confirmTotalTime').textContent = document.getElementById('totalTime').textContent;

        try {
            const response = await fetch('CalcAmount.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ menu: selectedMenuCdArray, stylist: selectedStylistNoArray })
            });

            if (!response.ok) {
                throw new Error('ネットワークレスポンスが正常ではありません');
            }

            // 結果を画面に表示
            const data = await response.json();
            document.getElementById('confirmPrice').textContent = "金額: " + data.result + "円";
        } catch (error) {
            console.error('エラーが発生しました:', error);
        }

        // 確認ダイアログを表示
        this.modal.style.display = 'block';
    }

    // 新しい予約を登録する
    async addNewResavation() {
        try {
            let targetDate = document.getElementById('targetDate').value;
            let targetTime = document.getElementById('targetTime').value;
            let memberNo = document.getElementById('MemberNo').value;
            let selectedMenuCdArray = Array.from(document.querySelectorAll('.menuSelect'))
                .map(select => select.value)
                .filter(value => value);
            selectedMenuCdArray.pop();
            let selectedStylistNoArray = Array.from(document.querySelectorAll('.stylistSelect'))
                .map(select => select.value)
                .filter(value => value);
            selectedStylistNoArray.pop();
            // フェッチリクエストを送信
            const response = await fetch('InsertNewResavation.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    targetDate: targetDate, 
                    memberNo: memberNo,
                    targetTime: targetTime,
                    menu: selectedMenuCdArray,
                    stylist: selectedStylistNoArray,
                }),
            });

            // レスポンスが正常でない場合、エラーをスロー
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            // レスポンスをJSONとしてパース
            const data = await response.json();

            // 結果を処理
            console.log('PHPからの応答:', data);

            // ここで必要な処理を行う（例：DOM更新など）

        } catch (error) {
            console.error('エラーが発生しました:', error);
        }
    }
}

/**
 * 画面ロード時に、ModalWindowオブジェクトを生成する
 */
document.addEventListener('DOMContentLoaded', () => {
    new ModalWindow();
});
