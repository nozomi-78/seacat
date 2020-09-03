$(function () {
  let button = $('.js-game-button');
  let gameText = $('.js-game-text');
  let goal = 100000;

  button.click(function () {

    //現在のカウント数取得
    let count = button.attr('data-start');

    //カウント数加算
    count++;

    if (count < goal) {
      //クリック数がgoal未満の時
      $.ajax({
        type: 'POST',
        url: 'php/count-update.php',
        data: {
          'id': 0,
          'count': count
        },
        dataType: 'html',

      }).done(function (data) {

        //data-start属性の値を変更
        button.attr('data-start', count);

        //クリック数ごとにタマゴの画像が変わる
        function egg(click, img) {
          if (count >= click)
            $('.js-egg').attr('src', 'image/egg/' + img + '.png');
        };
        egg(goal - goal / 4 * 3, 'egg2');
        egg(goal - goal / 4 * 2, 'egg3');
        egg(goal - goal / 4 * 1, 'egg4');

      }).fail(function () { });

    } else {
      //クリック数がgoalに達したとき(生まれた時)
      $.ajax({
        type: 'POST',
        url: 'php/cat-update.php',
        data: {
          'id': 0,
          'count': count,
        },
        dataType: 'json',

      }).done(function (data) {

        //data-start属性の値を変更
        button.attr('data-start', 0);
        //たまごの削除
        button.remove();
        //game-textの削除
        gameText.remove();
        //ネコの画像、リンクをアペンドで出す
        $('.js-gamearea').append('<figure><img src="image/cat/' + data['cat_image'] + '.png" alt="' + data['cat_name'] + ' data-cat="' + data['cat_name'] + '" class="game-pic game-cat"></figure>\n<p class="game-text">' + data['cat_name'] + ' が生まれたよ！</p>\n<ul class="clear-nav"><li><a href="gallery.php">図鑑を見る</a></li>\n <li> <a href="">たまごを割る</a></li></ul>')

      }).fail(function () { });

    };
  });
});
