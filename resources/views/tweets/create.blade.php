<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      {{ __('新規作成') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">
          <form action="{{route('tweets.store')}}" method="POST">
            @csrf
            <input type="text" name="tweet" class="bg-gray-800">
            <div>
              <button>tweetする</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>