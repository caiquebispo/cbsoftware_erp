@props([
    'id' => 'canal',
    'name' => 'canal',
    'label' => 'Canal',
    'icon' => 'fas fa-store',
    'options' => [],
    'selected' => null,
    'placeholder' => 'Selecione um canal',
    'disabledPlaceholder' => true,
    'containerClass' => 'space-y-2',
    'labelClass' => 'block text-sm font-medium text-gray-700 flex items-center',
    'iconClass' => 'mr-2 text-gray-500',
    'selectContainerClass' => 'relative',
    'selectClass' => 'appearance-none w-full pl-3 pr-10 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white cursor-pointer',
    'arrowClass' => 'pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700',
    'arrowIcon' => 'fas fa-chevron-down',
    'optionValue' => 'id', // Key for option value
    'optionLabel' => 'name', // Key for option label
])

<div class="{{ $containerClass }}">
    @if($label)
        <label for="{{ $id }}" class="{{ $labelClass }}">
            @if($icon)
                <i class="{{ $icon }} {{ $iconClass }}"></i>
            @endif
            {{ $label }}
        </label>
    @endif

    <div class="{{ $selectContainerClass }}">
        <select
            id="{{ $id }}"
            name="{{ $name }}"
            class="{{ $selectClass }}"
            {{ $attributes }}
        >
            @if($placeholder)
                <option value="" @if($disabledPlaceholder) disabled @endif @if(is_null($selected)) selected @endif>
                    {{ $placeholder }}
                </option>
            @endif

            @foreach($options as $option)
                @if(is_object($option))
                    <option
                        value="{{ $option->{$optionValue} }}"
                        @if(!is_null($selected) && $option->{$optionValue} == $selected) selected @endif
                    >
                        {{ $option->{$optionLabel} }}
                    </option>
                @else
                    <option
                        value="{{ $option[$optionValue] }}"
                        @if(!is_null($selected) && $option[$optionValue] == $selected) selected @endif
                    >
                        {{ $option[$optionLabel] }}
                    </option>
                @endif
            @endforeach
        </select>

        <div class="{{ $arrowClass }}">
            <i class="{{ $arrowIcon }}"></i>
        </div>
    </div>
</div>
