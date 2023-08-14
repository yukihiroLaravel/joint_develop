//こちらか
(function() {
    'use strict';

    // フラッシュメッセージのfadeout
    $(function(){
        $('.flash_message').fadeOut(3000);
    });

})();

//こちら
$('.flash_message').onLoad(function() {
    $('.flash_message').fadeOut(1000);
  });