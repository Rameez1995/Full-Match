<?php

namespace App\Http\Requests\Customer;
use App\customer;
use App\User;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCustomerRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
//            'email' => ['required', 'string', 'email'],
            'phone' => ['integer', 'min:8'],
        ];
    }
    public function handle(){

        $this->validated();

        $params = $this->all();

        $customer = Customer::find($this->id);

        $customer->name = $params['name'];
//        $customer->email = $params['email'];

        $customer->save();

        $user = User::find($customer->user_id);

        $user->name = $params['name'];
        $user->phone = $params['phone'];
//        $user->email = $params['email'];
        $user->status =isset($params['status']) ? 1  : 2; //status 1 for block by admin , 2 for unblock ,or active .

        //$user->password = Hash::make($params['password']);

        $user->save();

        return true;
    }
}
