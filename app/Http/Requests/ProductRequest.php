<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
						'name' => 'required',
						'ean13' => 'nullable',
						'quantity' => 'required',
						'reference' => 'nullable',
						'weight' => 'nullable',
						'price' => 'required',
						'categories' => 'nullable', // Array of ids
						'type' => 'required', // type simple or combination
						'description' => 'nullable',
						'description_short' => 'nullable',
						'active' => 'required'
        ];
    }

	/**
	 * Get the error messages for the defined validation rules.*
	 * @return array
	 */
	protected function failedValidation(Validator $validator)
	{
		throw new HttpResponseException(response()->json([
				'message' => $validator->errors()->first()
		], 422));
	}

}
