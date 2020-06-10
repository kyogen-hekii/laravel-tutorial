<?php

namespace App\Http\Controllers;

use App\Folder;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(int $id)
    {
        $folders = Folder::all();
        // view関数でテンプレートにデータを渡す
        // task/indexがテンプレートのファイル名
        // folders => $foldersはkey:valueになっている
        // routingの{id}を受け取って、それをviewに渡してるだけ
        return view('tasks/index', [
            'folders' => $folders,
            'current_folder_id' => $id,
        ]);
    }
}
