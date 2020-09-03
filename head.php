<?php
$site_title="シーキャット";
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="description" content="不思議な海のネコさん「シーキャット」。たまごをひたすらクリックして、孵ったシーキャットをコレクションしていきましょう。どの子に出会えるかは生まれてからのお楽しみ。ふいにﾌﾌｯと、ほんのり笑顔になってもらえたら嬉しいです。">

<link rel="stylesheet" type="text/css" href="css/reset.css">
<link rel="stylesheet" type="text/css" href="css/style.css">
<link rel="stylesheet" type="text/css" href="css/inview.min.css">


  <!-- ▼jquery -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js" defer></script>

  <!-- ▼javascript -->
  <script src="js/game-system.js" defer></script>
  <script src="js/app.js" defer></script>
  <script src="js/inview.min.js" defer></script>

  <title><?php
    if(isset($page_title)){
      echo $page_title. '｜' .$site_title;
    }else{
      echo $site_title;
    };
  ?></title>
</head>
