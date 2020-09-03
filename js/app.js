//▼header.php
//hamburger button
let headerButton = document.querySelectorAll('.js-header-button')[0];
let headerNavInner = document.querySelectorAll('.js-header-nav-inner')[0];
headerButton.addEventListener('click', function () {
  this.classList.toggle('header-active');
  headerNavInner.classList.toggle('header-open');
});

//▼gallery.php
//modal window
let gaCatLink = document.querySelectorAll('.js-ga-cat-link'); //ネコのサムネ要素を取得
let gaModal = document.querySelectorAll('.js-ga-modal');//モーダルウィンドウエリアの取得
let gaModalClose = document.querySelectorAll('.ga-modal-close');//閉じるボタンの取得

function modal(target) {
  for (let i = 0; i < gaCatLink.length; i++) {//全ネコのサムネ要素を出す
    target[i].addEventListener('click', function (e) {//クリックしたtargetの

      let idData = e.currentTarget.getAttribute('data-id');//カスタムデータ(id)を取得
      let id = parseInt(idData);//カスタムデータ(id)を数値に変換
      let gaModalId = document.querySelector('#ga-modal' + id);//モーダルウィンドウIDの取得(idだからAllで取得しない)

      if (target == gaCatLink) {//クリックしたものがネコのサムネ要素なら
        gaModalId.classList.add('ga-modal-open');

      } else if (target == gaModalClose) {//クリックしたものが閉じるボタンなら
        gaModalId.classList.remove('ga-modal-open');
      };
    });
  };
};
modal(gaCatLink);
modal(gaModalClose);
