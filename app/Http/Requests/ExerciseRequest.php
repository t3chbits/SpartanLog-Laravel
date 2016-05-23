<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use \Dingo\Api\Http\FormRequest;

class ExerciseRequest extends FormRequest
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
            'name' => 'bail|sometimes|required|between:3,255|alpha_dash',
            'bodyRegion' => 'required|in:Chest,Back,Legs,Shoulders,Biceps,Triceps,Neck,Forearms,FullBody'
        ];
    }
}
