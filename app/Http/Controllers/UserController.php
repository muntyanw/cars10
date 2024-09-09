<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\{
    Auth,DB,Route
};
use Validator;
use \App\User;

class UserController  extends Controller{
    
    public function get($id){
//        echo getcwd();exit();
        
        $user = User::findOrNew($id);
        return response()->json($user);
    }
    
    public function delete($id){
        $user = User::find($id);
        if($user->photo){
            unlink(getcwd() . '/images/uploads/users/' . $user->photo);
        }
        $user->delete();
        
        return response()->json([
            'status' => 200
        ]);
    }
    
    public function update(Request $request,$id){
        $validator = $this->validateUser($request);
        
        if ($validator->passes()) {
            $user = User::findOrNew($id);
            
            $user->name = $request->input('name');;
            $user->email = $request->input('email');;
            
            if($request->has('password')){
                $user->password = bcrypt($request->input('password'));;
            }
            
            if ($request->hasFile('photo')) {
                $patch = getcwd() . '/images/uploads/users';

                if($user->photo){
                    unlink(getcwd() . '/images/uploads/users/' . $user->photo);
                }

                $photo = $request->file('photo');

                $imgExt = $photo->extension();
                $nameImg = uniqid() . '.' . $imgExt;
                $photo->move($patch, $nameImg);

                $user->photo = $nameImg;
            }
            
            
            $user->save();
            return response()->json([
                'status' => 200,
                'record' => $user   
            ]);
        }     

        return response()->json([
            'status' => 100,
            'errors' => $validator->errors()->all()
        ]);
    }
    
    public function create(Request $request){

        $validator = $this->validateUser($request,true);
        
        if ($validator->passes()) {
            $user = new User;
            $user->name = $request->input('name');;
            $user->email = $request->input('email');;
            $user->password = bcrypt($request->input('password'));;
            
            if ($request->hasFile('photo')) {
                $patch = getcwd() . '/images/uploads/users';

//                @unlink('./' . $patch . '/' . $news->image);

                $photo = $request->file('photo');

                $imgExt = $photo->extension();
                $nameImg = uniqid() . '.' . $imgExt;
                $photo->move($patch, $nameImg);

                $user->photo = $nameImg;
            }
            
            
            $user->save();
            
            return response()->json([
                'status' => 200,
                'record' => $user   
            ]);
        }     

        return response()->json([
            'status' => 100,
            'errors' => $validator->errors()->all()
        ]);
    }
    
    private function validateUser($request,$isCreate = false){
        $cfg = [
            'name' => 'required',
            'email' => 'required'
        ];
        
        if($isCreate){            
           $cfg['password'] = 'required|same:password_repeat';
        }
        else{
            $cfg['password'] = 'same:password_repeat';
        }
        
        return Validator::make($request->all(),$cfg);
    }
}
