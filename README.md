# Laravel mini 講義

今日の目標：Laravel の基本的な考え方を知る．

## 初学者が Laravel と仲良くなるポイント 3 選

-   Laravel に思考を合わせろ！

-   Laravel の機能を使え！

-   まずシンプルな CRUD を作れ！

## Laravel に思考を合わせろ！

Laravel は PHP を用いた MVC フレームワーク．Web アプリケーションに必要な機能はだいたい揃っている．

```txt
❎ Laravelを理解する．
✅ Laravelの考え方に自分を合わせる．

❎ 作りたい機能をLaravelでどう実装するか考える．
✅ Laravelの機能に対して作りたい機能をフィットさせる．
```

## Laravel の機能を使え！

Laravel の機能を使うことで，バグを減らしたり複雑な実装を避けることができる．

```txt
❎ 気合で機能を実装する．
✅ Laravelの機能で適したものを探して用いる．
```

## まずシンプルな CRUD を作れ！

### MVC is 何

Laravel は MVC フレームワーク．MVC は役割分担の考え方の一つ．一連の流れを別々のファイルで担当する．

```txt
Model: データベースとのやり取りを担当．
View: ユーザーに表示する画面を担当．
Controller: ModelとViewの橋渡しを担当．最初は「その他全部」でもOK

Route: ユーザーのリクエストをControllerに振り分ける．
```

各機能を知ったら，動作する順番を押さえる！

例：ユーザが一覧画面を見るとき

```txt
1. ユーザ（ブラウザ）が一覧画面をリクエスト
2. Routeが指定されたControllerのメソッドを実行するよう指示
3. ControllerがModelにデータを取得するように指示
4. Modelがデータベースからデータを取得
5. ControllerがViewにデータを渡す
6. Viewが画面のデータを作成
7. コントローラがユーザ（ブラウザ）に画面を返す
```

したがって，この場合の各ファイルが動作する順番は下記の通り．

```txt
Route -> Controller -> Model -> Controller -> View -> Controller
```

> **💡 Point**
>
> -   MVC は一連の処理を各ファイルで役割分担する考え方（の一つ）！
>
> -   まずは Route → Controller の部分が大事！！！

### 実際にやってみた

例：X に似た twitter という sns をつくる．Laravel プロジェクトとユーザ管理機能（Laravel Breeze）を準備した状態からスタート．

-   画面 tweet 一覧画面，tweet 投稿画面，tweet 詳細画面，tweet 編集画面

-   動作 tweet の一覧表示，tweet の投稿，tweet の詳細表示，tweet の編集，tweet の削除

この構成も理由がある．

#### ファイル作成

CURD の機能をつくる場合，まず MVC のファイルを作成する．Model と Controller はコマンドで作成できる．コマンドで作成したほうが名前のミスなどがなく確実．

`-m` オプションはマイグレーションファイルを作成するオプション．`-r` オプションはリソースコントローラファイルを作成するオプション．リソースコントローラは CRUD に必要なメソッドがすでに用意されている．

```bash
php artisan make:model Tweet -mr
```

作成されたマイグレーションファイルに適当な内容を記載し，migration を実行する．また，モデルのファイルには必要なカラム設定やリレーションを設定しておく．

一方，view ファイルはコマンドで作成できないため，手動で作成する．

#### ルーティング

最初にルーティングを設定する．リソースコントローラを使用している場合は 1 行で終わる．

```php
// routes/web.php

Route::resource('tweets', TweetController::class);
```

これで下記のルーティングが設定される．**この表が超重要！！！**

```txt
GET|HEAD        tweets ................................... tweets.index › TweetController@index
POST            tweets ................................... tweets.store › TweetController@store
GET|HEAD        tweets/create .......................... tweets.create › TweetController@create
GET|HEAD        tweets/{tweet} ............................. tweets.show › TweetController@show
PUT|PATCH       tweets/{tweet} ......................... tweets.update › TweetController@update
DELETE          tweets/{tweet} ....................... tweets.destroy › TweetController@destroy
GET|HEAD        tweets/{tweet}/edit ........................ tweets.edit › TweetController@edit
```

#### コントローラ

コントローラのメソッドを実装する．リソースコントローラを使用している場合は，メソッドの中身を記載するだけ．

それぞれのメソッドには下記の役割がある．

```txt
index: 一覧表示
create: 新規作成画面表示
store: 新規作成処理
show: 詳細画面表示
edit: 編集画面表示
update: 編集処理
destroy: 削除処理
```

各メソッドを適当に実装する．大体以下のような感じ．

```txt
index: データを取得 → ビューに渡す → ビューを返す
create: ビューを返す
store: データを検証 → データを保存 → indexにリダイレクト
show: データを取得 → ビューに渡す → ビューを返す
edit: データを取得 → ビューに渡す → ビューを返す
update: データを検証 → データを更新 → indexリダイレクト
destroy: データを削除 → indexにリダイレクト
```

#### ビュー

作成したビューファイルに HTML を記載する．記載する内容は以下のような感じ．

```txt
tweets.index: データを一覧表示
tweets.create: データを入力するフォームを表示
tweets.show: データを詳細表示
tweets.edit: データを編集するフォームを表示

layouts.navigation: ナビゲーションバーに一覧画面と新規作成画面へのリンクを表示
```

> **💡 Point**
>
> 今回まとめて作成しているが，実際は「コントローラの create メソッドを作成 → create.blade.php を作成 → 画面が表示されることを確認 → store メソッドでデータが保存されることを確認」のように，一つずつ確認しながら進めることが大事．

## まとめ

表を見ろ！！！慣れろ！！！やれ！！！
