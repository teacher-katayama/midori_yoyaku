-- 当該DBが存在する場合は、いったん削除する
DROP DATABASE IF EXISTS yoyakudb;

-- DBを作成する
CREATE DATABASE yoyakudb;

-- カレントDBをsampleに切り替える
USE yoyakudb;
