@extends('layouts.app')

@section('content')

<div class="flex h-screen overflow-hidden">

    <!-- Sidebar -->
    <div x-data="{ isOpen: true }" class="flex h-full bg-gray-50 shadow-lg transition-all duration-300">
        <div :class="isOpen ? 'w-64' : 'w-20'" class="p-4 h-full transition-all duration-300">
            <!-- Toggle Button -->
            <button @click="isOpen = !isOpen" class="text-gray-600 focus:outline-none mb-4 w-full text-left">
                <i :class="isOpen ? 'fa-solid fa-chevron-left' : 'fa-solid fa-chevron-right'" class="text-lg"></i>
            </button>

            <!-- Navigation Menu -->
            <ul class="space-y-4">
                <!-- Dashboard -->
                <li>
                    <a href="{{ route('dashboard') }}" 
                       class="flex items-center p-3 rounded-lg transition-all duration-300 
                       {{ Route::is('dashboard') ? 'bg-blue-500 text-white' : 'text-gray-700 hover:bg-blue-100' }}">
                        <i class="fa-solid fa-house mr-3"></i>
                        <span x-show="isOpen" class="transition-all duration-300">Dashboard</span>
                    </a>
                </li>

                <!-- Weekly Activities -->
                <li>
                    <a href="{{ route('weekly.activities') }}" 
                       class="flex items-center p-3 rounded-lg transition-all duration-300 
                       {{ Route::is('weekly.activities') ? 'bg-blue-500 text-white' : 'text-gray-700 hover:bg-blue-100' }}">
                        <i class="fa-solid fa-calendar-week mr-3"></i>
                        <span x-show="isOpen" class="transition-all duration-300">Weekly Activities</span>
                    </a>
                </li>

                <!-- User Links -->
                @cannot('isAdmin')
                    <!-- User Activities -->
                    <li>
                        <a href="{{ route('activities.index') }}" 
                           class="flex items-center p-3 rounded-lg transition-all duration-300 
                           {{ Route::is('activities.index') ? 'bg-blue-500 text-white' : 'text-gray-700 hover:bg-blue-100' }}">
                            <i class="fa-solid fa-list-check mr-3"></i>
                            <span x-show="isOpen" class="transition-all duration-300">My Activities</span>
                        </a>
                    </li>

                    <!-- User Tasks -->
                    <li>
                        <a href="{{ route('activities.tasks') }}" 
                           class="flex items-center p-3 rounded-lg transition-all duration-300 
                           {{ Route::is('activities.tasks') ? 'bg-blue-500 text-white' : 'text-gray-700 hover:bg-blue-100' }}">
                            <i class="fa-solid fa-tasks mr-3"></i>
                            <span x-show="isOpen" class="transition-all duration-300">My Tasks</span>
                        </a>
                    </li>
                @endcannot

                <!-- Admin Links -->
                @can('isAdmin')
                    <!-- Admin Dashboard -->
                    <li>
                        <a href="{{ route('admin.dashboard') }}" 
                           class="flex items-center p-3 rounded-lg transition-all duration-300 
                           {{ Route::is('admin.dashboard') ? 'bg-blue-500 text-white' : 'text-gray-700 hover:bg-blue-100' }}">
                            <i class="fa-solid fa-tachometer-alt mr-3"></i>
                            <span x-show="isOpen" class="transition-all duration-300">Admin Dashboard</span>
                        </a>
                    </li>

                    <!-- Admin Manage Users -->
                    <li>
                        <a href="{{ route('admin.manageUsers') }}" 
                           class="flex items-center p-3 rounded-lg transition-all duration-300 
                           {{ Route::is('admin.manageUsers') ? 'bg-blue-500 text-white' : 'text-gray-700 hover:bg-blue-100' }}">
                            <i class="fa-solid fa-users-cog mr-3"></i>
                            <span x-show="isOpen" class="transition-all duration-300">Manage Users</span>
                        </a>
                    </li>

                    <!-- Admin Tasks -->
                    <li>
                        <a href="{{ route('admin.viewAllTasks') }}" 
                           class="flex items-center p-3 rounded-lg transition-all duration-300 
                           {{ Route::is('admin.viewAllTasks') ? 'bg-blue-500 text-white' : 'text-gray-700 hover:bg-blue-100' }}">
                            <i class="fa-solid fa-tasks mr-3"></i>
                            <span x-show="isOpen" class="transition-all duration-300">View All Tasks</span>
                        </a>
                    </li>

                    <!-- Admin Activities -->
                    <li>
                        <a href="{{ route('admin.viewAllActivities') }}" 
                           class="flex items-center p-3 rounded-lg transition-all duration-300 
                           {{ Route::is('admin.viewAllActivities') ? 'bg-blue-500 text-white' : 'text-gray-700 hover:bg-blue-100' }}">
                            <i class="fa-solid fa-list mr-3"></i>
                            <span x-show="isOpen" class="transition-all duration-300">View Activities</span>
                        </a>
                    </li>

                    <!-- Admin Assign Task -->
                    <li>
                        <a href="{{ route('admin.assign-task') }}" 
                           class="flex items-center p-3 rounded-lg transition-all duration-300 
                           {{ Route::is('admin.assign-task') ? 'bg-blue-500 text-white' : 'text-gray-700 hover:bg-blue-100' }}">
                            <i class="fa-solid fa-plus-circle mr-3"></i>
                            <span x-show="isOpen" class="transition-all duration-300">Assign Task</span>
                        </a>
                    </li>
                @endcan
            </ul>
        </div>
    </div>

    <!-- Main Content -->
    <div class="flex-1 p-8 bg-gray-100 overflow-auto">
        <div class="space-y-8">
            <!-- Metrics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Pending Tasks -->
                <div class="bg-white p-6 shadow-md rounded-lg flex items-center">
                    <div class="mr-4 text-blue-500">
                        <i class="fa-solid fa-clock fa-2x"></i>
                    </div>
                    <div>
                        <h4 class="text-lg font-semibold text-gray-800">Pending Tasks</h4>
                        <p class="text-gray-600">{{ $pendingTasksCount }}</p>
                    </div>
                </div>

                <!-- Received Tasks -->
                <div class="bg-white p-6 shadow-md rounded-lg flex items-center">
                    <div class="mr-4 text-green-500">
                        <i class="fa-solid fa-check-circle fa-2x"></i>
                    </div>
                    <div>
                        <h4 class="text-lg font-semibold text-gray-800">Received Tasks</h4>
                        <p class="text-gray-600">{{ $receivedTasksCount }}</p>
                    </div>
                </div>

                <!-- Overdue Tasks -->
                <div class="bg-white p-6 shadow-md rounded-lg flex items-center">
                    <div class="mr-4 text-red-500">
                        <i class="fa-solid fa-exclamation-circle fa-2x"></i>
                    </div>
                    <div>
                        <h4 class="text-lg font-semibold text-gray-800">Overdue Tasks</h4>
                        <p class="text-gray-600">{{ $overdueTasksCount }}</p>
                    </div>
                </div>

                <!-- Upcoming Deadlines -->
                <div class="bg-white p-6 shadow-md rounded-lg flex items-center">
                    <div class="mr-4 text-yellow-500">
                        <i class="fa-solid fa-calendar-day fa-2x"></i>
                    </div>
                    <div>
                        <h4 class="text-lg font-semibold text-gray-800">Upcoming Deadlines</h4>
                        <p class="text-gray-600">{{ $upcomingDeadlinesCount }}</p>
                    </div>
                </div>
            </div>

            <!-- Upcoming Deadlines Section -->
            <div class="bg-white p-6 shadow-md rounded-lg">
                <h3 class="font-bold text-lg mb-4 flex items-center text-gray-700">
                    <i class="fa-solid fa-calendar-check mr-3 text-green-500"></i> Upcoming Deadlines
                </h3>
                <ul class="space-y-4">
                    @forelse ($tasksWithDeadlines as $task)
                        <li class="flex items-center justify-between bg-gray-100 p-4 rounded-lg shadow-sm">
                            <div>
                                <h4 class="font-semibold text-gray-800">{{ $task->title }}</h4>
                                <p class="text-sm text-gray-600">
                                    <i class="fa-solid fa-clock text-blue-500 mr-1"></i>
                                    Due: <span class="font-semibold">{{ $task->due_date->format('d M, Y - h:i A') }}</span>
                                </p>
                            </div>
                            <span class="px-3 py-1 text-sm font-medium text-white bg-blue-500 rounded-full">
                                {{ $task->status }}
                            </span>
                        </li>
                    @empty
                        <li class="text-gray-500">No upcoming deadlines!</li>
                    @endforelse
                </ul>
            </div>

            <!-- Activity History -->
            <div class="bg-white p-6 shadow-md rounded-lg">
                <h3 class="font-bold text-lg mb-4 flex items-center text-gray-700">
                    <i class="fa-solid fa-history mr-3"></i> Activity History
                </h3>
                <ul class="space-y-2 text-gray-600">
                    @forelse ($recentActivities as $activity)
                        <li>
                            <i class="fa-solid fa-clock text-blue-500 mr-2"></i>{{ $activity->title }}
                            <span class="text-gray-500">({{ $activity->created_at->diffForHumans() }})</span>
                        </li>
                    @empty
                        <li><i class="fa-solid fa-exclamation-circle text-red-500 mr-2"></i>No recent activities.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>

@endsection
