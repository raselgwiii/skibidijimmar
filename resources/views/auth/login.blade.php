@extends('layouts.auth')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-emerald-400 to-cyan-500 relative overflow-hidden py-12 px-4 sm:px-6 lg:px-8">
    <!-- Geometric shapes -->
    <div class="absolute inset-0" style="z-index: 0;">
        <!-- Large circle -->
        <div class="absolute -right-20 -top-20 w-96 h-96 rounded-full bg-white opacity-10 mix-blend-overlay"></div>
        <!-- Small circles -->
        <div class="absolute left-10 bottom-10 w-32 h-32 rounded-full bg-white opacity-10 mix-blend-overlay"></div>
        <div class="absolute right-1/4 top-1/3 w-24 h-24 rounded-full bg-white opacity-10 mix-blend-overlay"></div>
        <!-- Square -->
        <div class="absolute left-1/3 top-1/4 w-48 h-48 rotate-12 bg-white opacity-10 mix-blend-overlay"></div>
        <!-- Triangle using SVG -->
        <svg class="absolute left-1/4 bottom-1/4 w-32 h-32 opacity-10" viewBox="0 0 100 100">
            <polygon points="50,0 100,100 0,100" fill="white"/>
        </svg>
    </div>

    <div class="max-w-md w-full space-y-8 bg-white p-8 rounded-xl shadow-lg relative z-10">
        @if (session('success'))
            <div class="rounded-md bg-green-100 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-500" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-green-800">
                            {{ session('success') }}
                        </p>
                    </div>
                </div>
            </div>
        @endif
        <div class="flex justify-center">
            <svg class="h-12 w-12 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12H8m0 0l4-4m0 4l-4 4" />
            </svg>
        </div>
        <div>
            <h2 class="mt-6 text-center text-3xl font-bold text-gray-900">
                Sign in to Admin Panel
            </h2>
        </div>

        <form class="mt-8 space-y-6" action="{{ route('login') }}" method="POST">
            @csrf
            <div class="rounded-md shadow-sm -space-y-px">
                <div class="relative">
                    <label for="email" class="sr-only">Email address</label>
                    <input id="email" name="email" type="email" required class="appearance-none rounded-none relative block w-full px-3 py-2 pl-10 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-emerald-500 focus:border-emerald-500 focus:z-10 sm:text-sm" placeholder="Email address">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2.003 5.884l7.197 4.25a1 1 0 001.6-.8V5.884a1 1 0 00-1.6-.8L2.003 9.334a1 1 0 000 1.6z" />
                        </svg>
                    </div>
                </div>
                <div class="relative">
                    <label for="password" class="sr-only">Password</label>
                    <input id="password" name="password" type="password" required class="appearance-none rounded-none relative block w-full px-3 py-2 pl-10 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-emerald-500 focus:border-emerald-500 focus:z-10 sm:text-sm" placeholder="Password">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v14a1 1 0 01-1 1H4a1 1 0 01-1-1V3zm10 7H7a1 1 0 000 2h6a1 1 0 000-2z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
            </div>

            @if ($errors->any())
                <div class="text-red-600">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <div>
                <button type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-emerald-500 hover:bg-emerald-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                    <svg class="h-5 w-5 text-emerald-300 group-hover:text-emerald-400" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 00-2 0v3H6a1 1 0 100 2h3v3a1 1 0 102 0v-3h3a1 1 0 100-2h-3V7z" clip-rule="evenodd" />
                    </svg>
                    <span class="ml-2">Sign in to Admin</span>
                </button>
            </div>

            <div class="text-sm text-center">
                <a href="{{ route('register') }}" class="font-medium text-emerald-600 hover:text-emerald-500">
                    Need an admin account? Register
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
