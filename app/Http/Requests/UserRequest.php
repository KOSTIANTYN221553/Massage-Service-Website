<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        switch ($this->method()) {
            case 'GET':
            case 'DELETE': {
                return [];
            }
            case 'POST': {
                return [
                    'nickname' => 'required|min:3',
                    'email' => 'required|unique:user,email',
                    'user_email' => 'required|email',
                    'password' => 'required|between:8,32',
                    'password_confirm' => 'required|same:password',

                ];
            }
            case 'PUT':
            case 'PATCH': {
                return [
                    'first_name' => 'required|min:3',
                    'last_name' => 'required|min:3',
                    'email' => 'required|unique:users,email,' . $this->user->id,
                    'password_confirm' => 'sometimes|same:password',
                    'pic_file' => 'image|mimes:jpg,jpeg,bmp,png|max:10000'
                ];
            }
            default:
                break;
        }

        return [

        ];
    }


}

