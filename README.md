# Laravel-LINEBot-Sample
LaravelでLine Messaging APIを使った処理のサンプルです。
laravel/framework:v9.38.0
line-bot-sdk:7.6.1を使用。

## できること
- 友達登録
- 友達解除（ブロック・削除）
- テキストメッセージ（オウム返し）
- 画像メッセージ（オウム返し）
  - 実装はしていませんが、動画メッセージや音声なども画像と同じ要領で実装可能です。

## 動作確認
以下のQRコードから友達登録が可能です。

![FriendJoin](projdir/public/friend-join.png)

## その他
友達登録と友達解除だけ、DBを使う関係でテストコードを書いています。
tests/Feature/Api/Line/LineBotControllerTest.phpでやっています。