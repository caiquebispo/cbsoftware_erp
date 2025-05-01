<div
    x-data="{
        darkMode: localStorage.getItem('darkMode') === 'true',
        toggle() {
            this.darkMode = !this.darkMode;
            localStorage.setItem('darkMode', this.darkMode);
            document.documentElement.classList.toggle('dark', this.darkMode);
        }
    }"
    x-init="() => {
        // Verifica preferência do sistema se não houver configuração salva
        if (!('darkMode' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches) {
            localStorage.setItem('darkMode', 'true');
        }
        document.documentElement.classList.toggle('dark', darkMode);
    }"
>
    <button
        @click="toggle"
        type="button"
        class="relative w-24 h-10 rounded-full p-1 transition-all duration-500 ease-in-out"
        :class="{
            'bg-gradient-to-r from-indigo-500 to-purple-600': darkMode,
            'bg-gradient-to-r from-yellow-300 to-orange-400': !darkMode
        }"
        aria-label="Alternar modo escuro/claro"
    >
        <div class="absolute inset-0 flex items-center justify-between px-3">
            <i class="fas fa-sun text-white text-sm"></i>
            <i class="fas fa-moon text-white text-sm"></i>
        </div>

        <div
            class="relative h-8 w-8 rounded-full bg-white shadow-lg transform transition-all duration-500 ease-in-out"
            :class="{
                'translate-x-14': darkMode,
                'translate-x-0': !darkMode
            }"
        >
            <div
                class="absolute inset-0 flex items-center justify-center text-xs"
                :class="{
                    'text-purple-600': darkMode,
                    'text-orange-400': !darkMode
                }"
            >
                <template x-if="darkMode">
                    <i class="fas fa-moon"></i>
                </template>
                <template x-if="!darkMode">
                    <i class="fas fa-sun"></i>
                </template>
            </div>
        </div>
    </button>
</div>
