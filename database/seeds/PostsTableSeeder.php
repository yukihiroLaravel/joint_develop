<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $seedMaxUser = 100; // 100人のユーザが存在するため
        $posts = []; // 空配列を初期値として設定

        // スポーツや趣味の名前リストを作成
        $hobbies = [
            'サッカー', 'バスケットボール', 'テニス', 'ロードバイク', 'ジョギング',
            'スイミング', 'スキー', 'スノーボード', '登山', '釣り',
            'キャンプ', 'ハイキング', '絵画', '音楽', 'ダンス',
            '料理', '読書', '映画鑑賞', '写真撮影', 'ガーデニング',
            'マウンテンバイク', 'グラベルロードバイク', 'ピストバイク', 'フットサル', '卓球',
            'バドミントン', 'ビリヤード', 'ボウリング', 'ゴルフ', 'ボクシング',
            'ムエタイ', '空手', '柔道', '剣道', '合気道',
            'ヨガ', 'ピラティス', 'ストレッチ', 'ボディビル', 'パワーリフティング',
            'クライミング', 'ボルダリング', 'カヤック', 'サーフィン', 'ウィンドサーフィン',
            'ダイビング', 'シュノーケリング', 'ウィンタースポーツ', 'ラグビー', 'アメリカンフットボール',
            'クリケット', 'ホッケー', 'ラクロス', 'フィールドホッケー', 'カーリング',
            'チェス', '将棋', '囲碁', 'ポーカー', 'ビデオゲーム',
            'テーブルトップゲーム', 'パズル', 'レゴ', '模型作り', 'プラモデル',
            '刺繍', '編み物', '手芸', '裁縫', 'カリグラフィー',
            '盆栽', 'サボテン育て', 'ベランダ菜園', '家庭菜園', '畑仕事',
            '自転車ツーリング', 'ランニング', 'ウォーキング', 'ジムトレーニング', 'フィットネス',
            'ビーチバレー', 'フリスビー', 'パークゴルフ', 'ゴーカート', 'モータースポーツ',
            'ペット散歩', '鳥の観察', '天体観測', '昆虫採集', '植物観察',
            '歴史探訪', '博物館巡り', '美術館巡り', '神社仏閣巡り', '旅行',
            '温泉巡り', '食べ歩き', 'カフェ巡り', 'レストラン巡り', 'ワインテイスティング',
            'ビール醸造', '日本酒テイスティング', 'コーヒー淹れ', '紅茶淹れ', 'チョコレートテイスティング',
            'パソコン操作', 'iMac', 'プログラミング', 'ウェブデザイン', 'グラフィックデザイン',
            '動画編集', '写真編集', 'ブログ執筆', 'オンラインコース受講', '3Dプリント',
            'ドローン操作', '電子工作', 'ロボット工学', 'AR/VR体験', 'ソフトウェア開発'
        ];

        // 趣味ごとの投稿コメントテンプレート
        $hobby_comments = [
            'サッカー' => [
                "本日大分県大分市にあるレゾナックドーム大分にてサッカー観戦！頑張れトリニータ！⚽️",
                "今日は友達と一緒にサッカーをしました！楽しかった！",
                "サッカーの練習がハードだったけど、充実した一日でした。"
            ],
            'バスケットボール' => [
                "バスケの試合で大勝利！チーム全員で喜びました🏀",
                "今日はバスケットボールの練習試合。いい汗かきました！",
                "友達とバスケを楽しみました。スリーポイントが決まりました！"
            ],
            'テニス' => [
                "テニスの試合で勝利！コーチも喜んでくれました🎾",
                "テニスのダブルスを楽しみました。良いペアが見つかりました！",
                "今日はテニスコートで特訓。サーブが上達しました！"
            ],
            'ロードバイク' => [
                "山梨県での富士ヒルクライム大会イベントに参加しました🚵今年はブロンズメダル獲得！",
                "新しいロードバイクを手に入れて、週末のライドが楽しみです。",
                "今日は100kmのロングライドに挑戦してみました！疲れたけど達成感があります。"
            ],
            'ジョギング' => [
                "今朝はジョギングで10km走りました🏃気持ち良かった！",
                "ジョギング中に綺麗な景色に出会いました。リフレッシュできました！",
                "毎日のジョギングが習慣になってきました。健康に良いですね！"
            ],
            'スイミング' => [
                "今日はプールでたくさん泳ぎました🏊‍♂️気分爽快です！",
                "スイミングの練習でタイムが少しずつ上がってきました。",
                "友達と一緒にプールでリラックスしてきました。"
            ],
            'スキー' => [
                "スキー旅行に行ってきました⛷️雪質が最高でした！",
                "今日はスキーのレッスン。インストラクターに褒められました！",
                "家族でスキーを楽しみました。楽しい一日でした。"
            ],
            'スノーボード' => [
                "スノーボードで新しい技に挑戦🏂成功して嬉しい！",
                "友達とスノーボードを楽しみました。最高の一日でした！",
                "スノーパークで楽しい時間を過ごしました。"
            ],
            '登山' => [
                "今日は登山に行ってきました⛰️頂上の景色が最高でした！",
                "登山で新しいルートを開拓しました。冒険心がくすぐられます！",
                "友達と一緒に山登り。疲れたけど充実した時間でした。"
            ],
            '釣り' => [
                "今日は早起きして釣りに行ってきました🎣大物が釣れて大満足！",
                "友達と釣りに行って、のんびりとした時間を過ごしました。",
                "新しい釣り具を試してみました。釣果も上々です！"
            ],
            'キャンプ' => [
                "週末はキャンプに行ってきました🏕️自然の中でリラックスできました。",
                "初めてのソロキャンプ！焚き火でコーヒーを淹れてみました☕️",
                "キャンプ仲間とバーベキュー🍖美味しい食事と楽しい時間を過ごしました。"
            ],
            'ハイキング' => [
                "今日はハイキングに出かけました🚶‍♂️自然に癒されました。",
                "友達と一緒にハイキング。いい運動になりました！",
                "ハイキングコースで新しい景色を楽しみました。"
            ],
            '絵画' => [
                "今日は絵を描く時間を楽しみました🎨心が落ち着きます。",
                "新しい画材を使って絵を描いてみました。楽しい発見がありました！",
                "絵画教室で学んだ技術を試してみました。上手く描けました！"
            ],
            '音楽' => [
                "今日は音楽鑑賞の一日🎶お気に入りのアルバムを聴きました。",
                "新しい楽器を始めました！音楽がますます楽しくなります。",
                "音楽フェスに参加してきました。最高の体験でした！"
            ],
            'ダンス' => [
                "ダンスのレッスンで新しいステップを習得💃楽しかった！",
                "友達と一緒にダンスパーティーを楽しみました。",
                "ダンスコンテストで入賞しました！嬉しい瞬間です。"
            ],
            '料理' => [
                "今日は家でイタリアンを作ってみました🍝家族にも大好評でした！",
                "新しいレシピに挑戦！自分でも驚くほど美味しくできました。",
                "料理教室に参加してきました。たくさんの新しい技術を学べました🍳"
            ],
            '読書' => [
                "今日は一日中読書に没頭📚お気に入りのカフェでゆったりと過ごしました。",
                "新しい小説を読み始めました！ストーリーに引き込まれています。",
                "図書館でたくさんの本を借りてきました。これから読むのが楽しみです。"
            ],
            '映画鑑賞' => [
                "最新の映画を観てきました🎬とても感動的でした。",
                "お気に入りの映画をもう一度観ました。やっぱり最高！",
                "映画館でポップコーンを食べながら映画鑑賞🍿至福の時間です。"
            ],
            '写真撮影' => [
                "今日は友達とフォトウォーク📸たくさんの素敵な写真が撮れました！",
                "朝早く起きて日の出の写真を撮影🌅美しい瞬間をカメラに収めました。",
                "新しいカメラレンズを試してみました。撮影がますます楽しくなります！"
            ],
            'ガーデニング' => [
                "今日は庭でガーデニングを楽しみました🌷花が咲いてきて嬉しいです。",
                "新しい植物を植えてみました。成長が楽しみです！",
                "ガーデニングでリラックスした時間を過ごしました。"
            ],
            'マウンテンバイク' => [
                "山でマウンテンバイクを楽しみました🚵‍♂️自然の中で最高の体験でした。",
                "新しいコースを開拓して、マウンテンバイクを楽しみました。",
                "友達と一緒にマウンテンバイクツーリング。冒険心がくすぐられます！"
            ],
            'グラベルロードバイク' => [
                "今日はグラベルロードバイクで新しい道を探索🚴‍♂️楽しい発見がいっぱいでした。",
                "グラベルロードバイクのイベントに参加しました。良い運動になりました！",
                "新しいグラベルバイクのタイヤを試してみました。走りやすかったです。"
            ],
            'ピストバイク' => [
                "今日はピストバイクで街中をサイクリング🚲スリリングな体験でした。",
                "ピストバイクのレースに参加してきました。興奮の一日でした！",
                "新しいピストバイクをカスタマイズしてみました。最高の乗り心地です。"
            ],
            'フットサル' => [
                "今日は友達とフットサルを楽しみました⚽️いい運動になりました！",
                "フットサルの試合でゴールを決めました。嬉しい瞬間です！",
                "フットサルの練習で新しい技術を習得。充実した時間でした。"
            ],
            '卓球' => [
                "友達と卓球を楽しみました🏓楽しい時間を過ごしました！",
                "卓球の試合で勝利しました。いい運動になりました。",
                "卓球クラブに参加して、新しい友達ができました。"
            ],
            'バドミントン' => [
                "バドミントンの試合で大勝利🏸チーム全員で喜びました！",
                "今日はバドミントンの練習。いい汗かきました！",
                "友達とバドミントンを楽しみました。楽しい一日でした。"
            ],
            'ビリヤード' => [
                "ビリヤードで久しぶりに勝利しました🎱気分がいいです。",
                "今日はビリヤードバーで友達と楽しみました。リラックスできました。",
                "ビリヤードの新しい技を習得しました。楽しかったです！"
            ],
            'ボウリング' => [
                "今日はボウリングに行ってきました🎳ストライクがたくさん出て楽しかった！",
                "友達とボウリング大会。盛り上がりました！",
                "ボウリングのスコアが自己ベストを更新しました。嬉しい！"
            ],
            'ゴルフ' => [
                "今日はゴルフ場でラウンドしてきました🏌️‍♂️スコアが良くて気分上々です。",
                "ゴルフの練習に行ってきました。スイングが少しずつ上達しています。",
                "友達とゴルフコンペ。楽しい時間を過ごしました。"
            ],
            'ボクシング' => [
                "ボクシングジムでトレーニングしてきました🥊いい汗かきました！",
                "ボクシングのスパーリングで勝利。自信がつきました！",
                "ボクシングの新しい技術を習得。練習が楽しいです。"
            ],
            'ムエタイ' => [
                "ムエタイのトレーニングでいい汗かきました🥋",
                "今日はムエタイのスパーリング。強くなった気がします！",
                "ムエタイの試合で勝利しました。嬉しい瞬間です。"
            ],
            '空手' => [
                "空手の稽古で新しい技を習得しました🥋",
                "空手の試合で勝利。自信がつきました！",
                "空手道場で良い汗をかきました。気分爽快です。"
            ],
            '柔道' => [
                "柔道の稽古で技を磨きました。充実した時間でした🥋",
                "柔道の試合で勝利。仲間と喜びを分かち合いました！",
                "柔道のトレーニングで体力がついてきました。"
            ],
            '剣道' => [
                "剣道の稽古で新しい技を習得しました。やりがいがあります！",
                "剣道の試合で勝利しました。達成感があります。",
                "剣道の道場で良い汗をかきました。気分爽快です。"
            ],
            '合気道' => [
                "合気道の稽古で新しい技を習得しました。充実した時間でした！",
                "合気道の試合で勝利しました。嬉しい瞬間です。",
                "合気道の道場で良い汗をかきました。リフレッシュできました。"
            ],
            'ヨガ' => [
                "今日はヨガのクラスでリラックスしてきました🧘‍♀️",
                "ヨガのポーズが上手くできるようになってきました。嬉しいです！",
                "ヨガマットを新調して、ヨガの時間が楽しみになりました。"
            ],
            'ピラティス' => [
                "ピラティスのレッスンで体が軽くなりました🧘‍♂️",
                "今日はピラティスでしっかりと体を動かしました。気分爽快です！",
                "ピラティスの新しいエクササイズに挑戦。いい運動になりました。"
            ],
            'ストレッチ' => [
                "毎日のストレッチで体が柔らかくなってきました🧘‍♀️",
                "今日はストレッチでリラックス。体が軽くなりました！",
                "新しいストレッチ方法を試してみました。効果を実感しています。"
            ],
            'ボディビル' => [
                "ボディビルのトレーニングで筋肉がついてきました💪",
                "今日はボディビルの大会に出場してきました。充実した時間でした！",
                "ボディビルのジムで新しいトレーニング方法を学びました。"
            ],
            'パワーリフティング' => [
                "パワーリフティングの練習で自己ベストを更新しました🏋️‍♂️",
                "今日はパワーリフティングの大会に出場。いい結果が出ました！",
                "パワーリフティングのジムで新しい技術を習得しました。"
            ],
            'クライミング' => [
                "クライミングジムで新しいルートに挑戦しました🧗‍♂️",
                "今日はクライミングの大会に参加してきました。楽しかったです！",
                "友達と一緒にクライミング。いい運動になりました。"
            ],
            'ボルダリング' => [
                "ボルダリングジムで新しい課題に挑戦しました🧗‍♀️",
                "今日はボルダリングの練習でいい汗かきました！",
                "友達と一緒にボルダリング。楽しい時間を過ごしました。"
            ],
            'カヤック' => [
                "今日はカヤックで川を下りました🚣‍♂️自然の中でリフレッシュ！",
                "カヤックの練習で新しい技を習得しました。充実した時間でした！",
                "友達とカヤックを楽しみました。冒険心がくすぐられます！"
            ],
            'サーフィン' => [
                "サーフィンで波乗りを楽しみました🏄‍♂️最高の気分です！",
                "今日はサーフィンの大会に参加。いい結果が出ました！",
                "サーフィンのレッスンで新しい技を習得しました。"
            ],
            'ウィンドサーフィン' => [
                "ウィンドサーフィンで風を感じました🏄‍♂️気持ち良かった！",
                "今日はウィンドサーフィンの練習。技術が向上してきました。",
                "友達と一緒にウィンドサーフィンを楽しみました。"
            ],
            'ダイビング' => [
                "今日はダイビングで綺麗な海を楽しみました🐠",
                "ダイビングのレッスンで新しい技術を学びました。楽しかったです！",
                "友達と一緒にダイビング。素晴らしい海の世界を堪能しました。"
            ],
            'シュノーケリング' => [
                "シュノーケリングで色とりどりの魚を見ました🐟",
                "今日はシュノーケリングでリラックス。海の中は癒されます！",
                "友達とシュノーケリングを楽しみました。素晴らしい時間でした。"
            ],
            'ウィンタースポーツ' => [
                "今日はウィンタースポーツを楽しみました⛷️雪の中で最高の体験！",
                "ウィンタースポーツの大会に参加してきました。いい結果が出ました！",
                "友達と一緒にウィンタースポーツを楽しみました。"
            ],
            'ラグビー' => [
                "ラグビーの試合で勝利しました🏉チーム全員で喜びました！",
                "今日はラグビーの練習。いい汗かきました！",
                "友達とラグビーを楽しみました。楽しい一日でした。"
            ],
            'アメリカンフットボール' => [
                "アメリカンフットボールの試合で勝利しました🏈チーム全員で喜びました！",
                "今日はアメフトの練習。いい汗かきました！",
                "友達とアメフトを楽しみました。楽しい一日でした。"
            ],
            'クリケット' => [
                "クリケットの試合で勝利しました🏏チーム全員で喜びました！",
                "今日はクリケットの練習。いい汗かきました！",
                "友達とクリケットを楽しみました。楽しい一日でした。"
            ],
            'ホッケー' => [
                "ホッケーの試合で勝利しました🏒チーム全員で喜びました！",
                "今日はホッケーの練習。いい汗かきました！",
                "友達とホッケーを楽しみました。楽しい一日でした。"
            ],
            'ラクロス' => [
                "ラクロスの試合で勝利しました🏑チーム全員で喜びました！",
                "今日はラクロスの練習。いい汗かきました！",
                "友達とラクロスを楽しみました。楽しい一日でした。"
            ],
            'フィールドホッケー' => [
                "フィールドホッケーの試合で勝利しました🏑チーム全員で喜びました！",
                "今日はフィールドホッケーの練習。いい汗かきました！",
                "友達とフィールドホッケーを楽しみました。楽しい一日でした。"
            ],
            'カーリング' => [
                "カーリングの試合で勝利しました🥌チーム全員で喜びました！",
                "今日はカーリングの練習。いい汗かきました！",
                "友達とカーリングを楽しみました。楽しい一日でした。"
            ],
            'チェス' => [
                "今日はチェスで頭を使いました。いい頭の体操になりました♟️",
                "チェスの大会で勝利しました。嬉しい瞬間です！",
                "友達とチェスを楽しみました。いい刺激になりました。"
            ],
            '将棋' => [
                "今日は将棋で頭を使いました。いい頭の体操になりました♟️",
                "将棋の大会で勝利しました。嬉しい瞬間です！",
                "友達と将棋を楽しみました。いい刺激になりました。"
            ],
            '囲碁' => [
                "今日は囲碁で頭を使いました。いい頭の体操になりました⚫️⚪️",
                "囲碁の大会で勝利しました。嬉しい瞬間です！",
                "友達と囲碁を楽しみました。いい刺激になりました。"
            ],
            'ポーカー' => [
                "今日はポーカーで友達と楽しい時間を過ごしました♠️",
                "ポーカーの大会で勝利しました。嬉しい瞬間です！",
                "友達とポーカーを楽しみました。いい刺激になりました。"
            ],
            'ビデオゲーム' => [
                "今日は新しいビデオゲームを楽しみました🎮最高の時間！",
                "友達と一緒にビデオゲーム大会。盛り上がりました！",
                "ビデオゲームでハイスコアを更新しました。嬉しい！"
            ],
            'テーブルトップゲーム' => [
                "今日はテーブルトップゲームで楽しい時間を過ごしました🎲",
                "友達とテーブルトップゲーム大会。盛り上がりました！",
                "新しいテーブルトップゲームを試してみました。楽しい！"
            ],
            'パズル' => [
                "今日はパズルに挑戦🧩完成させて達成感があります！",
                "新しいパズルを始めました。楽しみながら進めています。",
                "友達と一緒にパズルを完成させました。楽しい時間でした！"
            ],
            'レゴ' => [
                "今日はレゴで新しい作品を作りました🧱創造力が刺激されます！",
                "友達と一緒にレゴを楽しみました。楽しい時間でした。",
                "レゴの新しいセットを組み立てました。満足の出来上がりです！"
            ],
            '模型作り' => [
                "今日は模型作りに没頭しました。細部までこだわりました！",
                "新しい模型キットを組み立てました。満足の出来栄えです。",
                "友達と一緒に模型作りを楽しみました。楽しい時間でした！"
            ],
            'プラモデル' => [
                "今日はプラモデルを作成。完成品に満足しています！",
                "新しいプラモデルキットを始めました。楽しみながら作っています。",
                "友達とプラモデル作りを楽しみました。楽しい時間でした！"
            ],
            '刺繍' => [
                "今日は刺繍に挑戦🧵新しいデザインが完成しました！",
                "友達と刺繍を楽しみました。楽しい時間でした。",
                "新しい刺繍キットを試してみました。素敵な作品ができました！"
            ],
            '編み物' => [
                "今日は編み物に没頭🧶新しい作品が完成しました！",
                "友達と編み物を楽しみました。楽しい時間でした。",
                "新しい編み物のパターンに挑戦。満足の出来栄えです！"
            ],
            '手芸' => [
                "今日は手芸に挑戦。新しい作品が完成しました！",
                "友達と手芸を楽しみました。楽しい時間でした。",
                "新しい手芸キットを試してみました。満足の出来栄えです！"
            ],
            '裁縫' => [
                "今日は裁縫に挑戦。新しいデザインが完成しました！",
                "友達と裁縫を楽しみました。楽しい時間でした。",
                "新しい裁縫キットを試してみました。満足の出来栄えです！"
            ],
            'カリグラフィー' => [
                "今日はカリグラフィーに挑戦。新しい作品が完成しました！",
                "友達とカリグラフィーを楽しみました。楽しい時間でした。",
                "新しいカリグラフィーキットを試してみました。満足の出来栄えです！"
            ],
            '盆栽' => [
                "今日は盆栽の手入れをしました🌱綺麗に仕上がりました！",
                "友達と盆栽を楽しみました。楽しい時間でした。",
                "新しい盆栽を始めました。成長が楽しみです！"
            ],
            'サボテン育て' => [
                "今日はサボテンの手入れをしました🌵元気に育っています！",
                "友達とサボテンを楽しみました。楽しい時間でした。",
                "新しいサボテンを始めました。成長が楽しみです！"
            ],
            'ベランダ菜園' => [
                "今日はベランダ菜園で新しい植物を育てました🌿楽しみです！",
                "友達とベランダ菜園を楽しみました。楽しい時間でした。",
                "新しいベランダ菜園キットを始めました。成長が楽しみです！"
            ],
            '家庭菜園' => [
                "今日は家庭菜園で新しい植物を育てました🌿楽しみです！",
                "友達と家庭菜園を楽しみました。楽しい時間でした。",
                "新しい家庭菜園キットを始めました。成長が楽しみです！"
            ],
            '畑仕事' => [
                "今日は畑仕事で新しい植物を育てました🌿楽しみです！",
                "友達と畑仕事を楽しみました。楽しい時間でした。",
                "新しい畑仕事キットを始めました。成長が楽しみです！"
            ],
            '自転車ツーリング' => [
                "今日は自転車ツーリングで新しい道を探索🚴‍♂️楽しい発見がいっぱいでした。",
                "自転車ツーリングのイベントに参加しました。良い運動になりました！",
                "新しい自転車のタイヤを試してみました。走りやすかったです。"
            ],
            'ランニング' => [
                "今朝はランニングで10km走りました🏃気持ち良かった！",
                "ランニング中に綺麗な景色に出会いました。リフレッシュできました！",
                "毎日のランニングが習慣になってきました。健康に良いですね！"
            ],
            'ウォーキング' => [
                "今日はウォーキングで新しい道を探索🚶‍♂️楽しい発見がいっぱいでした。",
                "ウォーキングのイベントに参加しました。良い運動になりました！",
                "新しいウォーキングシューズを試してみました。歩きやすかったです。"
            ],
            'ジムトレーニング' => [
                "ジムトレーニングで筋力アップを目指して頑張りました💪",
                "今日はジムトレーニングのクラスに参加。いい汗かきました！",
                "ジムで新しいトレーニング方法を試してみました。効果を感じています！"
            ],
            'フィットネス' => [
                "今日はフィットネスクラスで体を動かしました🏋️‍♀️気分爽快です！",
                "フィットネスの新しいプログラムに挑戦。いい運動になりました！",
                "フィットネスジムで友達と一緒にトレーニング。楽しい時間でした。"
            ],
            'ビーチバレー' => [
                "今日はビーチバレーで友達と楽しみました🏐いい運動になりました！",
                "ビーチバレーの試合で勝利。嬉しい瞬間です！",
                "ビーチバレーの練習で新しい技術を習得しました。充実した時間でした。"
            ],
            'フリスビー' => [
                "今日はフリスビーで友達と楽しみました。いい運動になりました！",
                "フリスビーの大会で勝利しました。嬉しい瞬間です！",
                "フリスビーの練習で新しい技術を習得しました。充実した時間でした。"
            ],
            'パークゴルフ' => [
                "今日はパークゴルフで友達と楽しみました。いい運動になりました！",
                "パークゴルフの試合で勝利しました。嬉しい瞬間です！",
                "パークゴルフの練習で新しい技術を習得しました。充実した時間でした。"
            ],
            'ゴーカート' => [
                "今日はゴーカートで友達と楽しみました。スリリングな体験でした！",
                "ゴーカートの大会で勝利しました。嬉しい瞬間です！",
                "ゴーカートの練習で新しい技術を習得しました。充実した時間でした。"
            ],
            'モータースポーツ' => [
                "今日はモータースポーツでスリリングな体験を楽しみました🏎️",
                "モータースポーツの大会で勝利しました。嬉しい瞬間です！",
                "モータースポーツの練習で新しい技術を習得しました。充実した時間でした。"
            ],
            'ペット散歩' => [
                "今日はペットと一緒に散歩🐕気持ち良かったです！",
                "ペットの散歩中に素敵な景色に出会いました。",
                "ペットと散歩する時間が一番の癒しです。"
            ],
            '鳥の観察' => [
                "今日は鳥の観察に出かけました。たくさんの種類を見つけました！",
                "鳥の観察で新しい発見がありました。楽しい時間でした。",
                "友達と一緒に鳥の観察を楽しみました。"
            ],
            '天体観測' => [
                "今日は天体観測で星空を楽しみました🌌素敵な時間でした！",
                "天体観測のイベントに参加しました。素晴らしい体験でした。",
                "新しい望遠鏡で天体観測。感動の一言です！"
            ],
            '昆虫採集' => [
                "今日は昆虫採集に出かけました。珍しい昆虫を見つけました！",
                "昆虫採集で新しい発見がありました。楽しい時間でした。",
                "友達と一緒に昆虫採集を楽しみました。"
            ],
            '植物観察' => [
                "今日は植物観察で新しい発見がありました🌿楽しい時間でした！",
                "植物観察のイベントに参加しました。素晴らしい体験でした。",
                "友達と一緒に植物観察を楽しみました。"
            ],
            '歴史探訪' => [
                "今日は歴史探訪で新しい知識を得ました。興味深い一日でした！",
                "歴史探訪のイベントに参加しました。素晴らしい体験でした。",
                "友達と一緒に歴史探訪を楽しみました。"
            ],
            '博物館巡り' => [
                "今日は博物館巡りで新しい知識を得ました。興味深い一日でした！",
                "博物館巡りのイベントに参加しました。素晴らしい体験でした。",
                "友達と一緒に博物館巡りを楽しみました。"
            ],
            '美術館巡り' => [
                "今日は美術館巡りで新しい発見がありました🎨楽しい時間でした！",
                "美術館巡りのイベントに参加しました。素晴らしい体験でした。",
                "友達と一緒に美術館巡りを楽しみました。"
            ],
            '神社仏閣巡り' => [
                "今日は神社仏閣巡りで新しい発見がありました。楽しい時間でした！",
                "神社仏閣巡りのイベントに参加しました。素晴らしい体験でした。",
                "友達と一緒に神社仏閣巡りを楽しみました。"
            ],
            '旅行' => [
                "週末は小旅行に行ってきました👜新しい場所を探索するのは楽しい！",
                "友達と一緒に温泉旅行♨️リラックスできました。",
                "海外旅行に行ってきました✈️色んな文化に触れて素晴らしい体験でした。"
            ],
            '温泉巡り' => [
                "今日は温泉巡りでリラックスしました♨️最高の一日でした！",
                "温泉巡りのイベントに参加しました。素晴らしい体験でした。",
                "友達と一緒に温泉巡りを楽しみました。"
            ],
            '食べ歩き' => [
                "今日は食べ歩きで新しいお店を発見🍣美味しかったです！",
                "食べ歩きのイベントに参加しました。素晴らしい体験でした。",
                "友達と一緒に食べ歩きを楽しみました。"
            ],
            'カフェ巡り' => [
                "今日はカフェ巡りで新しいお店を発見☕️楽しかったです！",
                "カフェ巡りのイベントに参加しました。素晴らしい体験でした。",
                "友達と一緒にカフェ巡りを楽しみました。"
            ],
            'レストラン巡り' => [
                "今日はレストラン巡りで新しいお店を発見🍴美味しかったです！",
                "レストラン巡りのイベントに参加しました。素晴らしい体験でした。",
                "友達と一緒にレストラン巡りを楽しみました。"
            ],
            'ワインテイスティング' => [
                "今日はワインテイスティングで新しい発見がありました🍷楽しい時間でした！",
                "ワインテイスティングのイベントに参加しました。素晴らしい体験でした。",
                "友達と一緒にワインテイスティングを楽しみました。"
            ],
            'ビール醸造' => [
                "今日はビール醸造に挑戦🍺新しい発見がありました！",
                "ビール醸造のイベントに参加しました。素晴らしい体験でした。",
                "友達と一緒にビール醸造を楽しみました。"
            ],
            '日本酒テイスティング' => [
                "今日は日本酒テイスティングで新しい発見がありました🍶楽しい時間でした！",
                "日本酒テイスティングのイベントに参加しました。素晴らしい体験でした。",
                "友達と一緒に日本酒テイスティングを楽しみました。"
            ],
            'コーヒー淹れ' => [
                "今日はコーヒーを淹れてリラックス☕️最高の一日でした！",
                "コーヒー淹れのイベントに参加しました。素晴らしい体験でした。",
                "友達と一緒にコーヒーを淹れて楽しみました。"
            ],
            '紅茶淹れ' => [
                "今日は紅茶を淹れてリラックス🫖最高の一日でした！",
                "紅茶淹れのイベントに参加しました。素晴らしい体験でした。",
                "友達と一緒に紅茶を淹れて楽しみました。"
            ],
            'チョコレートテイスティング' => [
                "今日はチョコレートテイスティングで新しい発見がありました🍫楽しい時間でした！",
                "チョコレートテイスティングのイベントに参加しました。素晴らしい体験でした。",
                "友達と一緒にチョコレートテイスティングを楽しみました。"
            ],
            'パソコン操作' => [
                "今日はパソコン操作に没頭しました💻新しいスキルを学びました！",
                "友達と一緒にパソコン操作を楽しみました。楽しい時間でした。",
                "新しいパソコンを使って作業が捗ります！"
            ],
            'iMac' => [
                "今日は新しいiMacで作業をしました💻最高の一日でした！",
                "iMacの新しい機能を試してみました。素晴らしい体験でした。",
                "友達と一緒にiMacを楽しみました。"
            ],
            'プログラミング' => [
                "今日はプログラミングに没頭しました💻新しいスキルを学びました！",
                "友達と一緒にプログラミングを楽しみました。楽しい時間でした。",
                "新しいプログラミング言語を学んでいます。興味深い内容です！"
            ],
            'ウェブデザイン' => [
                "今日はウェブデザインに挑戦しました🌐新しいスキルを学びました！",
                "友達と一緒にウェブデザインを楽しみました。楽しい時間でした。",
                "新しいウェブデザインのツールを試してみました。素晴らしい体験でした！"
            ],
            'グラフィックデザイン' => [
                "今日はグラフィックデザインに挑戦しました🎨新しいスキルを学びました！",
                "友達と一緒にグラフィックデザインを楽しみました。楽しい時間でした。",
                "新しいグラフィックデザインのツールを試してみました。素晴らしい体験でした！"
            ],
            '動画編集' => [
                "今日は動画編集に挑戦しました🎬新しいスキルを学びました！",
                "友達と一緒に動画編集を楽しみました。楽しい時間でした。",
                "新しい動画編集のツールを試してみました。素晴らしい体験でした！"
            ],
            '写真編集' => [
                "今日は写真編集に挑戦しました📸新しいスキルを学びました！",
                "友達と一緒に写真編集を楽しみました。楽しい時間でした。",
                "新しい写真編集のツールを試してみました。素晴らしい体験でした！"
            ],
            'ブログ執筆' => [
                "今日はブログ執筆に挑戦しました📝新しいスキルを学びました！",
                "友達と一緒にブログ執筆を楽しみました。楽しい時間でした。",
                "新しいブログ記事を公開しました。達成感があります！"
            ],
            'オンラインコース受講' => [
                "今日はオンラインコースを受講しました💻新しい知識を得ました！",
                "友達と一緒にオンラインコースを楽しみました。楽しい時間でした。",
                "新しいオンラインコースに挑戦。興味深い内容ばかりです！"
            ],
            '3Dプリント' => [
                "今日は3Dプリントに挑戦しました🖨️新しいスキルを学びました！",
                "友達と一緒に3Dプリントを楽しみました。楽しい時間でした。",
                "新しい3Dプリントのツールを試してみました。素晴らしい体験でした！"
            ],
            'ドローン操作' => [
                "今日はドローン操作に挑戦しました🚁新しいスキルを学びました！",
                "友達と一緒にドローン操作を楽しみました。楽しい時間でした。",
                "新しいドローンのツールを試してみました。素晴らしい体験でした！"
            ],
            '電子工作' => [
                "今日は電子工作に挑戦しました🔧新しいスキルを学びました！",
                "友達と一緒に電子工作を楽しみました。楽しい時間でした。",
                "新しい電子工作のツールを試してみました。素晴らしい体験でした！"
            ],
            'ロボット工学' => [
                "今日はロボット工学に挑戦しました🤖新しいスキルを学びました！",
                "友達と一緒にロボット工学を楽しみました。楽しい時間でした。",
                "新しいロボット工学のツールを試してみました。素晴らしい体験でした！"
            ],
            'AR/VR体験' => [
                "今日はAR/VR体験に挑戦しました🕶️新しいスキルを学びました！",
                "友達と一緒にAR/VR体験を楽しみました。楽しい時間でした。",
                "新しいAR/VRのツールを試してみました。素晴らしい体験でした！"
            ],
            'ソフトウェア開発' => [
                "今日はソフトウェア開発に挑戦しました💻新しいスキルを学びました！",
                "友達と一緒にソフトウェア開発を楽しみました。楽しい時間でした。",
                "新しいソフトウェア開発のツールを試してみました。素晴らしい体験でした！"
            ]
        ];

        // 繰り返し処理で初期ポスト用の多次元配列を作成
        for ($userId = 1; $userId <= $seedMaxUser; $userId++) {
            for ($i = 1; $i <= 11; $i++) { // 各ユーザにつき11件の投稿を作成
                // ランダムに趣味を選択
                $hobby = $hobbies[array_rand($hobbies)];
                // 選ばれた趣味に対応するランダムなコメントを取得
                $comment = $hobby_comments[$hobby][array_rand($hobby_comments[$hobby])];

                // 現在から過去1週間の範囲でランダムな日時を生成
                $createdAt = Carbon::now()->subDays(rand(0, 7))->subHours(rand(0, 23))->subMinutes(rand(0, 59));

                $posts[] = [
                    'user_id' => $userId, // 1から100までのユーザIDを割り当て
                    'content' => $comment, // ランダムなコメントを追加
                    'created_at' => $createdAt, // ランダムな日時を設定
                    'updated_at' => $createdAt // 同じランダムな日時を設定
                ];
            }
        }

        // データベースに投稿を挿入
        DB::table('posts')->insert($posts);
    }
}
