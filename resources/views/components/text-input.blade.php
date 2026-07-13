@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'w-full px-4 py-3 text-base border border-gray-300 bg-white focus:border-[#6E8C5A] focus:ring-[#6E8C5A] rounded-xl shadow-sm']) }}>
