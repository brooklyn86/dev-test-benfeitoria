<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|unique:categories|max:50',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'O campo Nome da categoria é um campo obrigatório',
            'title.max' => 'O tamanho máximo da categoria é de até 50 caracteres',
            'title.unique' => 'Já existe uma categoria com esse mesmo nome'
        ];
    }
}
