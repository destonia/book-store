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
            'name' => ['required', \Illuminate\Validation\Rule::unique('books')->ignore($this->id)],
            'avatar' => 'image|nullable',
            'author_id' => 'required',
            'category_id' => 'required',
            'publish_date' => 'required',
            'republish_no' => 'required',
            'isbn_no' => 'required',
            'license_no' => 'required',
            'price' => 'required',
            'desc' => 'required',
            'qty' => 'required',
            'publisher' => 'required',
            'lang' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'This field is required!',
            'author_id.required' => 'This field is required!',
            'category_id.required' => 'This field is required!',
            'publish_date.required' => 'This field is required!',
            'republish_no.required' => 'This field is required!',
            'isbn_no.required' => 'This field is required!',
            'license_no.required' => 'This field is required!',
            'price.required' => 'This field is required!',
            'desc.required' => 'This field is required!',
            'qty.required' => 'This field is required!',
            'publisher.required' => 'This field is required!',
            'language.required' => 'This field is required!',
        ];
    }
}
