<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreServerRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'name'          =>  'string|required',
            'ip'            =>  'ip|required',
            'game_type'     =>  'string',
            'map'           =>  'string',
            'player_limit'  =>  'integer',
            'MNP'           =>  'string'
        ];
    }
}
