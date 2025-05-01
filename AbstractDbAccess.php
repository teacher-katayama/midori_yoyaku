<?php

/**
 * DBアクセスの基底クラス
 */
abstract class AbstractDbAccess
{
    protected $dsn;  // DB接続先
    protected $user;  // ユーザーID
    protected $password;  // パスワード
    protected $dbh;  // DBハンドラ

    /**
     * コンストラクタ
     * DB接続情報を受け取り、接続を確立する
     *
     * @param [type] $dsn: DB接続先
     * @param [type] $user: ユーザーID
     * @param [type] $password: パスワード
     */
    public function __construct()
    {
        $this->dsn = 'mysql:dbname=yoyakudb;host=localhost;charset=utf8mb4';
        $this->user = 'root';
        $this->password = '';
        $this->connect();  // DBに接続1する
    }

    /**
     * DBに接続する
     * 接続失敗時にはエラーメッセージを表示する
     *
     * @return void
     */
    private function connect()
    {
        try {
            $this->dbh = new PDO($this->dsn, $this->user, $this->password);
            if ($this->dbh == null) {
                print('接続に失敗しました。<br>');
            }
        } catch (PDOException $e) {
            print('Error:' . $e->getMessage());
            die();
        }
    }

    /**
     * デストラクタ
     * データベース接続を閉じる
     */
    public function __destruct()
    {
        $this->dbh = null;
    }
}
?>