<?php
require_once 'AbstractDbAccess.php';  // DBアクセスの基底クラス

/**
 * スタイリスト情報を一覧表示する
 */
class MakeStylistSelect extends AbstractDbAccess
{
    /**
     * スタイリスト情報を一覧表示する
     * ・指定されたSQLクエリを実行し、スタイリスト情報を取得する
     * ・HTMLのoptionタグとして出力する
     *
     * @return void
     */
    public function makeStylistSelect()
    {
        $sql = "
        SELECT
            M_Stylist.StylistNo AS StylistNo
            , CONCAT(M_Stylist.LastName, ' ', M_Stylist.FirstName) AS StylistName
            , M_Stylist.Gender AS Gender
            , M_Rank.Title AS Title
        FROM
            M_Stylist 
            INNER JOIN M_Rank 
                ON M_Rank.RankCd = M_Stylist.RankCd 
        WHERE
            M_Stylist.StartDate <= CURRENT_DATE 
            AND M_Stylist.EndDate >= CURRENT_DATE 
            AND M_Rank.StartDate <= CURRENT_DATE 
            AND M_Rank.EndDate >= CURRENT_DATE 
        ORDER BY
            M_Stylist.RankCd
            , M_Stylist.LastYomi
            , M_Stylist.FirstYomi
        ";
        try {
            $stmt = $this->dbh->query($sql);
            foreach ($stmt as $row) {
                // 性別をアイコンで表示する
                if ($row['Gender'] == 'F') {
                    $gender = '👩';
                } else {
                    $gender = '👦🏻';
                }
                // スタイリスト情報を組み立てる
                $Stylist_info = $row['StylistName'] . ' ' . $gender . $row['Title'];
                print('<option value="' . $row['StylistNo'] . '" data-name="' . $row['StylistName'] . '">' . $Stylist_info . '</option>');
            }
        } catch (PDOException $e) {
            print('Error:' . $e->getMessage());
        }
    }
}

// メイン処理
$extractor = new MakeStylistSelect();
$extractor->makeStylistSelect();  // スタイリスト情報を一覧表示する
?>