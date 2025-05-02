<!-- Modal backdrop -->
<div id="modal-main" style="display: none"
     class="fixed inset-0 z-50 bg-black/50 dark:bg-black/70 flex items-center justify-center p-4 transition-opacity duration-300">

    <!-- Modal container -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl dark:shadow-2xl dark:shadow-gray-900/50 w-full max-w-5xl transition-all duration-300 transform">
        <!-- Modal header -->
        <div class="flex justify-between items-center border-b dark:border-gray-700 p-6 pb-4">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white modal-title">Título do Modal</h3>
            <button type="button"
                    class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors text-2xl font-light"
                    onclick="$('#modal-main').fadeOut();"
                    aria-label="Fechar modal">
                &times;
            </button>
        </div>

        <!-- Modal body -->
        <div class="p-6 pt-4 modal-body text-gray-700 dark:text-gray-300">
            <p>Conteúdo do modal aqui...</p>
        </div>

        <!-- Modal footer (opcional) -->
        <div class="p-6 pt-4 border-t dark:border-gray-700 flex justify-end gap-3 hidden modal-footer">
            <button onclick="$('#modal-main').fadeOut();"
                    class="px-5 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                Cancelar
            </button>
            <button class="px-5 py-2.5 rounded-lg bg-blue-600 hover:bg-blue-700 text-white transition-colors">
                Confirmar
            </button>
        </div>
    </div>
</div>

<script>
    // Função para mostrar o modal com animação
    function showModal(title, content, size = 'md', showFooter = false) {
        const modal = $('#modal-main');
        modal.find('.modal-title').text(title);
        modal.find('.modal-body').html(content);

        // Ajustar tamanho
        const sizes = {
            'sm': 'max-w-md',
            'md': 'max-w-xl',
            'lg': 'max-w-3xl',
            'xl': 'max-w-5xl',
            'full': 'max-w-full'
        };
        modal.find('.modal-size').removeClass(Object.values(sizes).addClass(sizes[size] || sizes['md']);

        // Mostrar/ocultar footer
        modal.find('.modal-footer').toggleClass('hidden', !showFooter);

        // Animação de entrada
        modal.fadeIn();
    }

    // Função para fechar o modal
    function closeModal() {
        $('#modal-main').fadeOut();
    }
</script>
