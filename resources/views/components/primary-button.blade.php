<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-prussian-blue border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-metallic-seaweed focus:bg-metallic-seaweed active:bg-prussian-blue focus:outline-none focus:ring-2 focus:ring-prussian-blue focus:ring-offset-2 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
