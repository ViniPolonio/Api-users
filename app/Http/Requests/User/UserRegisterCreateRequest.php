<?php

namespace App\Http\Requests\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UserRegisterCreateRequest extends FormRequest
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
            'email'         => 'bail|required|string|email|max:225|min:1|unique:user_register',
            'cpf'           => 'bail|required|string|max:14|min:11|regex:/^\d{3}\.\d{3}\.\d{3}-\d{2}$/',
            'address'       => 'bail|required|string|max:225|min:1',
            'cellphone'     => 'bail|required|string|max:14|min:12|unique:user_register',
            'cep'           => 'bail|required|string|max:9|min:8',
            'date_birth'    => 'bail|required|date_format:Y-m-d',
            'password'      => [
                'bail',
                'required',
                'confirmed',
                'max:35',
                'min:6',
                Password::min(8)
                        ->letters()
                        ->mixedCase()
                        ->numbers()
                        ->symbols()
                        ->uncompromised()
            ],
            'password_confirmation' => 'bail|required|same:password',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, mixed>
     */
    public function messages()
    {
        return [
            'name.required'                         => 'O campo nome é obrigatório.',
            'name.max'                              => 'O campo nome não pode ter mais de 225 caracteres.',
            'name.min'                              => 'O campo nome deve ter pelo menos 1 caractere.',
            'email.required'                        => 'O campo email é obrigatório.',
            'email.unique'                          => 'Este email já está sendo utilizado.',
            'cpf.regex'                             => 'O CPF deve estar no formato xxx.xxx.xxx-xx.',
            'address.required'                      => 'O campo endereço é obrigatório.',
            'address.max'                           => 'O campo endereço não pode ter mais de 225 caracteres.',
            'address.min'                           => 'O campo endereço deve ter pelo menos 1 caractere.',
            'cellphone.required'                    => 'O campo celular é obrigatório.',
            'cellphone.unique'                      => 'Este celular já está sendo utilizado.',
            'cellphone.max'                         => 'O campo celular não pode ter mais de 14 caracteres.',
            'cellphone.min'                         => 'O campo celular deve ter pelo menos 12 caracteres.',
            'cep.required'                          => 'O campo CEP é obrigatório.',
            'cep.max'                               => 'O campo CEP não pode ter mais de 9 caracteres.',
            'cep.min'                               => 'O campo CEP deve ter pelo menos 8 caracteres.',
            'date_birth.required'                   => 'O campo data de nascimento é obrigatório.',
            'date_birth.date_format'                => 'O campo data de nascimento deve estar no formato Y-m-d.',
            'password.required'                     => 'O campo Senha é obrigatório',
            'password.symbols'                      => 'O campo Senha necessita de pelo menos 1 símbolo.',
            'password.numbers'                      => 'O campo Senha necessita de pelo menos 1 número.',
            'password.letters'                      => 'O campo Senha necessita de pelo menos 1 letra.',
            'password.mixedCase'                    => 'O campo Senha necessita de letras maiúsculas e minúsculas.',
            'password.min'                          => 'O campo Senha deve ter pelo menos :min caracteres.',
            'password.max'                          => 'O campo Senha não pode ter mais de :max caracteres.',
            'password.confirmed'                    => 'As senhas não coincidem.',
            'password_confirmation.required'        => 'O campo Confirmação de Senha é obrigatório.',
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'cpf' => str_replace(['.', '-'], '', $this->cpf),
        ]);
    }
}
