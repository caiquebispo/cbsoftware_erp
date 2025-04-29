<!-- Modal backdrop -->
<div id="modal-main" style="display: none" class="fixed inset-0 z-50  bg-black bg-opacity-50 flex items-center justify-center">
    <!-- Modal container (tamanhos: md, lg, xl) -->
    <div class="bg-white rounded-2xl shadow-lg p-6 w-full max-w-5xl modal-size transition-all duration-300">
        <!-- Modal header -->
        <div class="flex justify-between items-center border-b pb-3">
            <h3 class="text-xl font-semibold modal-title">Título do Modal</h3>
            <button type="button" class="text-gray-400 hover:text-gray-600" onclick="$('#modal-main').fadeOut();">
                &times;
            </button>
        </div>
        <!-- Modal body -->
        <div class="mt-4 modal-body">
            <p>Conteúdo do modal aqui...</p>
        </div>
        <!-- Modal footer -->
        <div class="mt-6 flex justify-end gap-2 hidden">
            <button onclick="$('#modal-main').fadeOut();" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-lg">Cancelar</button>
            <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">Confirmar</button>
        </div>
    </div>
</div>
