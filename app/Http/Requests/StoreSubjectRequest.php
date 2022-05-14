<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSubjectRequest extends FormRequest
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
            'title'=>'string|required|min:3',
            'content'=>'string|required|min:25',
            'code'=>['string','required','regex:/^I{1}K{1}-[A-Z]{3}[0-9]{3}$/i'],
            'credit'=>'numeric|required'
        ];
    }
}
