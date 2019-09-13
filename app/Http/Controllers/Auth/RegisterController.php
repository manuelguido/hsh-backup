<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|regex:/^[\pL\s\-]+$/u|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:4|confirmed',
            'birth_date' => 'required|date|before:-18 years',
            'card_name' => 'required|regex:/^[\pL\s\-]+$/u|max:255',
            'card_number' => 'required|min:16|max:16',
            'card_cvv' => 'required|min:3|max:3',
            'card_expdate' => 'required|date|after: 1 months|max:255',
        ]);
        
        
        //$errors_cant = 0;
        //$errores;
    

        //if ($errors_cant > 0){
        //    return back()->with($errores, ['datos' => $data]);
        //}
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'birth_date' => $data['birth_date'],
            'card_name' => $data['card_name'],
            'card_number' => $data['card_number'],
            'card_cvv' => $data['card_cvv'],
            'card_expdate' => $data['card_expdate'],
        ]);
    }
}
