<?php
require_once 'AbstractDbAccess.php';  // DBアクセスの基底クラス

/**
 * メニュー毎の所要時間を取得する
 */
class GetMenuDurations extends AbstractDbAccess
{
    /**
     * メニュー毎の所要時間を取得する
     *
     * @return array メニューコード, 所要時間
     */
    public function getDurations(): array
    {
        $sql = "
        SELECT
            MenuCd
            , Duration
        FROM
            M_Menu 
        WHERE
            StartDate <= CURRENT_DATE 
            AND EndDate >= CURRENT_DATE 
        ORDER BY
            MenuCd
        ";
        try {
            $durations = [];
            $stmt = $this->dbh->query($sql);
            foreach ($stmt as $row) {
                $durations[$row['MenuCd']] = $row['Duration'];
            }
            return $durations;
        } catch (PDOException $e) {
            print('Error:' . $e->getMessage());
            return [];
        }
    }
}

// メイン処理
$fetcher = new GetMenuDurations();

// JSON形式で出力する
header('Content-Type: application/json');
echo json_encode($fetcher->getDurations());
?>