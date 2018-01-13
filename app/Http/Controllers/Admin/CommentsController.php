<?php

namespace App\Http\Controllers\Admin;

use App\Comments;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommentsController extends Controller
{
    public function index()
    {
        $comments = Comments::all();
        return view('admin.comments.index', compact('comments'));
    }

    public function toggle($id)
    {
        $comment = Comments::find($id);
        $comment->toggleStatus();

        return redirect()->back();
    }

    public function destroy($id)
    {
        Comments::find($id)->remove();
        return redirect()->back();
    }
}
