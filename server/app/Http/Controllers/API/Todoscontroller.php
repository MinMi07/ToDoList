<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Todo;

class Todoscontroller extends Controller
{
    public function index() {
        return Todo::orderBy('created_at', 'DESC')->get();

        // $todos = Todo::get();
        // return $todos;
    }

    public function add(Request $req)
    {
        $todo =  new Todo;
        $todo->content = $req->content;
        $todo->checked = $req->checked;
        $todo->completed = $req->completed;
        $todo->created_at = now();
        $todo->updated_at = now();
        $todo->save();

        $todos = Todo::get();
        return $todos;
    }

    public function remove(Request $req)
    {
        $todo = Todo::find($req->id)->delete();
        $todos = Todo::get();
        return $todos;
    }

    public function removeAll(Request $req)
    {
        foreach($req->params as $params){
            if($params['checked'] == true) {
                $todo = Todo::where('id', $params['id'])->delete();
            }
        }

        $todos = Todo::get();
        return $todos;
    }

    public function doneAll(Request $req)
    {
        foreach ($req->params as $params) {
            if ($params['checked'] == true) {
                $todo = Todo::where('id', $params['id'])->first();
                $todo->completed = true;
                $todo->save();
            }
        }

        $todos = Todo::get();
        return $todos;
    }
}
