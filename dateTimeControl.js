/**
 * 日時制御クラス
 */
class DateTimeControl {
    /**
     * コンストラクタ
     */
    constructor() {
        this.targetDate = document.getElementById('targetDate');
        this.targetTime = document.getElementById('targetTime');
        this.init();
    }

    /**
     * 初期処理
     */
    init() {
        document.addEventListener('DOMContentLoaded', () => {
            // 初期値を今日の日付に設定
            const today = new Date().toISOString().split('T')[0];
            this.targetDate.value = today;

            this.setTimeItems();  // 選択日に応じた時刻選択ドロップダウンリストを組み立てる
        });

        /**
         * イベントハンドラ: 日付を変更した
         */
        this.targetDate.addEventListener('change', () => {
            this.setTimeItems();  // 選択日に応じた時刻選択ドロップダウンリストを組み立てる
        });
    }

    /**
     * 選択日に応じた時刻選択ドロップダウンリストを組み立てる
     */
    setTimeItems() {
        const selectedDate = new Date(this.targetDate.value);
        const now = new Date();
        this.targetTime.innerHTML = '';  // ドロップダウンリストをいったんクリアしておく

        if (selectedDate.toDateString() === now.toDateString()) {
            // 今日の日付の場合⇒「現在時刻に最も近い30分刻みの時刻」から「閉店時刻」まで30分刻み
            let startHour = now.getHours();
            if (now.getMinutes() < 30) {
                this.addOption(startHour, 30);
            }
            startHour += 1;
            for (let hour = startHour; hour < 20; hour++) {
                this.addOption(hour, 0);
                this.addOption(hour, 30);
            }
        } else {
            // 明日以降の場合⇒「開店時刻」から「閉店時刻」まで30分刻み
            for (let hour = 10; hour < 20; hour++) {
                this.addOption(hour, 0);
                this.addOption(hour, 30);
            }
        }
    }

    /**
     * 時刻アイテムをドロップダウンリストに追加する
     * @param {number} hour 時
     * @param {number} minute 分
     */
    addOption(hour, minute) {
        const option = document.createElement('option');
        option.value = `${hour.toString().padStart(2, '0')}:${minute.toString().padStart(2, '0')}`;
        option.text = option.value;
        this.targetTime.appendChild(option);
    }
}

// インスタンス化
new DateTimeControl();