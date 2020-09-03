<?php
//外部ファイルの読み込み
require_once('../../inc/config.php');
require_once('../../inc/function.php');

//タイムゾーン設定
date_default_timezone_set('Asia/Tokyo');

//例外処理（データベースにレコードを挿入）
try {
  // データベースの接続
  $dbh =  new PDO(DSN , DB_USER , DB_PASSWORD);
  // SQLのエラーが発生したら PDOException という例外のカプセルを投げる設定
  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//count数の呼び出し
  // SQL文の作成
  $sql = 'SELECT * FROM counter';
  // 実行
  $stmt = $dbh->query($sql);
  // 実行結果を連想配列として取得
  $result = $stmt->fetch(PDO::FETCH_ASSOC);

//データベース切断
  $dbh=null;

//例外処理
}catch(PDOException $e){
  echo '接続エラー' . h($e->getMessage());
  exit();
}

//head読み込み
require_once('head.php');
//header読み込み
require_once('header.php');
?>

<h2>プレイ</h2>
<main class="js-gamearea game-area">

<button type="button" class="game-button js-game-button" ontouchstart="" data-start="<?php echo h($result['count']); ?>"><img src="image/egg/egg1.png" class="js-egg game-pic"></button>
<p class="game-text js-game-text">click！</p>
</main>
</body>
</html>
