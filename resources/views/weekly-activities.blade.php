@extends('layouts.app')

@section('content')
<div class="flex flex-col lg:flex-row">
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
    <div class="flex-1 p-6 bg-white">
        <!-- Week Range Section -->
        <div class="text-center mb-6">
            <h2 class="text-3xl lg:text-4xl font-extrabold text-black mb-2">Weekly Activities</h2>
            <div class="inline-block text-white rounded-lg px-6 py-2 mb-4">
                <h3 class="text-lg lg:text-xl font-semibold text-zinc-950">
                    Week of
                    <span class="text-blue-300">
                        {{ $currentWeekStart->format('d M, Y') }} - {{ $currentWeekEnd->format('d M, Y') }}
                    </span>
                </h3>
            </div>
            <div class="flex justify-between items-center mt-4 flex-col sm:flex-row">
                <a href="{{ route('weekly.activities', ['week' => $currentWeekStart->subWeek()->format('Y-m-d')]) }}" 
                   class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 mb-2 sm:mb-0">
                    <i class="fa-solid fa-chevron-left mr-2"></i> Previous Week
                </a>
                <a href="{{ route('weekly.activities', ['week' => $currentWeekStart->addWeek()->format('Y-m-d')]) }}" 
                   class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
                    Next Week <i class="fa-solid fa-chevron-right ml-2"></i>
                </a>
            </div>
        </div>

        <!-- Filters -->
        <div class="flex flex-col sm:flex-row justify-between items-center bg-white p-4 rounded-lg shadow mb-6">
            <div class="mb-4 sm:mb-0">
                <label for="status-filter" class="text-gray-700 font-semibold">Filter by Status:</label>
                <select id="status-filter" class="rounded-lg border-gray-300 shadow-sm mt-2 sm:mt-0">
                    <option value="all">All</option>
                    <option value="pending">Pending</option>
                    <option value="completed">Completed</option>
                </select>
            </div>
            <a href="{{ route('activities.create') }}" class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600">
                <i class="fa-solid fa-plus mr-2"></i> Add Activity
            </a>
        </div>

        <!-- Weekly Activities Table -->
        <div class="overflow-x-auto bg-white shadow-lg rounded-lg">
            <table class="min-w-full table-auto border-collapse">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Time</th>
                        @foreach ($daysOfWeek as $day)
                            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">{{ $day }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @foreach ($timeSlots as $slot => $range)
                        <tr class="border-t hover:bg-gray-50">
                            <td class="px-4 py-2 font-semibold text-gray-700">{{ $slot }}</td>
                            @foreach ($daysOfWeek as $day)
                                <td class="px-4 py-2 text-gray-600">
                                    @if ($structuredActivities[$day][$slot] !== 'No Activity')
                                        <div class="bg-blue-100 text-blue-600 px-3 py-1 rounded-lg text-center">
                                            {{ $structuredActivities[$day][$slot] }}
                                        </div>
                                    @else
                                        <span class="text-gray-500">No Activity</span>
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
