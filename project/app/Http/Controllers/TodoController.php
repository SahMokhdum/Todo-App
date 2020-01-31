<?php

namespace App\Http\Controllers;

use App\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    public function index(){
        $todos = Todo::all();
        $completed = Todo::where('is_completed',1)->count();
        return view('index',compact('todos','completed'));
    }

    public function store(Request $request){
        $todo = new Todo;
        $todo->fill($request->all())->save();
        $data = Todo::where('is_completed',0)->count();            
        return response()->json($data);
    }

    public function update(Request $request,$id){
        $todo = Todo::findOrFail($id);
        $todo->update($request->all());       
        return response()->json($todo->name);
    }

    public function status($id1,$id2){
        $todo = Todo::findOrFail($id1);
        $todo->is_completed = $id2;
        $todo->update();  
        $count = Todo::where('is_completed',0)->count();
        return response()->json($count);  
    }


    public function showAll(){
        $todos = Todo::all();
        $text = '';
        foreach($todos as $todo){
            $ck = $todo->is_completed == 1 ? "checked" : "";
            $class = $todo->is_completed == 1 ? "strikeout" : "";
            $text .= '<tr class="sects">';
            $text .= '<td>';
            $text .= '<div class="round">';
            $text .= '<input type="checkbox" class="checkers" data-check="'. route("todo.status",["id1" => $todo->id, "id2" => 1]) .'" data-uncheck="'. route("todo.status",["id1" => $todo->id, "id2" => 0]) .'" id="checkbox'.$todo->id.'"'.$ck.'  />';
            $text .= '<label for="checkbox'.$todo->id.'"></label>';
            $text .= '</div>';
            $text .= '<div class="text-el ml-4">';
            $text .= '<span class="txt '.$class.'">'.$todo->name.'</span>';
            $text .= '</div>';
            $text .= '<span data-href="'.route('todo.delete',$todo->id).'" class="float-right delete d-none">X</span>';  
            $text .= '<div class="medit d-none">';              
            $text .= '<form class="edit-form" action="'.route('todo.update',$todo->id).'" method="post">';            
            $text .= csrf_field();   
            $text .= '<input type="text" name="name" class="form-control edt">';           
            $text .= '</form>';
            $text .= '</div> ';         
            $text .= '</td>';            
            $text .= '</tr>';    
        }
        return response()->json($text);
    }

    public function showActive(){
        $todos = Todo::where('is_completed',0)->get();
        $text = '';
        foreach($todos as $todo){
            $text .= '<tr class="sects">';
            $text .= '<td>';
            $text .= '<div class="round">';
            $text .= '<input type="checkbox" class="checkers nk" data-check="'. route("todo.status",["id1" => $todo->id, "id2" => 1]) .'" data-uncheck="'. route("todo.status",["id1" => $todo->id, "id2" => 0]) .'" id="checkbox'.$todo->id.'" />';
            $text .= '<label for="checkbox'.$todo->id.'"></label>';
            $text .= '</div>';
            $text .= '<div class="text-el ml-4">';
            $text .= '<span class="txt">'.$todo->name.'</span>';
            $text .= '</div>';
            $text .= '<span data-href="'.route('todo.delete',$todo->id).'" class="float-right delete d-none">X</span>';  
            $text .= '<div class="medit d-none">';              
            $text .= '<form class="edit-form" action="'.route('todo.update',$todo->id).'" method="post">';            
            $text .= csrf_field();   
            $text .= '<input type="text" name="name" class="form-control edt">';           
            $text .= '</form>';
            $text .= '</div> ';         
            $text .= '</td>';            
            $text .= '</tr>';    
        }
        return response()->json($text);
    }

    public function showCompleted(){
        $todos = Todo::where('is_completed',1)->get();
        $text = '';
        foreach($todos as $todo){
            $text .= '<tr class="sects">';
            $text .= '<td>';
            $text .= '<div class="round">';
            $text .= '<input type="checkbox" class="checkers nk" data-check="'. route("todo.status",["id1" => $todo->id, "id2" => 1]) .'" data-uncheck="'. route("todo.status",["id1" => $todo->id, "id2" => 0]) .'" id="checkbox'.$todo->id.'" checked />';
            $text .= '<label for="checkbox'.$todo->id.'"></label>';
            $text .= '</div>';
            $text .= '<div class="text-el ml-4">';
            $text .= '<span class="txt strikeout">'.$todo->name.'</span>';
            $text .= '</div>';
            $text .= '<span data-href="'.route('todo.delete',$todo->id).'" class="float-right delete d-none">X</span>';  
            $text .= '<div class="medit d-none">';              
            $text .= '<form class="edit-form" action="'.route('todo.update',$todo->id).'" method="post">';            
            $text .= csrf_field();   
            $text .= '<input type="text" name="name" class="form-control edt">';           
            $text .= '</form>';
            $text .= '</div> ';         
            $text .= '</td>';            
            $text .= '</tr>';    
        }
        return response()->json($text);
    }


    public function delete($id){
        Todo::findOrFail($id)->delete();
        $count = Todo::count();
        return response()->json($count);
    }

    public function clear(){
        Todo::where('is_completed',1)->delete();
        $count = Todo::count();
        return response()->json($count);
    }

}