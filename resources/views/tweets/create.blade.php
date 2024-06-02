<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      {{ __('作成画面') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">
          <form action="{{route('tweets.store')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="text" name="tweet" class="bg-gray-800">
            <input type="file" name="file">
            <button>tweetする</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>