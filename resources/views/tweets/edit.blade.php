<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      {{ __('編集') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">
          <form action="{{route('tweets.update', $tweet)}}" method="POST">
            @csrf
            @method('PUT')
            <input type="text" name="tweet" class="bg-gray-800" value="{{$tweet->tweet}}">
            <div>
              <button>更新する</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>