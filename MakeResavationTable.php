<?php
require_once 'AbstractDbAccess.php';  // DBアクセスの基底クラス

/**
 * 予約状況を表示する
 */
class MakeResavationTable extends AbstractDbAccess
{
    /**
     * 指定日の予約状況を表にする
     * ・スタイリストのランク順に横に並べる
     * ・指定日の予約状況を縦に並べる
     * ・HTMLのtableタグとして出力する
     *
     * @return void
     */
    public function makeResavationTable()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['MemberNo']) == false) {
            // ご希望日を取得する
            $reserveDate = $_POST['targetDate'];

            // スタイリスト名を取得する
            $stmt2 = $this->dbh->prepare("
                SELECT
                    M_Stylist.LastName AS StylistName
                FROM
                    M_Stylist 
                WHERE
                    M_Stylist.StartDate <= CURRENT_DATE 
                    AND M_Stylist.EndDate >= CURRENT_DATE 
                ORDER BY
                    M_Stylist.RankCd,
                    M_Stylist.LastYomi
            ");
            $stmt2->execute();
            $stylists = $stmt2->fetchAll(PDO::FETCH_COLUMN);

            // 予約状況を取得する
            $stmt1 = $this->dbh->prepare("
                SELECT
                    T_ReserveDetail.StartTime,
                    M_Menu.Duration,
                    M_Stylist.LastName AS StylistName
                FROM
                    T_Reservation 
                    INNER JOIN T_ReserveDetail 
                        ON T_ReserveDetail.ReserveNo = T_Reservation.ReserveNo 
                    INNER JOIN M_Stylist 
                        ON M_Stylist.StylistNo = T_ReserveDetail.StylistNo 
                    INNER JOIN M_Menu 
                        ON M_Menu.MenuCd = T_ReserveDetail.MenuCd 
                WHERE
                    T_Reservation.ReserveDate = :reserveDate 
                    AND T_Reservation.Cancel = false 
                    AND M_Stylist.StartDate <= CURRENT_DATE 
                    AND M_Stylist.EndDate >= CURRENT_DATE 
                    AND M_Menu.StartDate <= CURRENT_DATE 
                    AND M_Menu.EndDate >= CURRENT_DATE 
                ORDER BY
                    T_ReserveDetail.StartTime,
                    M_Stylist.RankCd,
                    M_Stylist.LastYomi
            ");
            $stmt1->execute(['reserveDate' => $reserveDate]);
            $reservations = $stmt1->fetchAll();

            // 2次元配列(時刻, スタイリスト)を作成する
            $schedule = [];
            for ($time = strtotime('10:00'); $time <= strtotime('19:30'); $time += 30 * 60) {
                $schedule[date('H:i', $time)] = array_fill(0, count($stylists), '');
            }

            // 予定が入っているスタイリスト名を2次元配列に埋め込む
            foreach ($reservations as $reservation) {
                $startTime = date('H:i', strtotime($reservation['StartTime']));
                $duration = (int)$reservation['Duration'];
                $stylistIndex = array_search($reservation['StylistName'], $stylists);
                if ($stylistIndex !== false) {
                    // 予約時間が30分を超える場合は必要マス分だけ埋め込む
                    for ($i = 0; $i < ceil($duration / 30); $i++) {
                        $timeSlot = date('H:i', strtotime($startTime) + $i * 30 * 60);
                        if (isset($schedule[$timeSlot])) {
                            $schedule[$timeSlot][$stylistIndex] = $reservation['StylistName'];
                        }
                    }
                }
            }

            // 2次元配列からテーブルHTMLを作成する
            $tableHtml = '<tr><th>時間</th>';
            foreach ($stylists as $stylist) {
                $tableHtml .= "<th>$stylist</th>";
            }
            $tableHtml .= '</tr>';
            foreach ($schedule as $time => $row) {
                $tableHtml .= "<tr><td>$time</td>";
                foreach ($row as $cell) {
                    $tableHtml .= "<td>$cell</td>";
                }
                $tableHtml .= '</tr>';
            }
            echo $tableHtml;
            exit;
        }
    }
}

// メイン処理
$extractor = new MakeResavationTable();
$extractor->makeResavationTable();  // 予約状況を表示する
?>