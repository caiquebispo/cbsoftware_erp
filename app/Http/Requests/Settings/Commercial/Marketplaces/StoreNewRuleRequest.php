<?php

namespace App\Http\Requests\Settings\Commercial\Marketplaces;

use Illuminate\Foundation\Http\FormRequest;

class StoreNewRuleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
    public function prepareForValidation()
    {
        $this->merge([
            'comissaoFrete'   => $this->has('comissaoFrete'),
            'multiplicarQt'   => $this->has('multiplicarQt'),
        ]);
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'canal'          => ['required', 'integer'],
            'comissao'       => ['nullable', 'numeric'],
            'custoSac'       => ['nullable', 'numeric'],
            'comissaoFrete'  => ['boolean'],
            'multiplicarQt'  => ['boolean'],
        ];
    }
    public function messages(): array
    {
        return [
            'canal.required' => 'O canal é um campo obrigatorio',
            'canal.integer' => 'O valor do canal do não pode ser uma string',
            'comissao.float' => 'A comssão precisa ser um númro do tipo float',
        ];
    }

}
