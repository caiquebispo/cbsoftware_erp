<form class="space-y-6">
    <!-- Campo Canal (Select Moderno) -->
    <div class="space-y-2">
        <label for="canal" class="block text-sm font-medium text-gray-700 flex items-center">
            <i class="fas fa-store mr-2 text-gray-500"></i>
            Canal
        </label>
        <div class="relative">
            <select id="canal" name="canal"
                    class="appearance-none w-full pl-3 pr-10 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white cursor-pointer">
                <option value="" disabled selected>Selecione um canal</option>
                <option value="loja-fisica">Loja Física</option>
                <option value="ecommerce">E-commerce</option>
                <option value="marketplace">Marketplace</option>
                <option value="whatsapp">WhatsApp</option>
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                <i class="fas fa-chevron-down"></i>
            </div>
        </div>
    </div>

    <!-- Seção Comissão -->
    <div class="space-y-2">
        <label for="comissao" class="block text-sm font-medium text-gray-700 flex items-center">
            <i class="fas fa-hand-holding-usd mr-2 text-gray-500"></i>
            Comissão
        </label>
        <div class="relative rounded-md shadow-sm">
            <input type="text" id="comissao" name="comissao" placeholder="0,00"
                   class="block w-full pl-3 pr-12 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                <span class="text-gray-500 sm:text-sm">%</span>
            </div>
        </div>
    </div>

    <!-- Seção Custo Sac -->
    <div class="space-y-2">
        <label for="custoSac" class="block text-sm font-medium text-gray-700 flex items-center">
            <i class="fas fa-headset mr-2 text-gray-500"></i>
            Custo Sac
        </label>
        <div class="relative rounded-md shadow-sm">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <span class="text-gray-500 sm:text-sm">R$</span>
            </div>
            <input type="text" id="custoSac" name="custoSac" placeholder="0,00"
                   class="block w-full pl-10 pr-12 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
        </div>
    </div>

    <!-- Checkbox Comissão Sobre Frete -->
    <div class="flex items-center p-4 bg-gray-50 rounded-lg">
        <input id="comissaoFrete" name="comissaoFrete" type="checkbox"
               class="h-5 w-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
        <label for="comissaoFrete" class="ml-3 flex items-center">
            <i class="fas fa-truck mr-2 text-gray-600"></i>
            <span class="block text-sm font-medium text-gray-700">Comissão Sobre Frete</span>
        </label>
    </div>

    <!-- Checkbox Multiplicar pela Quantidade -->
    <div class="flex items-center p-4 bg-gray-50 rounded-lg">
        <input id="multiplicarQt" name="multiplicarQt" type="checkbox"
               class="h-5 w-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
        <label for="multiplicarQt" class="ml-3 flex items-center">
            <i class="fas fa-times-circle mr-2 text-gray-600"></i>
            <span class="block text-sm font-medium text-gray-700">Multiplicar Pela Quantidade de Itens</span>
        </label>
    </div>

    <!-- Botões de ação -->
    <div class="flex justify-end space-x-4 pt-4">
        <button type="submit" class="px-5 py-2.5 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
            <i class="fas fa-save mr-2"></i>
            Salvar Configurações
        </button>
    </div>
</form>
