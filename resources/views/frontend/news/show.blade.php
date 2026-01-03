@extends('frontend.layouts.app')

@section('content')
<div class="bg-gray-50 py-16">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <!-- Image -->
            @if($post->image && Storage::disk('public')->exists($post->image))
                <img class="w-full h-96 object-cover" src="{{ asset('storage/'.$post->image) }}" alt="{{ $post->title }}">
            @endif

            <div class="p-8">
                <!-- Meta -->
                <div class="flex items-center text-sm text-gray-500 mb-4">
                    <span class="flex items-center">
                        <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        {{ $post->created_at->format('d M Y') }}
                    </span>
                    <span class="mx-2">•</span>
                    <span class="flex items-center">
                        <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        {{ $post->author->name ?? 'Admin' }}
                    </span>
                </div>

                <!-- Title -->
                <h1 class="text-3xl font-extrabold text-gray-900 mb-6">{{ $post->title }}</h1>

                <!-- Content -->
                <div class="prose prose-lg max-w-none text-gray-700">
                    <!-- If content is just text, use nl2br. If HTML (summernote), use plain output -->
                    {!! nl2br(e($post->content)) !!}
                </div>
            </div>
            
            <div class="bg-gray-100 px-8 py-4 border-t border-gray-200">
                <a href="{{ route('home') }}" class="text-primary-custom font-medium hover:text-indigo-900 flex items-center">
                    <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
