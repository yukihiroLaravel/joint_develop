<?php

if (!function_exists('getRandomDefaultProfileImage')) {
    /**
     * ランダムなデフォルトプロフィール画像を取得する関数
     *
     * @return string デフォルトプロフィール画像のファイル名
     */
    function getRandomDefaultProfileImage()
    {
        $defaultProfileImages = [
            'default-profile-image1.png',
            'default-profile-image2.png',
            'default-profile-image3.png',
            'default-profile-image4.png',
            'default-profile-image5.png',
            'default-profile-image6.png',
            // ランダムなデフォルト画像ファイルのリストを追加する
        ];

        $randomIndex = array_rand($defaultProfileImages);
        return $defaultProfileImages[$randomIndex];
    }
}
