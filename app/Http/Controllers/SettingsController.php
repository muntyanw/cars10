<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\{
    Auth,DB
};
use App\User;

class SettingsController  extends Controller{
    
    public function index(){   
        view()->share('pageTitle', __('messages.settings'));
        
        return view('settings.index',[
            'users' => User::where('id','!=',1)->limit(20)->get()
        ]);
    }
}
