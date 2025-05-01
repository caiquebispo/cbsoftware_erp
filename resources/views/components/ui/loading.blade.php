<div
    x-data="{ show: false }"
    x-show="show"
    x-transition.opacity
    id="loading"
    class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm"
    style="display: none"
>
    <div class="w-16 h-16 border-4 border-white border-t-transparent rounded-full animate-spin"></div>
</div>
