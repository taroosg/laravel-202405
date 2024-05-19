<?php

namespace App\Http\Controllers;

use App\Models\Tweet;
use Illuminate\Http\Request;

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
    // dd($request);
    // データのチェック（バリデーション）
    $request->validate([
      'tweet' => 'required|max:255',
    ]);

    // データの保存
    $request->user()->tweets()->create($request->only('tweet'));

    // indexのメソッドにリダイレクト
    return redirect()->route('tweets.index');
  }

  /**
   * Display the specified resource.
   */
  public function show(Tweet $tweet)
  {
    return view('tweets.show', compact('tweet'));
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
}
