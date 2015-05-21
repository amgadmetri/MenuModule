<?php
namespace App\Modules\Menus\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Request;

class MenuFormRequest extends FormRequest
{
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'title'       => 'required|max:150',
			'menu_slug'   => 'required|max:150',
			'description' => 'required|max:150'
			
			
		];
	}

	/**                             
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}
}