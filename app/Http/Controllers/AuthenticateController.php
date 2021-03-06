<?php

namespace App\Http\Controllers;

use App\Models\StudentMarkModel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Student;

class AuthenticateController extends Controller
{
    public function login()
    {
        return view('login');
    }
    public function loginProcess(Request $request)
    {
        $email = $request->get('email');
        $password = $request->get('password');
        try {
            $student = StudentMarkModel::where('email', $email)->where('password', $password)->firstOrFail();
            $request->session()->put('idStudent', $student->idStudent);
            $request->session()->put('nameStudent', $student->nameStudent);
            return Redirect::route("overview");
        } catch (Exception $e) {
            return Redirect::route("login")->with('error', [
                "message" => 'Sai Email hoặc password',
                "email" => $email
            ]);
        }
    }
    public function logout(Request $request)
    {
        $request->session()->flush();
        return Redirect::route("login");
    }
}
