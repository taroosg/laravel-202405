<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      {{ __('詳細画面') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">
          <p>{{$tweet->tweet}}</p>
          <p>{{$tweet->user->name}}</p>
          <p>{{$tweet->created_at}}</p>
          @if($tweet->user_id === auth()->id())
          <a href="{{route('tweets.edit', $tweet)}}">編集</a>
          <form action="{{route('tweets.destroy', $tweet)}}" method="POST">
            @csrf
            @method('DELETE')
            <button>削除</button>
          </form>
          @endif
        </div>
      </div>
    </div>
  </div>
</x-app-layout>