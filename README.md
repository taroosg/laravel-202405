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

## 機能を追加するときの考え方

> **どのタイミングで何を動かしたいのかを明確にするんだッ！！！**

Laravel は流れに沿って動いている．ルーティング → コントローラ → モデル → コントローラ → ビュー → コントローラ，など．コントローラが処理の流れを決めているので，コントローラ内のどこで何を動かしたいのかを考える．

### 例：tweet が更新されたタイミングでメールを送信したい

メール送信を行うためにはメールサーバが必要になる．AWS SES や SendGrid などのサービスを利用する．レンタルサーバにもメールサーバがある場合もある．

開発時に利用できるメールサーバのサービスもある（[Mailtrap](https://mailtrap.io/) など）．

また，Laravel でメールを送信するときは「メールクラス」「メール用のビューファイル」を作成する．実装時の流れは「コントローラ → メールクラス → メールのビューファイル」をなる．

以下の手順で考える．

1. メール送信のための設定を行っておく．

    ```txt
    MAIL_MAILER=smtp
    MAIL_HOST=メールサーバのホスト名
    MAIL_PORT=メールサーバのポート
    MAIL_USERNAME=メールサーバのユーザ名
    MAIL_PASSWORD=メールサーバのパスワード
    ```

2. メールクラスとメール用のビューファイルを作成する．

    ```bash
    # メールクラスの作成
    php artisan make:mail UpdateTweetMail

    # メール用のビューファイルの作成はコマンドがないので手動
    ```

    メールには Laravel 側で扱っているデータを表示することができる．

    例えばメール本文にユーザ名を表示したい場合は，コントローラからメールクラスにユーザのデータを渡し，さらにビューファイルに渡してメール本文にユーザ名を表示する．

3. tweet 更新時の処理を探す（どこに書けばいいのかを決める）．

4. tweet 更新時にメールを送信する処理を追加する（何を書けばいいのかを決める）．

    ```php
    $mail = '送信したいメールアドレス';
    Mail::to($mail)->send(new UpdateTweetMail(auth()->user()));
    ```

### 例：API からデータを取得して DB に保存したい

tweet するときにランダムにポケモンの情報を取得して画像の URL を DB に保存する機能を追加する．

ポケモンの情報を取得するための API は [pokeapi](https://pokeapi.co/) を使用する．以下のように番号（25 部分）を指定することでポケモンの情報を取得できる．

```txt
https://pokeapi.co/api/v2/pokemon/25
```

以下の手順で考える．

1. tweets テーブルに画像の URL を保存するカラムを追加する．

    ```bash
    php artisan make:migration add_image_url_to_tweets_table
    ```

    マイグレーションファイルにカラムを追加する処理を記載し，マイグレーションを実行する．

    ```php
    // マイグレーションファイルに追加するカラムを記載する例
    $table->string('image_url')->nullable();
    ```

    ```bash
    php artisan migrate
    ```

2. 実行する場所を決める（どのタイミングで何を動かしたいのかを明確にする）．

3. API の url に http リクエストを送信してポケモンの情報を取得する処理を追加する．Http クラスを使用する（最初からある）．

    ```php
    $number = rand(1, 1025);
    $pokemon = Http::get('https://pokeapi.co/api/v2/pokemon/' . $number);

    # 欲しい情報を探す
    dd($pokemon->json());
    ```

4. データを DB に保存する処理を追加する．

### 例：tweet 検索

やりたいこと

1.  検索キーワードを入力する画面を表示する．

2.  キーワードを入力して送信するとそのキーワードを含む tweet を検索し，結果の一覧表示画面を表示する．

Laravel でやること

1. 検索キーワードを入力する画面を表示する．

    - 画面を表示するルーティングを設定する．

    - コントローラにビューファイルを返すメソッドを記述する．

    - ビューファイルを作成する．ビューファイルには検索フォームを記載する．

2. キーワードを入力して送信するとそのキーワードを含む tweet を検索し，結果の一覧表示画面を表示する．

    - フォームの送信先を指定するルーティングを設定する．

    - コントローラに tweet を検索する処理を記述する．

    - コントローラにビューファイルを返すメソッドを記述する．

    - ビューファイルを作成する．

## まとめ

どこで何をやるかを明確にしろ！！慣れろ！！！やれ！！！
