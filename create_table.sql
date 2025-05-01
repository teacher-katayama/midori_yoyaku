-- 当該テーブルが存在する場合は、いったん削除する
DROP TABLE IF EXISTS M_Member;
DROP TABLE IF EXISTS M_Stylist;
DROP TABLE IF EXISTS M_Menu;
DROP TABLE IF EXISTS M_Rank;
DROP TABLE IF EXISTS M_Price;
DROP TABLE IF EXISTS T_Reservation;
DROP TABLE IF EXISTS T_ReserveDetail;

-- テーブルを作成する: 会員マスタ
CREATE TABLE M_Member( 
    MemberNo char (4) NOT NULL COMMENT '会員番号'
    , StartDate date COMMENT '有効開始日'
    , EndDate date COMMENT '有効終了日'
    , JoinDate date DEFAULT CURRENT_DATE NOT NULL COMMENT '入会日'
    , LastName varchar (15) COMMENT '苗字'
    , FirstName varchar (15) COMMENT '名前'
    , LastYomi varchar (15) COMMENT '苗字(よみ)'
    , FirstYomi varchar (15) COMMENT '名前(よみ)'
    , Tel char (11) COMMENT '電話番号'
    , Mail varchar (40) COMMENT 'メールアドレス'
    , PRIMARY KEY (MemberNo)
) COMMENT = '会員マスタ'; 

-- テーブルを作成する: スタイリストマスタ
CREATE TABLE M_Stylist( 
    StylistNo char (2) NOT NULL COMMENT 'スタイリスト番号'
    , StartDate date COMMENT '有効開始日'
    , EndDate date COMMENT '有効終了日'
    , LastName varchar (15) COMMENT '苗字'
    , FirstName varchar (15) COMMENT '名前'
    , LastYomi varchar (15) COMMENT '苗字(よみ)'
    , FirstYomi varchar (15) COMMENT '名前(よみ)'
    , HireDate date NOT NULL COMMENT '入社日'
    , RankCd char (1) COMMENT 'ランクコード'
    , Gender char (1) COMMENT '性別'            -- M:男性, F:女性
    , PRIMARY KEY (StylistNo)
) COMMENT = 'スタイリストマスタ'; 

-- テーブルを作成する: メニューマスタ
CREATE TABLE M_Menu( 
    MenuCd char (1) NOT NULL COMMENT 'メニューコード'
    , StartDate date COMMENT '有効開始日'
    , EndDate date COMMENT '有効終了日'
    , MenuName varchar (40) COMMENT 'メニュー名'
    , Duration int DEFAULT 0 NOT NULL COMMENT '所要時間'
    , PRIMARY KEY (MenuCd)
) COMMENT = 'メニューマスタ'; 

-- テーブルを作成する: ランクマスタ
CREATE TABLE M_Rank( 
    RankCd char (1) NOT NULL COMMENT 'ランクコード'
    , StartDate date COMMENT '有効開始日'
    , EndDate date COMMENT '有効終了日'
    , Title varchar (40) COMMENT '肩書'
    , PRIMARY KEY (RankCd)
) COMMENT = 'ランクマスタ'; 

-- テーブルを作成する: 料金マスタ
CREATE TABLE M_Price( 
    MenuCd char (1) NOT NULL COMMENT 'メニューコード'
    , RankCd char (1) NOT NULL COMMENT 'ランクコード'
    , StartDate date COMMENT '有効開始日'
    , EndDate date COMMENT '有効終了日'
    , MenuPrice int DEFAULT 0 NOT NULL COMMENT '料金'
    , PRIMARY KEY (MenuCd, RankCd)
) COMMENT = '料金マスタ'; 

-- テーブルを作成する: 予約
CREATE TABLE T_Reservation( 
    ReserveNo int NOT NULL COMMENT '予約番号'
    , MemberNo char (4) COMMENT '会員番号'
    , FIRST boolean DEFAULT false COMMENT '初回'
    , ReserveDate date COMMENT '予約日'
    , Remarks varchar (50) COMMENT '補足'
    , Cancel boolean DEFAULT false COMMENT 'キャンセル'
    , RegistDate timestamp COMMENT '予約日時'
    , PRIMARY KEY (ReserveNo)
) COMMENT = '予約'; 

-- テーブルを作成する: 予約明細
CREATE TABLE T_ReserveDetail( 
    ReserveNo int NOT NULL COMMENT '予約番号'
    , MenuCd char (1) NOT NULL COMMENT 'メニューコード'
    , StartTime datetime COMMENT '開始時刻'
    , StylistNo char (2) NOT NULL COMMENT 'スタイリスト番号'
    , PRIMARY KEY (ReserveNo, MenuCd)
) COMMENT = '予約明細';


