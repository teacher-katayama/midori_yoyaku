<?php
require_once 'AbstractDbAccess.php';  // DBアクセスの基底クラス

/**
 * 合計金額を求める
 */
class CalcAmount extends AbstractDbAccess
{
    /**
     * 合計金額を求める
     *
     * @param [type] $menu (配列)メニューコード
     * @param [type] $stylist (配列)スタイリスト番号
     * @return void
     */
    public function calcAmount($menu, $stylist)
    {
        // 検索条件(メニューコードとスタイリスト番号のペア)を組み立てる
        $where = array();
        for ($i = 0; $i < count($menu); $i++) {
            array_push($where, "( M_Price.MenuCd = '" . $menu[$i] . "' AND M_Stylist.StylistNo = '" . $stylist[$i] . "')");
        }
        $join_where = implode(' OR ', $where);

        $sql = "
        SELECT
            FORMAT(SUM(M_Price.MenuPrice), 0) AS Amount 
        FROM
            M_Price 
            INNER JOIN M_Stylist 
                ON M_Stylist.RankCd = M_Price.RankCd 
        WHERE
            M_Price.StartDate <= CURRENT_DATE 
            AND M_Price.EndDate >= CURRENT_DATE 
            AND M_Stylist.StartDate <= CURRENT_DATE 
            AND M_Stylist.EndDate >= CURRENT_DATE
            AND ( " . $join_where . ")";
        try {
            $stmt = $this->dbh->query($sql);
            foreach ($stmt as $row) {
                echo json_encode(['result' => $row['Amount']]);
            }
        } catch (PDOException $e) {
            print('Error:' . $e->getMessage());
        }
    }
}

// メイン処理
$extractor = new CalcAmount();
$json = file_get_contents('php://input');
$data = json_decode($json, true);

$menu = $data['menu'];
$stylist = $data['stylist'];

$extractor->calcAmount($menu, $stylist);  // 合計金額を求める
?>