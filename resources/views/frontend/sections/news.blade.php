<div id="berita" class="py-16 bg-white border-t border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
         <div class="text-center mb-10">
            <h2 class="text-3xl font-extrabold text-gray-900">Berita Terkini</h2>
            <p class="mt-2 text-gray-500">Informasi terbaru seputar sekolah dan PPDB.</p>
        </div>
        
        <div class="grid gap-8 lg:grid-cols-3">
             @forelse($featuredPosts as $post)
             <div class="flex flex-col rounded-lg shadow-md overflow-hidden hover:shadow-xl transition">
                <div class="flex-shrink-0">
                    <img class="h-48 w-full object-cover" src="{{ $post->image && Storage::disk('public')->exists($post->image) ? asset('storage/'.$post->image) : 'https://via.placeholder.com/400x200?text=No+Image' }}" alt="">
                </div>
                <div class="flex-1 bg-white p-6 flex flex-col justify-between">
                    <div class="flex-1">
                        <p class="text-sm font-medium text-primary-custom">
                            Berita
                        </p>
                        <a href="{{ route('news.show', $post->slug) }}" class="block mt-2">
                            <p class="text-xl font-semibold text-gray-900">{{ $post->title }}</p>
                            <p class="mt-3 text-base text-gray-500">{{ Str::limit($post->content, 100) }}</p>
                        </a>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('news.show', $post->slug) }}" class="text-primary-custom font-medium hover:text-indigo-900">
                            Baca Selengkapnya &rarr;
                        </a>
                    </div>
                </div>
             </div>
             @empty
             <div class="col-span-3 text-center text-gray-500">Belum ada berita.</div>
             @endforelse
        </div>
    </div>
</div>
