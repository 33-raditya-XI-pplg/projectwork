<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                    <a href="{{ url('/logout') }}" onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();" class="list-group-item list-group-item-action border-0 "><i class="icofont-logout fs-5 me-3"></i>Keluar</a>
                                        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
