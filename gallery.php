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

//テーブル結合（picture_bookとpicture_get）
$galleryData=
'SELECT
b.id,
b.cat_name,
g.cat_image,
b.cat_text,
g.get_score,
g.first_created
FROM picture_book AS b LEFT OUTER JOIN picture_get AS g
ON b.cat_image=g.cat_image ORDER BY id ASC';

$gallerys =$dbh->query($galleryData);
$gallery=$gallerys->fetchAll(PDO::FETCH_ASSOC);

//picture_getのgetトータル
$getSum=$dbh->query('select SUM(get_score) AS total from picture_get');
$get=$getSum->fetch(PDO::FETCH_ASSOC);

//データベース切断
$dbh=null;

//例外処理
}catch(PDOException $e){
  echo '接続エラー' . h($e->getMessage());
  exit();
};

//ページタイトル
$page_title='図鑑';
//head読み込み
require_once('head.php');
//header読み込み
require_once('header.php');
?>

<h2><?php echo $page_title ?></h2>

 <main>
   <p class="ga-get-text">全部で <span class="ga-get-total"><?php echo h($get['total'])?></span> 匹のネコさんが生まれました。</p>
   <div class="gallery">
<?php foreach($gallery as $cat) : ?>

<article class="ga-cat ja-ga-cat">

 <!-- ▼図鑑に登録されていたら▼ -->
<?php if(!empty($cat['cat_image'])):?>

 <div class="inview ga-cat-hover" ontouchstart="" data-type="slideUpIn">
<a href="#ga-modal<?php echo h($cat['id']) ?>" class="js-ga-cat-link ga-cat-link" data-id="<?php echo h($cat['id']) ?>">
<p class="ga-cat-no">No.<?php echo h($cat['id']) ?></p>
  <h3 class="cat-name"><?php echo h($cat['cat_name']) ?></h3>
  <figure class="ga-cat-image">
    <img src="image/cat/<?php echo $cat['cat_image'].'.png';?>" alt="<?php echo h($cat['cat_name']) ?>">
  </figure>
  <p class="ga-cat-get"><?php echo h($cat['get_score']) ?></p>
</a>
</div>

<!-- ▼モーダルウィンドウ▼ -->
<section id="ga-modal<?php echo h($cat['id']) ?>" class="ga-modal js-ga-modal">
<div class="ga-modal-inner">
  <p>No.<?php echo h($cat['id']) ?></p>
  <h4  class="cat-name"><?php echo h($cat['cat_name']) ?></h4>
<div class="ga-modal-content">
  <figure class="ga-modal-image">
    <img src="image/cat/<?php echo $cat['cat_image'].'.png';?>" alt="<?php echo h($cat['cat_name']) ?>">
  </figure>
  <dl class="ga-modal-text">
    <dt>生まれた数</dt>
    <dd><?php echo h($cat['get_score']) ?> 匹</dd>
    <dt>初めて出会った日</dt>
    <dd><?php echo h($cat['first_created']) ?></dd>
    <dt>説明</dt>
    <dd><?php echo h($cat['cat_text']) ?></dd>
  </dl>
</div>
  <button class="ga-modal-close" data-id="<?php echo h($cat['id']) ?>">とじる</button>
</div>
</section>

<!-- ▼図鑑未登録▼ -->
<?php else: ?>
   <div class="inview" data-type="slideUpIn">
  <p class="ga-cat-no">No.<?php echo h($cat['id']) ?></p>
    <h3 class="cat-name">?????</h3>
  <figure class="ga-cat-image">
    <img src="image/cat/null.png" alt="未確認">
  </figure>
      <p class="ga-cat-get">0</p>
  </div>
<?php endif;?>

</article>

<?php endforeach; ?>
</div>
</main>
<p><a href="#top" class="ga-top-link">トップへ</a></p>
</body>
</html>
