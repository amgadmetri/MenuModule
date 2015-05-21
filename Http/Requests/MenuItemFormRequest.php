<?php
namespace App\Modules\Menus\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Request;

class MenuItemFormRequest extends FormRequest
{
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'menu_id'       => 'required|max:150',
			'title'         => 'required|max:150',
			'link'          => 'url|max:150',
			'status'        => 'required|max:150',
			'parent_id'     => 'required|max:150',
			'target'        => 'required|max:150',
			'display_order' => 'required|max:150'
			
			
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