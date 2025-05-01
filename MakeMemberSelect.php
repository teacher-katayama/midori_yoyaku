<?php
require_once 'AbstractDbAccess.php';  // DBアクセスの基底クラス

/**
 * お客様情報を一覧表示する
 */
class MakeMemberSelect extends AbstractDbAccess
{
    /**
     * お客様情報を一覧表示する
     * ・指定されたSQLクエリを実行し、お客様情報を取得する
     * ・HTMLのoptionタグとして出力する
     *
     * @return void
     */
    public function makeMemberSelect()
    {
        $sql = "
        SELECT
            MemberNo,
            CONCAT(
                LastName,
                ' ',
                FirstName,
                ' 様 📱',
                IFNULL(Tel, '(無し)')
            ) AS MemberInfo,
            CONCAT(
                LEFT (CONCAT(LastYomi, FirstYomi), 2),
                '：',
                LastName,
                ' ',
                FirstName,
                ' 様 📱',
                IFNULL(Tel, '(無し)')
            ) AS MemberData
        FROM
            M_Member
        WHERE
            StartDate <= CURRENT_DATE
            AND EndDate >= CURRENT_DATE
        ORDER BY
            LastYomi,
            FirstYomi
        ";
        try {
            $stmt = $this->dbh->query($sql);
            foreach ($stmt as $row) {
                print('<option value="' . $row['MemberNo'] . '" data-name="' . $row['MemberInfo'] . '">' . $row['MemberData'] . '</option>');
            }
        } catch (PDOException $e) {
            print('Error:' . $e->getMessage());
        }
    }
}

// メイン処理
$fetcher = new MakeMemberSelect();
$fetcher->makeMemberSelect();  // お客様情報を一覧表示する
?>