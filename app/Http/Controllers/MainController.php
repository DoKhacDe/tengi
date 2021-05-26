<?php

namespace App\Http\Controllers;
use App\Models\Admin;
use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class MainController extends Controller
{
    function Login(){
        return view('auth.login');
    }
    function register(){
        return view('auth.register');
    }
    function save(Request $request){
        $request->validate([
            'name'=>'required',
            'email'=>'required|email|unique:admin',
            'password'=>'required|min:6|max:20'
        ]);
        $admin = new Admin;
        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->password =Hash::make($request->password);
        $save = $admin->save();
        if($save) {
            return back()->with('success','New User has been successfully added to database');
        }
        else {
            return back()->with('fail','Something went wrong, try again later');
        }
    }
    function check(Request $request){
        $request->validate([
            'email'=>'required|email',
            'password'=>'required|min:6|max:20'
        ]);
        $userInfor = Admin::where('email','=' ,$request->email)->first();
        if(!$userInfor){
            return back()->with('fail', 'we do not recognize your email address');
        }
        else{
        if(Hash::check($request->password,$userInfor->password)){
            $request->session()->put('LoggedUser',$userInfor->id);
            return redirect('todolist/index');
        }
        else{
            return back()->with('fail', 'Incorrect password');
        }
    }
    }
    function Logout(){
        if(session()->has('LoggedUser')){
            session()->pull('LoggedUser');
            return redirect('auth/login');
        }
    }
    function index(){
        $data = ['LoggedUserInfo'=>Admin::where('id','=',session('LoggedUser'))->first()];
        $req = Todo::orderBy('completed')->get();
        return view('todolist.index',$data, compact('req'));
    }
    function create(){
        $data = ['LoggedUserInfo'=>Admin::where('id','=',session('LoggedUser'))->first()];
        return view('todolist.create',$data);
    }
    function upload(Request $request){
        $request->validate([
            'title'=>'required|max:255'
        ]);
        $todo = $request->title;
        Todo::create(['title' => $todo]);
        return redirect('todolist/index');
    }
    function completed($id){
        $todo = Todo::find($id);
        if($todo->completed){
            $todo->update(['completed'=>false]);
            return redirect()->back()->with('success','Todo marked as incomplete!');
        }
        else {
            $todo->update(['completed' => true]);
            return redirect()->back()->with('fail','Todo marked as complete!');
        }
    }
    function edit($id){
        $todo = Todo::find($id);

        $data = ['LoggedUserInfo'=>Admin::where('id','=',session('LoggedUser'))->first()];
        return view('todolist.edit',$data)->with(['id' => $id, 'todo' => $todo]);
    }
    function update(Request $request){
        $request->validate([
            'title'=>'required|max:225'
        ]);
        $updateTodo = Todo::find($request->id);
        $updateTodo->update(['title' => $request->title]);
        return redirect('todolist/index');
    }
    function delete($id){
        $todo = Todo::find($id);
        $todo->delete();
        return redirect()->back()->with('fail','Todo deleted Successfully!');
    }
}
