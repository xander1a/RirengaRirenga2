@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'w-full px-4 py-3 text-base border border-gray-300 bg-white focus:border-[#3F7C8A] focus:ring-[#3F7C8A] rounded-xl shadow-sm']) }}>
