<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Storage;
use Hash;


class ResetPasswordController extends Controller
{

    public function resetPassword(Request $request){
        $this->validate($request, [
            'email' => 'required'
        ]);

        $check_email = DB::table('users')
            ->where('email', '=', $request->email)
            ->get();

        if (count($check_email) > 0) {

            $user = DB::table('users')
                ->where('email', $request->email)
                ->get();

            $nh_password = 'nueva_contraseña123';
            $new_password = Hash::make($nh_password);
            
            DB::table('users')
                ->where('id', $user->first()->id)
                ->update(['password' => $new_password]);
            
            $email_content = 'Email: '.$user->first()->email.' '.'Nueva contraseña: '.$nh_password;

            Storage::put('/public/emails/cambio_de_email_de_'.$user->first()->email.'.txt', $email_content);
            return redirect()->back()->with('success', 'Se te ha enviado un email con tu nueva contraseña');
        }
        else {
            return redirect()->back()->with('error', 'No existe ese email registrado en el sitio');
        }

    }
}
