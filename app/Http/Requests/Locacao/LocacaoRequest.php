<?php

namespace App\Http\Requests\Locacao;

use Illuminate\Foundation\Http\FormRequest;

class LocacaoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'cliente_id' => 'exists:clientes,id',
            'carro_id' => 'exists:carros,id',
            'data_inicio_periodo' => 'required',
            'data_final_previsto_periodo' => 'required',
            'valor_diaria' => 'required',
            'km_inicial' => 'required'
        ];
    }
}
