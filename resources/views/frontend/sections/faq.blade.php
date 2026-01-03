<div id="faq" class="bg-gray-50 py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-extrabold text-gray-900 text-center mb-12">
            Pertanyaan Umum (FAQ)
        </h2>
        
        <div class="space-y-4 max-w-3xl mx-auto">
            @forelse($faqs as $faq)
            <div x-data="{ open: false }" class="bg-white px-6 py-4 rounded-lg shadow-sm border border-gray-100">
                <button @click="open = !open" class="flex justify-between items-center w-full focus:outline-none">
                    <span class="text-lg font-medium text-gray-900 text-left">{{ $faq->question }}</span>
                    <span x-show="!open" class="text-gray-400"><i class="fas fa-plus"></i></span>
                    <span x-show="open" class="text-primary-custom"><i class="fas fa-minus"></i></span>
                </button>
                <div x-show="open" x-transition class="mt-4 text-gray-600 leading-relaxed border-t pt-4">
                    {!! nl2br(e($faq->answer)) !!}
                </div>
            </div>
             @empty
            <div class="text-center text-gray-500">Belum ada FAQ.</div>
            @endforelse
        </div>
    </div>
</div>