-- レコードを追加する: 会員マスタ
INSERT INTO M_Member VALUES('0001','1000-01-01','9999-12-31','2004-04-10','吉田','康子','よしだ','やすこ','0901112215 ','yoshida@a1.com');
INSERT INTO M_Member VALUES('0002','1000-01-01','9999-12-31','2016-08-11','荒木','和子','あらき','かずこ','0901112216 ','araki@a2.com');
INSERT INTO M_Member VALUES('0003','1000-01-01','9999-12-31','2017-04-12','下田','正一','しもだ','しょういち','0901112217 ','shimoda@a3.com');
INSERT INTO M_Member VALUES('0004','1000-01-01','9999-12-31','2017-06-13','風間','由美子','かざま','ゆみこ','0901112218 ',NULL);
INSERT INTO M_Member VALUES('0005','1000-01-01','9999-12-31','2019-01-14','秋山','美奈','あきやま','みな','0901112219 ','akiyama@a5.com');
INSERT INTO M_Member VALUES('0006','1000-01-01','9999-12-31','2019-04-15','木下','博之','きのした','ひろゆき','0901112220 ','kinoshita@a6.com');
INSERT INTO M_Member VALUES('0007','1000-01-01','9999-12-31','2020-09-16','広瀬','正隆','ひろせ','まさたか',NULL,NULL);
INSERT INTO M_Member VALUES('0008','1000-01-01','9999-12-31','2020-04-17','斎藤','美紀','さいとう','みき','0901112222 ','saitou@a8.com');

-- レコードを追加する: スタイリストマスタ
INSERT INTO M_Stylist VALUES('01','1000-01-01','9999-12-31','秋葉','ちか','あきば','ちか','2002-04-01','A','F');
INSERT INTO M_Stylist VALUES('02','1000-01-01','9999-12-31','佐藤','茜','さとう','あかね','2004-06-01','B','F');
INSERT INTO M_Stylist VALUES('03','1000-01-01','9999-12-31','井上','博之','いのうえ','ひろゆき','2007-01-08','B','M');
INSERT INTO M_Stylist VALUES('04','1000-01-01','9999-12-31','小島','正','こじま','ただし','2014-05-02','C','M');
INSERT INTO M_Stylist VALUES('05','1000-01-01','9999-12-31','山田','雄介','やまだ','ゆうすけ','2019-04-01','C','M');
INSERT INTO M_Stylist VALUES('06','1000-01-01','9999-12-31','市川','紀子','いちかわ','のりこ','2022-06-01','D','F');

-- レコードを追加する: メニューマスタ
INSERT INTO M_Menu VALUES('C','1000-01-01','9999-12-31','カット',30);
INSERT INTO M_Menu VALUES('P','1000-01-01','9999-12-31','パーマ',60);
INSERT INTO M_Menu VALUES('R','1000-01-01','9999-12-31','カラー',60);
INSERT INTO M_Menu VALUES('T','1000-01-01','9999-12-31','トリートメント',30);

-- レコードを追加する: ランクマスタ
INSERT INTO M_Rank VALUES('A','1000-01-01','9999-12-31','チーフスタイリスト');
INSERT INTO M_Rank VALUES('B','1000-01-01','9999-12-31','トップスタイリスト');
INSERT INTO M_Rank VALUES('C','1000-01-01','9999-12-31','スタイリスト');
INSERT INTO M_Rank VALUES('D','1000-01-01','9999-12-31','練習生');

-- レコードを追加する: 料金マスタ
INSERT INTO M_Price VALUES('C','A','1000-01-01','9999-12-31',12000);
INSERT INTO M_Price VALUES('C','B','1000-01-01','9999-12-31',10000);
INSERT INTO M_Price VALUES('C','C','1000-01-01','9999-12-31',8000);
INSERT INTO M_Price VALUES('C','D','1000-01-01','9999-12-31',6000);
INSERT INTO M_Price VALUES('P','A','1000-01-01','9999-12-31',18000);
INSERT INTO M_Price VALUES('P','B','1000-01-01','9999-12-31',15000);
INSERT INTO M_Price VALUES('P','C','1000-01-01','9999-12-31',12000);
INSERT INTO M_Price VALUES('P','D','1000-01-01','9999-12-31',9000);
INSERT INTO M_Price VALUES('R','A','1000-01-01','9999-12-31',9600);
INSERT INTO M_Price VALUES('R','B','1000-01-01','9999-12-31',8000);
INSERT INTO M_Price VALUES('R','C','1000-01-01','9999-12-31',6400);
INSERT INTO M_Price VALUES('R','D','1000-01-01','9999-12-31',5000);
INSERT INTO M_Price VALUES('T','A','1000-01-01','9999-12-31',14400);
INSERT INTO M_Price VALUES('T','B','1000-01-01','9999-12-31',12000);
INSERT INTO M_Price VALUES('T','C','1000-01-01','9999-12-31',9600);
INSERT INTO M_Price VALUES('T','D','1000-01-01','9999-12-31',8000);

