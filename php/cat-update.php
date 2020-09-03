<?php
//外部ファイルの読み込み
require_once('/home/nozomiinoue/inc/config.php');
require_once('/home/nozomiinoue/inc/function.php');
//タイムゾーン設定
date_default_timezone_set('Asia/Tokyo');

//例外処理（データベースにレコードを挿入）
try {
  // データベースの接続
  $dbh =  new PDO(DSN , DB_USER , DB_PASSWORD);
  // SQLのエラーが発生したら PDOException という例外のカプセルを投げる設定
  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  //カウントSQL文の作成
  $sqlCount = 'UPDATE counter SET count = ? WHERE id = ?';
  //カウントステートメント用意
  $stmtCount = $dbh->prepare($sqlCount);
  //カウントを？に入れる
  $stmtCount->bindValue(1, 0 , PDO::PARAM_INT);
  //カウントidを？に入れる
  $stmtCount->bindValue(2, (int)$_POST['id'] , PDO::PARAM_INT);
  //カウントステートメントの実行
  $stmtCount->execute();

  //登録ねこ一覧からランダムに1レコード抽出
  $sqlNew = 'SELECT * FROM picture_book ORDER BY RAND() LIMIT 1';
  $stmtNew = $dbh->query($sqlNew);
  $resultNew = $stmtNew->fetch(PDO::FETCH_ASSOC);

//ランダムに出たねこをデータベースに登録

    //ランダムに出された猫はpicture_getに登録されているかのチェック
    $sqlCheck='SELECT count(*)AS totle  FROM picture_get WHERE cat_image=?';
    $stmtCheck=$dbh->prepare($sqlCheck);
    $stmtCheck->bindValue(1,$resultNew['cat_image'],PDO::PARAM_STR);
    $stmtCheck->execute();
    $check=$stmtCheck->fetch(PDO::FETCH_ASSOC);

    if($check['totle']<1){
      //登録されてない場合、INSERT で登録
      $sqlCat='INSERT INTO picture_get(cat_image,get_score,first_created)VALUES(?,1,now())';
      $stmtCat=$dbh->prepare($sqlCat);
      $stmtCat->bindValue(1,$resultNew['cat_image'],PDO::PARAM_STR);
      $stmtCat->execute();

    }else{

      //登録されてる場合
        //どのidと被っているか
      $sqlId='SELECT * FROM picture_get WHERE cat_image=?';
      $stmtId=$dbh->prepare($sqlId);
      $stmtId->bindValue(1,$resultNew['cat_image'],PDO::PARAM_STR);
      $stmtId->execute();
      $id=$stmtId->fetch(PDO::FETCH_ASSOC);

        //被ってるIDにget+1
      $sqlCat='UPDATE picture_get SET get_score=? WHERE id=?';
      $stmtCat=$dbh->prepare($sqlCat);
      $stmtCat->bindValue(1,$id['get_score']+1,PDO::PARAM_INT);
      $stmtCat->bindValue(2,$id['id'],PDO::PARAM_INT);
      $stmtCat->execute();

    };



  echo json_encode($resultNew);

//データベース切断
  $dbh=null;

//例外処理
}catch(PDOException $e){
  echo '接続エラー' . h($e->getMessage());
  exit();
}

?>
