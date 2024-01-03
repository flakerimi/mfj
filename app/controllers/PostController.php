<?php

namespace App\Controllers;

use Core\Controller;
use App\Models\Post;
 
class PostController extends Controller {
    public function index() {
        $data = Post::getAll();
      return view('posts/index.php', ['data' => $data]);
    }

    public function show($id) {
        $data = Post::find($id);
        return view('posts/show.php', ['data' => $data]);
    }

    public function create() {
        return view('posts/create.php');
    }

    public function store() {
        $title = $_POST['title'];
        $content = $_POST['content'];
        $data = Post::create($title, $content);
        
        if ($data) {
            $_SESSION['success'] = 'Post created successfully';
            return redirect('/posts');
        } else {
            $_SESSION['error'] = 'Post created failed';
            return redirect('/posts/create');
        }
    }

    public function edit($id) {
        $data = Post::find($id);
        return view('posts/edit.php', ['data' => $data]);
    }

    public function update($id) {
        $title = $_POST['title'];
        $content = $_POST['content'];
        $data = Post::update($id, $title, $content);
        return view('posts/update.php', ['data' => $data]);
    }

    public function destroy($id) {
        $data = Post::destroy($id);
        return view('posts/destroy.php', ['data' => $data]);
    }

    public function search() {
        $keyword = $_POST['keyword'];
        $data = Post::search($keyword);
        return view('posts/search.php', ['data' => $data]);
    }


}
