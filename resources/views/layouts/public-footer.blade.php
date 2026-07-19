<footer class="mt-16" style="background-color:#2E4636;color:#F1E9D7;">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">

            {{-- Brand --}}
            <div class="md:col-span-2">
                <span class="font-display text-2xl font-bold text-white">BYIZA Eco-lodge</span>
                <p class="mt-3 text-sm text-white/70 leading-relaxed max-w-xs">
                    A sustainable sanctuary in the hills of Rwanda. Rooms, restaurant, bar and unforgettable hiking experiences.
                </p>
                <div class="mt-4 flex gap-4">
                    <a href="#" aria-label="Facebook" class="text-white/60 hover:text-white transition">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>
                    </a>
                    <a href="#" aria-label="Instagram" class="text-white/60 hover:text-white transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>
                    </a>
                </div>
            </div>

            {{-- Quick Links --}}
            <div>
                <h4 class="text-sm font-semibold uppercase tracking-wider text-white/50 mb-4">Quick Links</h4>
                <ul class="space-y-2 text-sm text-white/70">
                    <li><a href="{{ route('rooms') }}" class="hover:text-white transition">{{ __('nav.rooms') }}</a></li>
                    <li><a href="{{ route('restaurant') }}" class="hover:text-white transition">{{ __('nav.restaurant') }}</a></li>
                    <li><a href="{{ route('bar') }}" class="hover:text-white transition">{{ __('nav.bar') }}</a></li>
                    <li><a href="{{ route('gallery') }}" class="hover:text-white transition">{{ __('nav.gallery') }}</a></li>
                    <li><a href="{{ route('blog') }}" class="hover:text-white transition">{{ __('nav.blog') }}</a></li>
                    <li><a href="{{ route('careers') }}" class="hover:text-white transition">{{ __('nav.careers') }}</a></li>
                </ul>
            </div>

            {{-- Contact --}}
            <div>
                <h4 class="text-sm font-semibold uppercase tracking-wider text-white/50 mb-4">Contact</h4>
                <ul class="space-y-2 text-sm text-white/70">
                    <li>📍 Rwanda (exact address — TODO)</li>
                    <li>📞 <a href="tel:+250787770750" class="hover:text-white">0787 770 750</a></li>
                    <li>💬 <a href="https://wa.me/250787770750" target="_blank" rel="noopener" class="hover:text-white">WhatsApp: +250 787 770 750</a></li>
                    <li>✉️ <a href="mailto:izubatreat@gmail.com" class="hover:text-white">izubatreat@gmail.com</a></li>
                </ul>
                <a href="{{ route('booking') }}"
                   class="mt-6 inline-block px-5 py-2 rounded-xl text-white text-sm font-semibold transition hover:opacity-90"
                   style="background-color:#BF6B47;">{{ __('nav.book_now') }}</a>
            </div>
        </div>

        <div class="mt-10 pt-6 border-t border-white/20 flex flex-col sm:flex-row justify-between items-center text-xs text-white/40">
            <span>&copy; {{ date('Y') }} BYIZA Eco-lodge. All rights reserved.</span>
            <div class="mt-2 sm:mt-0 flex gap-4">
                <a href="{{ route('locale.set', 'en') }}" class="hover:text-white/70">EN</a>
                <a href="{{ route('locale.set', 'fr') }}" class="hover:text-white/70">FR</a>
            </div>
        </div>
    </div>
</footer>
