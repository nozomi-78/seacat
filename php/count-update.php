
<?php
//外部ファイルの読み込み
require_once('/home/nozomiinoue/inc/config.php');
require_once('/home/nozomiinoue/inc/function.php');
//タイムゾーン設定
date_default_timezone_set('Asia/Tokyo');

try {
    // データベースへ接続
    $dbh = new PDO(DSN, DB_USER, DB_PASSWORD);

    // エラー発生時に「PDOExceotion」という例外を投げる設定に変更
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    //カウントSQL文の作成
    $sqlCount = 'UPDATE counter SET count = ? WHERE id = ?';

    //カウントステートメント用意
    $stmtCount = $dbh->prepare($sqlCount);

    //カウントを？に入れる
    $stmtCount->bindValue(1, (int)$_POST['count'] , PDO::PARAM_INT);

    //カウントidを？に入れる
    $stmtCount->bindValue(2, (int)$_POST['id'] , PDO::PARAM_INT);

    //カウントステートメントの実行
    $stmtCount->execute();


    // データベースとの接続を終了
    $dbh = null;

  } catch (PDOException $e) {
    //例外発生時の処理
    echo 'エラー' . h($e->getMessage());
    exit();
  }
