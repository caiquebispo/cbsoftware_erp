<form class="space-y-6 form-create-new-rule">

    <x-ui.select :options="$channels" option-value="GMP015_Id" option-label="GMP015_Canal"/>

    <!-- Seção Comissão -->
    <x-ui.input name="comissao" id="comissao" containerClass="space-y-3" label="Comissão" icon="fas fa-hand-holding-usd" type="number" suffix="%" />

    <!-- Seção Custo Sac -->
    <x-ui.input containerClass="space-y-3" label="Custo Sac" icon="fas fa-headset" type="number" suffix="%" />

    <!-- Checkbox Comissão Sobre Frete -->
    <x-ui.checkbox name="comissaoFrete" id="comissaoFrete" label="Comissão Sobre Frete" icon="fas fa-truck" />

    <!-- Checkbox Multiplicar pela Quantidade -->
    <x-ui.checkbox name="multiplicarQt" id="multiplicarQt" label="Multiplicar Pela Quantidade de Itens" icon="fas fa-times-circle" />

    <!-- Botões de ação -->
    <div class="flex justify-end space-x-4 pt-4">
        <x-ui.button text="Salvar" icon="fas fa-save" color="blue" variant="gradient" type="submit" />
    </div>
</form>