-- レコードを追加する: 予約
INSERT INTO T_Reservation VALUES(1,'0002',0,'2024-11-28',NULL,0,'2024-05-26 18:17:30');
INSERT INTO T_Reservation VALUES(2,'0004',0,'2024-11-28',NULL,0,'2024-05-26 18:17:36');
INSERT INTO T_Reservation VALUES(3,'0008',0,'2024-11-28',NULL,0,'2024-05-26 18:17:42');
INSERT INTO T_Reservation VALUES(4,'0001',0,'2024-11-29',NULL,0,'2024-05-26 18:31:31');
INSERT INTO T_Reservation VALUES(5,'0001',0,'2024-11-30',NULL,0,'2024-06-09 07:33:00');
INSERT INTO T_Reservation VALUES(6,'0002',0,'2024-11-30',NULL,0,'2024-06-09 07:34:00');
INSERT INTO T_Reservation VALUES(7,'0003',0,'2024-11-30',NULL,0,'2024-06-09 07:35:00');
INSERT INTO T_Reservation VALUES(8,'0004',0,'2024-11-30',NULL,0,'2024-06-09 07:36:00');
INSERT INTO T_Reservation VALUES(9,'0005',0,'2024-11-30',NULL,0,'2024-06-09 07:37:00');
INSERT INTO T_Reservation VALUES(10,'0006',0,'2024-11-30',NULL,0,'2024-06-09 07:38:00');
INSERT INTO T_Reservation VALUES(11,'0007',0,'2024-11-30',NULL,0,'2024-06-09 07:39:00');
INSERT INTO T_Reservation VALUES(12,'0008',0,'2024-11-30',NULL,0,'2024-06-09 07:40:00');
INSERT INTO T_Reservation VALUES(13,'0001',0,'2024-11-30',NULL,0,'2024-06-09 07:41:00');
INSERT INTO T_Reservation VALUES(14,'0002',0,'2024-11-30',NULL,0,'2024-06-09 07:42:00');

-- レコードを追加する: 予約明細
INSERT INTO T_ReserveDetail VALUES(1,'C','2024-11-28 14:00:00','01');
INSERT INTO T_ReserveDetail VALUES(1,'R','2024-11-28 14:30:00','02');
INSERT INTO T_ReserveDetail VALUES(2,'C','2024-11-28 16:30:00','01');
INSERT INTO T_ReserveDetail VALUES(3,'C','2024-11-28 13:00:00','01');
INSERT INTO T_ReserveDetail VALUES(3,'P','2024-11-28 13:30:00','03');
INSERT INTO T_ReserveDetail VALUES(3,'R','2024-11-28 14:30:00','03');
INSERT INTO T_ReserveDetail VALUES(4,'C','2024-11-29 10:00:00','03');
INSERT INTO T_ReserveDetail VALUES(4,'R','2024-11-29 10:30:00','06');
INSERT INTO T_ReserveDetail VALUES(5,'C','2024-11-30 10:30:00','01');
INSERT INTO T_ReserveDetail VALUES(5,'P','2024-11-30 11:00:00','01');
INSERT INTO T_ReserveDetail VALUES(5,'R','2024-11-30 12:00:00','02');
INSERT INTO T_ReserveDetail VALUES(5,'T','2024-11-30 13:00:00','03');
INSERT INTO T_ReserveDetail VALUES(6,'C','2024-11-30 12:30:00','01');
INSERT INTO T_ReserveDetail VALUES(6,'P','2024-11-30 13:00:00','01');
INSERT INTO T_ReserveDetail VALUES(6,'T','2024-11-30 14:00:00','02');
INSERT INTO T_ReserveDetail VALUES(7,'C','2024-11-30 14:30:00','01');
INSERT INTO T_ReserveDetail VALUES(7,'P','2024-11-30 15:00:00','01');
INSERT INTO T_ReserveDetail VALUES(7,'R','2024-11-30 16:00:00','02');
INSERT INTO T_ReserveDetail VALUES(7,'T','2024-11-30 17:00:00','03');
INSERT INTO T_ReserveDetail VALUES(8,'C','2024-11-30 16:30:00','01');
INSERT INTO T_ReserveDetail VALUES(8,'P','2024-11-30 17:00:00','01');
INSERT INTO T_ReserveDetail VALUES(8,'R','2024-11-30 18:00:00','02');
INSERT INTO T_ReserveDetail VALUES(9,'C','2024-11-30 18:30:00','01');
INSERT INTO T_ReserveDetail VALUES(9,'T','2024-11-30 19:00:00','03');
INSERT INTO T_ReserveDetail VALUES(10,'C','2024-11-30 11:00:00','03');
INSERT INTO T_ReserveDetail VALUES(10,'T','2024-11-30 11:30:00','02');
INSERT INTO T_ReserveDetail VALUES(11,'C','2024-11-30 15:00:00','03');
INSERT INTO T_ReserveDetail VALUES(11,'T','2024-11-30 15:30:00','02');
INSERT INTO T_ReserveDetail VALUES(12,'C','2024-11-30 17:30:00','02');
INSERT INTO T_ReserveDetail VALUES(13,'C','2024-11-30 18:00:00','04');
INSERT INTO T_ReserveDetail VALUES(14,'C','2024-11-30 18:30:00','05');
INSERT INTO T_ReserveDetail VALUES(14,'T','2024-11-30 19:00:00','06');
