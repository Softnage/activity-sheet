@extends('layouts.app')

@section('content')
<div class="flex">

    <!-- Sidebar -->
    <div x-data="{ isOpen: false }" class="flex lg:block">
        <!-- Mobile Toggle Button -->
        <button 
            @click="isOpen = !isOpen" 
            class="block lg:hidden p-3 text-gray-700 focus:outline-none">
            <i :class="isOpen ? 'fa-solid fa-times' : 'fa-solid fa-bars'" class="text-xl"></i>
        </button>
        
        <!-- Sidebar Content -->
        <div 
            :class="isOpen ? 'fixed z-50 top-0 left-0 h-full bg-gray-50 w-64 p-4 shadow-lg' : 'hidden lg:block'" 
            class="transition-all duration-300">
            <!-- Navigation Menu -->
            <ul class="space-y-4">
                <li>
                    <a href="{{ route('dashboard') }}" 
                       class="flex items-center p-2 rounded-lg transition-all duration-300 
                       {{ Route::is('dashboard') ? 'bg-blue-500 text-white' : 'text-gray-700 hover:bg-blue-100' }}">
                        <i class="fa-solid fa-house mr-3"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('weekly.activities') }}" 
                       class="flex items-center p-2 rounded-lg transition-all duration-300 
                       {{ Route::is('weekly.activities') ? 'bg-blue-500 text-white' : 'text-gray-700 hover:bg-blue-100' }}">
                        <i class="fa-solid fa-calendar-week mr-3"></i>
                        <span>Weekly Activities</span>
                    </a>
                </li>
                @can('isAdmin')
                <li>
                    <a href="{{ route('tasks.assign') }}" 
                       class="flex items-center p-2 rounded-lg transition-all duration-300 
                       {{ Route::is('tasks.assign') ? 'bg-blue-500 text-white' : 'text-gray-700 hover:bg-blue-100' }}">
                        <i class="fa-solid fa-tasks mr-3"></i>
                        <span>Assign Tasks</span>
                    </a>
                </li>
                @endcan
                @cannot('isAdmin')
                <li>
                    <a href="{{ route('activities.index') }}" 
                       class="flex items-center p-2 rounded-lg transition-all duration-300 
                       {{ Route::is('activities.index') ? 'bg-blue-500 text-white' : 'text-gray-700 hover:bg-blue-100' }}">
                        <i class="fa-solid fa-list-check mr-3"></i>
                        <span>My Activities</span>
                    </a>
                </li>
                @endcannot
            </ul>
        </div>
    </div>

<!-- Main Content -->
<div class="w-full md:w-3/4 p-8">
    <!-- Page Header -->
    <div class="text-center mb-8">
        <h2 class="text-3xl font-bold text-gray-800 mb-2">Your Activities</h2>
        <p class="text-lg text-gray-500">Manage and track your tasks and activities effortlessly.</p>
    </div>

    <!-- Search and Filter Section -->
    <div class="flex flex-col sm:flex-row justify-between mb-8 gap-4">
        <!-- Search Form -->
        <div class="w-full sm:w-1/2 md:w-1/3">
            <form method="GET" action="{{ route('activities.index') }}" class="flex w-full items-center">
                <input type="text" name="search" placeholder="Search by title" class="w-full py-3 px-5 bg-gray-50 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-300" value="{{ request('search') }}">
                <button type="submit" class="ml-3 py-3 px-6 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-300">Search</button>
            </form>
        </div>

        <!-- Status Filter -->
        <div class="w-full sm:w-1/2 md:w-1/4">
            <form method="GET" action="{{ route('activities.index') }}" class="w-full">
                <select name="status" class="w-full py-3 px-5 bg-gray-50 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-300" onchange="this.form.submit()">
                    <option value="">Filter by status</option>
                    <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                    <option value="In Progress" {{ request('status') == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                    <option value="Completed" {{ request('status') == 'Completed' ? 'selected' : '' }}>Completed</option>
                </select>
            </form>
        </div>
    </div>

    <!-- Activity List -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($activities as $activity)
            <div class="bg-white shadow-lg rounded-lg p-6 transition transform hover:scale-105 hover:shadow-2xl">
                <h3 class="text-xl font-semibold text-gray-800 mb-3">{{ $activity->title }}</h3>
                <p class="text-gray-600 mb-3">{{ $activity->description }}</p>
                <p class="text-sm text-gray-500">Date: {{ \Carbon\Carbon::parse($activity->date)->format('M d, Y') }}</p>
                <p class="text-sm text-gray-500">Status: 
                    <span class="font-semibold {{ $activity->status == 'Pending' ? 'text-yellow-500' : ($activity->status == 'In Progress' ? 'text-blue-500' : 'text-green-500') }}">
                        {{ $activity->status }}
                    </span>
                </p>
                <div class="mt-4 text-right">
                    <a href="{{ route('activities.edit', $activity->id) }}" class="text-blue-600 hover:text-blue-800 font-semibold">Edit</a>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="mt-6 text-center">
        {{ $activities->links() }}
    </div>
</div>

</div>
@endsection
