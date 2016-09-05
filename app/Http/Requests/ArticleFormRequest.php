<?php

namespace App\Http\Requests;

use App\User;
use Auth;
use Illuminate\Foundation\Http\FormRequest;

class ArticleFormRequest extends FormRequest {
  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize()
  {    
    return $this->user()->permissions == 0;
  }
  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
      'title' => 'required|unique:posts|max:255',
      'title' => array('Regex:/^[A-Za-z0-9 ]+$/'),
      'body' => 'required',
    ];
  }    
}