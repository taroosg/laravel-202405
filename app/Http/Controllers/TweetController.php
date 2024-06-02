<?php

namespace App\Http\Controllers;

use App\Mail\UpdateTweetMail;
use App\Models\Tweet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class TweetController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    // データ取得
    $tweets = Tweet::latest()->get();
    return view('tweets.index', compact('tweets'));
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    return view('tweets.create');
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    // dd($request->file('file'));
    $file = $request->file('file');
    // 必要だったらファイルを保存する
    // APIにファイルを送ってテキストを受け取る
    $text = '画像に書いてあった文字列のデータ';

    // データのチェック（バリデーション）
    $request->validate([
      'tweet' => 'required|max:255',
    ]);

    // APIから画像のURLを取得
    $number = rand(1, 1000);
    $response = Http::get("https://pokeapi.co/api/v2/pokemon/{$number}");
    $pokemon = $response->json();
    // dd($pokemon);

    $record = $request->merge([
      'image_url' => $pokemon['sprites']['front_default'],
      // 'ocr_text' => $text,
    ]);

    // データの保存
    $request->user()->tweets()->create($record->all());

    // indexのメソッドにリダイレクト
    return redirect()->route('tweets.index');
  }

  /**
   * Display the specified resource.
   */
  public function show(Tweet $tweet)
  {
    // 天気のAPIから情報を取得
    $weather = '晴れ';
    return view('tweets.show', compact('tweet', 'weather'));
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Tweet $tweet)
  {
    return view('tweets.edit', compact('tweet'));
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, Tweet $tweet)
  {
    // バリデーション
    $request->validate([
      'tweet' => 'required|max:255',
    ]);

    // 上書き
    $tweet->update($request->only('tweet'));

    // メールを送信する処理
    // ログインしているユーザの情報
    $user = auth()->user();
    // ログインしている人のメールアドレス
    $mail = $user->email;
    // メールサーバに送信を依頼する処理
    Mail::to($mail)->send(new UpdateTweetMail($user, $tweet));

    // 一覧
    return redirect()->route('tweets.index');
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Tweet $tweet)
  {
    // 削除
    $tweet->delete();
    // 一覧画面にリダイレクト
    return redirect()->route('tweets.index');
  }

  public function search()
  {
    $tweets = [];
    // 検索キーワードを入力するビューのファイルを返す
    return view('tweets.search', compact('tweets'));
  }

  public function find(Request $request)
  {
    $keyword = $request->keyword;
    // SELECT * FROM tweets WHERE tweet LIKE %キーワード%
    $tweets = Tweet::where("tweet", "LIKE", "%{$keyword}%")->get();
    // dd($tweets);
    // 検索したtweetをビューのファイルに渡す
    return view('tweets.search', compact('tweets'));
  }

  public function mypage()
  {
    // 自分のtweetを取得
    $tweets = Tweet::where('user_id', auth()->id())->get();
    // 検索したtweetをビューのファイルに渡す
    return view('tweets.index', compact('tweets'));
  }
}
