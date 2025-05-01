let menuOptions = '';  // メニュー一覧
let stylistOptions = '';  // スタイリスト一覧
let durations = {};  // メニュー毎の所要時間

/**
 * メニュー一覧を取得する
 * @returns メニュー一覧
 */
async function getMenuOptions() {
    try {
        const response = await fetch('./MakeMenuSelect.php');
        if (!response.ok) {
            throw new Error('メニュー情報が見つかりません: MakeMenuSelect.php');
        }
        const options = await response.text();
        return options;
    } catch (error) {
        console.error('呼び出しに失敗しました: MakeMenuSelect.php: ', error);
        alert('メニュー情報の取得に失敗しました。後でもう一度お試しください。');
    }
}

/**
 * メニュー毎の所要時間を定義する
 */
async function defMenuDurations() {
    try {
        const response = await fetch('./GetMenuDurations.php');
        if (!response.ok) {
            throw new Error('メニュー情報が見つかりません: GetMenuDurations.php');
        }
        durations = await response.json();
    } catch (error) {
        console.error('呼び出しに失敗しました: GetMenuDurations.php: ', error);
        alert('メニュー情報の取得に失敗しました。後でもう一度お試しください。');
    }
}

/**
 * スタイリスト一覧を取得する
 * @returns スタイリスト一覧
 */
async function getStylistOptions() {
    try {
        const response = await fetch('./MakeStylistSelect.php');
        if (!response.ok) {
            throw new Error('スタイリスト情報が見つかりません: MakeStylistSelect.php');
        }
        const options = await response.text();
        return options;
    } catch (error) {
        console.error('呼び出しに失敗しました: MakeStylistSelect.php: ', error);
        alert('スタイリスト情報の取得に失敗しました。後でもう一度お試しください。');
    }
}

/**
 * 初期処理
 */
async function initializeOptions() {
    // メニュー一覧、メニュー毎の所要時間、スタイリスト一覧を取得しておく
    menuOptions = await getMenuOptions();
    await defMenuDurations();
    stylistOptions = await getStylistOptions();
}

/**
 * メニューの行を追加する
 */
function addNewRow(menuTable) {
    const newRow = menuTable.insertRow();
    newRow.innerHTML = `
        <td><button class="actionBtn">追加</button></td>
        <td><select id="menuSelect" class="menuSelect" style="display:none;">${menuOptions}</select></td>
        <td class="duration"></td>
        <td><select id="stylistSelect" class="stylistSelect" style="display:none;">${stylistOptions}</select></td>
    `;
}

/**
 * 所要時間の合計を表示する
 */
function updateTotalTime(menuTable, totalTimeDiv) {
    let total = 0;
    const durationCells = menuTable.querySelectorAll('.duration');
    durationCells.forEach(cell => {
        if (cell.textContent) {
            total += parseInt(cell.textContent);
        }
    });
    totalTimeDiv.textContent = '合計時間: ' + total + '分';
}

/**
 * メニュー選択コントロール
 */
document.addEventListener('DOMContentLoaded', async () => {
    await initializeOptions();
    
    const menuTable = document.getElementById('menuTable');
    const totalTimeDiv = document.getElementById('totalTime');

    /**
     * イベントハンドラ：ボタンをクリックした
     */
    menuTable.addEventListener('click', (event) => {
        if (event.target.classList.contains('actionBtn')) {
            const button = event.target;
            const row = button.closest('tr');
            const menuSelect = row.querySelector('.menuSelect');
            const durationCell = row.querySelector('.duration');
            const stylistSelect = row.querySelector('.stylistSelect');

            if (button.textContent === '追加') {
                // 「追加」ボタンをクリックした場合
                button.textContent = '取り消し';
                menuSelect.style.display = 'inline';
                durationCell.textContent = String(durations[menuSelect.value]) + "分";
                stylistSelect.style.display = 'inline';
                updateTotalTime(menuTable, totalTimeDiv);

                menuSelect.addEventListener('change', () => {
                    durationCell.textContent = String(durations[menuSelect.value]) + "分";
                    updateTotalTime(menuTable, totalTimeDiv);
                });

                addNewRow(menuTable);
            } else {
                // 「取り消し」ボタンをクリックした場合
                row.remove();
                if (menuTable.rows.length === 1) {
                    addNewRow(menuTable);
                }
                updateTotalTime(menuTable, totalTimeDiv);
            }
        }
    });
});

// フォームロード時に初期処理を行う
window.addEventListener('load', initializeOptions);
