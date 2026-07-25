<footer class="mt-24" style="background-color:#1E3A4A;color:#EFE9DC;">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Top: oversized wordmark + tagline --}}
        <div class="py-14 border-b border-white/15 grid lg:grid-cols-[1.5fr_1fr] gap-10 items-end">
            <div>
                <span class="ed-kicker ed-kicker--light">Rwanda &middot; Eco-Lodge</span>
                <p class="font-display font-bold leading-none mt-4" style="font-size:clamp(2.75rem,7vw,5rem);color:#fff;">Rirenga</p>
                <p class="mt-5 text-sm leading-relaxed max-w-sm" style="color:rgba(239,233,220,0.7);">
                    A sustainable sanctuary in the hills of Rwanda — rooms, restaurant, bar, and unforgettable hiking, between the twin lakes of Ruhondo &amp; Burera.
                </p>
            </div>
            <div class="lg:text-right">
                <a href="{{ route('booking') }}" class="ed-btn ed-btn-outline-light">{{ __('nav.book_now') }}</a>
                <div class="mt-6 flex gap-5 lg:justify-end">
                    <a href="#" aria-label="Facebook" class="transition hover:text-white" style="color:rgba(239,233,220,0.6);">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>
                    </a>
                    <a href="#" aria-label="Instagram" class="transition hover:text-white" style="color:rgba(239,233,220,0.6);">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>
                    </a>
                </div>
            </div>
        </div>

        {{-- Middle: link + contact columns --}}
        <div class="py-12 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-10">
            <div>
                <h4 class="text-[0.68rem] font-semibold uppercase tracking-[0.2em] mb-5" style="color:rgba(239,233,220,0.45);">Explore</h4>
                <ul class="space-y-3 text-sm" style="color:rgba(239,233,220,0.75);">
                    <li><a href="{{ route('rooms') }}" class="hover:text-white transition">{{ __('nav.rooms') }}</a></li>
                    <li><a href="{{ route('restaurant') }}" class="hover:text-white transition">{{ __('nav.restaurant') }}</a></li>
                    <li><a href="{{ route('bar') }}" class="hover:text-white transition">{{ __('nav.bar') }}</a></li>
                    <li><a href="{{ route('gallery') }}" class="hover:text-white transition">{{ __('nav.gallery') }}</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-[0.68rem] font-semibold uppercase tracking-[0.2em] mb-5" style="color:rgba(239,233,220,0.45);">Company</h4>
                <ul class="space-y-3 text-sm" style="color:rgba(239,233,220,0.75);">
                    <li><a href="{{ route('about') }}" class="hover:text-white transition">{{ __('nav.about') }}</a></li>
                    <li><a href="{{ route('blog') }}" class="hover:text-white transition">{{ __('nav.blog') }}</a></li>
                    <li><a href="{{ route('careers') }}" class="hover:text-white transition">{{ __('nav.careers') }}</a></li>
                    <li><a href="{{ route('contact') }}" class="hover:text-white transition">{{ __('nav.contact') }}</a></li>
                </ul>
            </div>
            <div class="sm:col-span-2">
                <h4 class="text-[0.68rem] font-semibold uppercase tracking-[0.2em] mb-5" style="color:rgba(239,233,220,0.45);">Visit &amp; Contact</h4>
                <ul class="space-y-3 text-sm" style="color:rgba(239,233,220,0.75);">
                    <li>Kingdom of the Gorillas — between lakes Ruhondo &amp; Burera, Rwanda</li>
                    <li><a href="https://maps.app.goo.gl/tdT1uAKM9XU2Dh9S7" target="_blank" rel="noopener" class="hover:text-white underline underline-offset-2">View on Google Maps</a></li>
                    <li><a href="tel:+250787770750" class="hover:text-white">+250 787 770 750</a> &middot; <a href="https://wa.me/250787770750" target="_blank" rel="noopener" class="hover:text-white">WhatsApp</a></li>
                    <li><a href="mailto:izubatreat@gmail.com" class="hover:text-white">izubatreat@gmail.com</a></li>
                </ul>
            </div>
        </div>

        {{-- Bottom bar --}}
        <div class="py-6 border-t border-white/15 flex flex-col sm:flex-row justify-between items-center text-[0.7rem] tracking-wide" style="color:rgba(239,233,220,0.4);">
            <span>&copy; {{ date('Y') }} Rirenga. All rights reserved.</span>
            <div class="mt-2 sm:mt-0 flex gap-4">
                <a href="{{ route('locale.set', 'en') }}" class="hover:text-white transition">EN</a>
                <a href="{{ route('locale.set', 'fr') }}" class="hover:text-white transition">FR</a>
            </div>
        </div>
    </div>
</footer>
