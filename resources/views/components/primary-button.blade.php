<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-bri border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-bri-hover focus:bg-bri-hover active:bg-bri-hover focus:outline-none focus:ring-2 focus:ring-bri focus:ring-offset-2 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
