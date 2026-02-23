@extends('layouts.app')

@section('title', 'Guest Book')

@section('content')

    <h1 class="text-3xl font-bold text-gray-900 mb-2">Guest Book</h1>
    <p class="text-gray-500 mb-8">Leave a message for everyone to see!</p>

    {{-- ===== FLASH MESSAGE ===== --}}
    @if (session('success'))
        <div class="bg-green-100 border border-green-300 text-green-800 rounded-xl px-5 py-4 mb-6">
            {{ session('success') }}
        </div>
    @endif

    {{-- ===== FORM ===== --}}
    <div class="bg-white rounded-2xl shadow-sm border border-amber-100 p-6 mb-10">
        <h2 class="text-lg font-semibold mb-4">Sign the Guest Book</h2>

        <form action="{{ route('messages.store') }}" method="POST" class="space-y-4" unvalidate>
            @csrf
            {{-- Name --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                <input type="text" name="name" value="{{ old('name') }}" placeholder="Your name"
                    class="w-full border rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400
                                                       {{ $errors->has('name') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}">
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Email --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="you@example.com"
                    class="w-full border rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400
                                                       {{ $errors->has('email') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}">
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Message --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Message</label>
                <textarea name="message" rows="4" placeholder="Write something nice..."
                    class="w-full border rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400
                                                       {{ $errors->has('message') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}">{{ old('message') }}</textarea>
                @error('message')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit"
                class="bg-amber-500 hover:bg-amber-600 text-white font-semibold px-6 py-2 rounded-lg transition">
                Post Message
            </button>
        </form>
    </div>

    {{-- ===== MESSAGES LIST ===== --}}
    <h2 class="text-lg font-semibold mb-4 text-gray-700">
        {{ $messages->count() }} {{ Str::plural('message', $messages->count()) }}
    </h2>

    @forelse ($messages as $message)
        <div class="bg-white rounded-2xl border border-amber-100 shadow-sm p-5 mb-4">
            <div class="flex items-center justify-between mb-2">
                <span class="font-semibold text-gray-900">{{ $message->name }}</span>
                <span class="text-xs text-gray-400">{{ $message->created_at }}</span>
            </div>
            <p class="text-gray-600 text-sm leading-relaxed">{{ $message->message }}</p>
            <p class="text-xs text-gray-400 mt-2">{{ $message->email }}</p>
        </div>
    @empty
        <div class="text-center py-12 text-gray-400">
            <p class="text-4xl mb-3">📭</p>
            <p>No messages yet. Be the first to sign!</p>
        </div>
    @endforelse

@endsection