<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UserRegisterUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name'          => 'bail|required|string|max:225|min:1',
            'email'         => 'bail|required|string|max:225|min:1|unique:user_register,email',
            'cpf'           => 'bail|required|string|max:14|min:1|unique:user_register,cpf|regex:/^\d{3}\.\d{3}\.\d{3}\-\d{2}$/',
            'address'       => 'bail|required|string|max:225|min:1',
            'cell_phone'    => 'bail|required|string|max:14|min:12|unique:users,cell_phone',
            'cep'           => 'bail|required|string|max:9|min:8',
            'date_birth'    => 'bail|required|date_format:Y-m-d',
        ];  
    }

    public function messages()
    {
        return [
            'name.required'             => 'O campo nome é obrigatório.',
            'name.max'                  => 'O campo nome não pode ter mais de 225 caracteres.',
            'name.min'                  => 'O campo nome deve ter pelo menos 1 caractere.',
            'email.required'            => 'O campo email é obrigatório.',
            'email.unique'              => 'Este email já está sendo utilizado.',
            'cpf.regex'                 => 'O CPF deve estar no formato xxx.xxx.xxx-xx.',
            'address.required'          => 'O campo endereço é obrigatório.',
            'address.max'               => 'O campo endereço não pode ter mais de 225 caracteres.',
            'address.min'               => 'O campo endereço deve ter pelo menos 1 caractere.',
            'cell_phone.required'       => 'O campo celular é obrigatório.',
            'cell_phone.unique'         => 'Este celular já está sendo utilizado.',
            'cell_phone.max'            => 'O campo celular não pode ter mais de 14 caracteres.',
            'cell_phone.min'            => 'O campo celular deve ter pelo menos 12 caracteres.',
            'cep.required'              => 'O campo CEP é obrigatório.',
            'cep.max'                   => 'O campo CEP não pode ter mais de 9 caracteres.',
            'cep.min'                   => 'O campo CEP deve ter pelo menos 8 caracteres.',
            'date_birth.required'       => 'O campo data de nascimento é obrigatório.',
            'date_birth.date_format'    => 'O campo data de nascimento deve estar no formato Y-m-d.',
        ];
    }

}
