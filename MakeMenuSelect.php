<?php
require_once 'AbstractDbAccess.php';  // DBアクセスの基底クラス

/**
 * メニュー情報を一覧表示する
 */
class MakeMenuSelect extends AbstractDbAccess
{
    /**
     * メニュー情報を一覧表示する
     * ・指定されたSQLクエリを実行し、メニュー情報を取得する
     * ・HTMLのoptionタグとして出力する
     *
     * @return void
     */
    public function makeMenuSelect()
    {
        $sql = "
        SELECT
            MenuCd
            , MenuName
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
            $stmt = $this->dbh->query($sql);
            foreach ($stmt as $row) {
                print('<option value="' . $row['MenuCd'] . '" data-name="' . $row['MenuName'] . '">' . $row['MenuName'] . '</option>');
            }
        } catch (PDOException $e) {
            print('Error:' . $e->getMessage());
        }
    }
}

// メイン処理
$extractor = new MakeMenuSelect();
$extractor->makeMenuSelect();  // メニュー情報を一覧表示する
?>