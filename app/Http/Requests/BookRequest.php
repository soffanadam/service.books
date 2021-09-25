<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookRequest extends FormRequest
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
            'title' => 'required|max:255',
            'year' => 'required|date_format:Y',
            'description' => ''
        ];
    }

    /**
     * For the docs
     *
     * @return array
     */
    public function bodyParameters()
    {
        return [
            'title' => [
                'description' => 'The title of the book.',
                'example' => 'How to OOBE',
            ],
            'year' => [
                'description' => 'When the book was published.',
                'example' => '2000',
            ],
            'description' => [
                'description' => 'What is the book about.',
                'example' => 'Get your first OOBE with this book',
            ],
        ];
    }
}
