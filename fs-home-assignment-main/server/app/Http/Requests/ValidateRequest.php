<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Auth\Access\AuthorizationException;

class ValidateRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check();
    }

    public function rules()
    {
        return [
            'questions' => 'required|array',
            'questions.*.question' => 'required|string',
            'questions.*.type' => 'required|in:text,multiple,textarea',
            'questions.*.options' => 'nullable|array',
            'questions.*.multipleChoice' => 'required|boolean',
            'questions.*.answer' => 'required', 
            'questions.*.subQuestions' => 'nullable|array', 
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param \Illuminate\Contracts\Validation\Validator $validator
     * @return void
     *
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     */
    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();

        throw new HttpResponseException(response()->json([
            'message' => 'Validation failed',
            'errors' => $errors
        ], 422));
    }
    protected function failedAuthorization()
    {
        throw new HttpResponseException(response()->json([
            'message' => 'Authorization failed',
            'errors' => ['auth' => ['You are not authorized to perform this action.']],
        ], 403));
    }
}
