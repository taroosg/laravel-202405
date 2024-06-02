<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      {{ __('検索画面') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">
          <form action="{{route('tweets.find')}}" method="POST">
            @csrf
            <input type="text" name="keyword" class="bg-gray-800">
            <button>検索する</button>
          </form>
          @foreach($tweets as $tweet)
          <a href="{{route('tweets.show', $tweet)}}">
            <p class="text-xl m-4">{{$tweet->tweet}}</p>
          </a>
          @endforeach
        </div>
      </div>
    </div>
  </div>
</x-app-layout>