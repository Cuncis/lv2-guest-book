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
                <textarea id="message-textarea" name="message" rows="4" maxlength="500"
                    placeholder="Write something nice..."
                    class="w-full border rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400
                                                                                   {{ $errors->has('message') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}">{{ old('message') }}</textarea>
                <div class="flex items-center justify-between mt-1">
                    <p class="text-red-500 text-xs">@error('message'){{ $message }}@enderror</p>
                    <p id="message-counter" class="text-gray-400 text-xs">0 / 500</p>
                </div>
            </div>

            <button type="submit"
                class="bg-amber-500 hover:bg-amber-600 text-white font-semibold px-6 py-2 rounded-lg transition">
                Post Message
            </button>
        </form>
    </div>

    {{-- ===== MESSAGES LIST ===== --}}
    <h2 class="text-lg font-semibold mb-4 text-gray-700">
        {{ $messages->total() }} {{ Str::plural('message', $messages->total()) }}
    </h2>

    @forelse ($messages as $message)
        <div class="bg-white rounded-2xl border border-amber-100 shadow-sm p-5 mb-4">

            <!-- Header -->
            <div class="flex justify-between items-start">
                <div>
                    <h3 class="font-semibold text-gray-900">
                        {{ $message->name }}
                    </h3>
                    <p class="text-xs text-gray-400">
                        {{ $message->email }}
                    </p>
                </div>
            </div>

            <!-- Message Body -->
            <div class="mt-3">
                <p class="text-gray-600 text-sm leading-relaxed">
                    {{ $message->message }}
                </p>
            </div>

            <!-- Footer -->
            <div class="flex justify-between items-center mt-4 pt-3 border-t border-amber-100">
                <span class="text-xs text-gray-400">
                    {{ $message->created_at }}
                </span>

                <form action="{{ route('messages.destroy', $message) }}" method="POST"
                    onsubmit="return confirm('Delete this message?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-500 text-xs font-medium hover:text-red-600 transition">
                        Delete
                    </button>
                </form>
            </div>

        </div>
    @empty
        <div class="text-center py-12 text-gray-400">
            <p class="text-4xl mb-3">📭</p>
            <p>No messages yet. Be the first to sign!</p>
        </div>
    @endforelse

    <div class="mt-6">
        {{ $messages->links() }}
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var textarea = document.getElementById('message-textarea');
            var counter = document.getElementById('message-counter');
            if (!textarea || !counter) return;

            var max = parseInt(textarea.getAttribute('maxlength')) || 500;
            function update() {
                var len = textarea.value.length;
                counter.textContent = len + ' / ' + max;
                if (len >= max) {
                    counter.classList.remove('text-gray-400');
                    counter.classList.add('text-red-500');
                } else {
                    counter.classList.remove('text-red-500');
                    counter.classList.add('text-gray-400');
                }
            }

            // initial
            update();
            textarea.addEventListener('input', update);
        });
    </script>

@endsection