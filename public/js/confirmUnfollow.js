// confirmUnfollow.js

document.addEventListener('DOMContentLoaded', function() {
  const followButtons = document.querySelectorAll('.follow-btn');
  const confirmUnfollow = document.getElementById('confirm-unfollow');
  const unfollowForm = document.getElementById('unfollow-form');
  const unfollowMessage = document.getElementById('unfollow-message');
  const overlay = document.getElementById('overlay');
  const cancelUnfollow = document.getElementById('cancel-unfollow');

  let activeFollowButton = null;

  followButtons.forEach(button => {
      button.addEventListener('click', function() {
          const followerName = this.dataset.followerName;
          const followerId = this.dataset.followerId;

          // 確認メッセージを設定
          unfollowMessage.textContent = followerName;

          // フォームのアクションURLを設定
          unfollowForm.action = `/users/${followerId}/unfollow`;

          // ポップアップとオーバーレイを表示
          confirmUnfollow.style.display = 'block';
          overlay.style.display = 'block';

          // アクティブなボタンを記録
          activeFollowButton = this;
      });
  });

  // キャンセルボタンでポップアップを閉じる
  cancelUnfollow.addEventListener('click', function() {
      confirmUnfollow.style.display = 'none';
      overlay.style.display = 'none';
      activeFollowButton = null;
  });

  // オーバーレイをクリックした場合にもポップアップを閉じる
  overlay.addEventListener('click', function() {
      confirmUnfollow.style.display = 'none';
      overlay.style.display = 'none';
      activeFollowButton = null;
  });
});

