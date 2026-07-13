<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-5 py-2.5 bg-[#2E4636] border border-transparent rounded-xl font-semibold text-xs text-white uppercase tracking-widest hover:bg-[#243a2c] focus:bg-[#243a2c] active:bg-[#1c2e22] focus:outline-none focus:ring-2 focus:ring-[#6E8C5A] focus:ring-offset-2 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
