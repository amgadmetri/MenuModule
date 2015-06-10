<?php
namespace App\Modules\Menus\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Request;

class MenuItemFormRequest extends FormRequest
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
			'menu_id'       => 'required',
			'title'         => 'required|max:150',
			'link'          => 'max:150',
			'status'        => 'required',
			'parent_id'     => 'required',
			'target'        => 'required',
			'display_order' => 'required'
			
			
		];
	}
}