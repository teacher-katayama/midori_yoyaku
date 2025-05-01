<?php
require_once 'AbstractDbAccess.php';  // DBアクセスの基底クラス

/**
 * 新規予約を登録する
 */
class InsertNewResavation extends AbstractDbAccess
{
    /**
     * メニューの所要時間を取得する
     *
     * @param [type] $menuCd メニューコード
     * @return int 所要時間
     */
    public function getDuration($menuCd): int
    {
        $sql = "
        SELECT
            Duration 
        FROM
            M_Menu 
        WHERE
            MenuCd = '" . $menuCd . "' 
            AND StartDate <= CURRENT_DATE 
            AND EndDate >= CURRENT_DATE
        ";
        try {
            $stmt = $this->dbh->query($sql);
            foreach ($stmt as $row) {
                return $row['Duration'];
            }
        } catch (PDOException $e) {
            print('Error:' . $e->getMessage());
            return 0;
        }
    }

    /**
     * 日時を指定時間(分)進める
     *
     * @param DateTime $dt 対象の日時
     * @param string $duration 指定時間(分)
     * @return DateTime 計算後の日時
     */
    function addDuration(DateTime $dt, string $duration): DateTime
    {
        // 文字列の$durationを整数に変換
        $minutes = intval($duration);
        
        // DateTimeオブジェクトをクローンして新しいインスタンスを作成
        $newDt = clone $dt;
        
        // 指定された分数を加算
        $newDt->add(new DateInterval("PT{$minutes}M"));
        
        return $newDt;
    }

    /**
     * 予約番号を採番する
     *
     * @return int 予約番号
     */
    public function getNewReserveNo(): int
    {
        $sql = "
        SELECT
            MAX(ReserveNo) + 1 AS NewReserveNo 
        FROM
            T_Reservation";
        try {
            $stmt = $this->dbh->query($sql);
            foreach ($stmt as $row) {
                return $row['NewReserveNo'];
            }
        } catch (PDOException $e) {
            print('Error:' . $e->getMessage());
            return 0;
        }
    }

    /**
     * 予約テーブルにレコードを追加する
     *
     * @param [type] $newReserveNo 予約番号
     * @param [type] $memberNo 会員番号
     * @param [type] $targetDate 開始時刻
     * @return void
     */
    public function insert_T_Reservation($newReserveNo, $memberNo, $targetDate)
    {
        $sql = "
        INSERT 
        INTO T_Reservation 
        VALUES ( " . $newReserveNo . "
            , '" . $memberNo . "'
            , 0
            , '" . $targetDate . "'
            , NULL
            , 0
            , CURRENT_TIMESTAMP
        )";
        try {
            // SQLクエリの実行
            $stmt = $this->dbh->prepare($sql);
            $stmt->execute();
        } catch (PDOException $e) {
            print('Error:' . $e->getMessage());
        }
    }

    /**
     * 予約明細テーブルにレコードを追加する
     *
     * @param [type] $newReserveNo 予約番号
     * @param [type] $targetDate 予約日
     * @param [type] $targetTime 開始時刻
     * @param [type] $menu (配列)メニュー
     * @param [type] $stylist (配列)スタイリスト
     * @return void
     */
    public function insert_T_ReserveDetail($newReserveNo, $targetDate, $targetTime, $menu, $stylist)
    {
        $dt = new DateTime($targetDate . " " . $targetTime);
        $tt = $targetTime;
        for ($i = 0; $i < count($menu); $i++) {
            $sql = "
            INSERT 
            INTO T_ReserveDetail 
            VALUES ( " . $newReserveNo . "
                , '" . $menu[$i] . "'
                , '" . $dt->format('Y-m-d H:i:s') . "'
                , '" . $stylist[$i] . "'
            )";
            try {
                // SQLクエリの実行
                $stmt = $this->dbh->prepare($sql);
                $stmt->execute();
            } catch (PDOException $e) {
                print('Error:' . $e->getMessage());
            }

            // 次のメニューの開始時刻を決める
            $dt = $this->addDuration($dt, $this->getDuration($menu[$i]));
        }
    }
}

// メイン処理
$extractor = new InsertNewResavation();
$json = file_get_contents('php://input');
$data = json_decode($json, true);

$targetDate = $data['targetDate'];
$memberNo = $data['memberNo'];
$targetTime = $data['targetTime'];
$menu = $data['menu'];
$stylist = $data['stylist'];

$newReserveNo = $extractor->getNewReserveNo();  // 予約番号を採番する
$extractor->insert_T_Reservation($newReserveNo, $memberNo, $targetDate);  // 予約テーブルにレコードを追加する
$extractor->insert_T_ReserveDetail($newReserveNo, $targetDate, $targetTime, $menu, $stylist);  // 予約明細テーブルにレコードを追加する
?>