@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-gray-200 bg-gray-50 focus:bg-white focus:border-[#466967] focus:ring-2 focus:ring-[#466967] rounded-xl shadow-xs text-xs sm:text-sm text-gray-900 transition px-3.5 py-2.5 min-h-[44px]']) }}>
