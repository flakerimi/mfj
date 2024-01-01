<?php

namespace App\Controllers;

use Core\Controller;
use App\Models\Post;
use Core\View;

class PostController extends Controller {
    public function index() {
        $data = Post::getAll();
        View::render('posts/index.php', ['data' => $data]);
    }

    public function show($id) {
        $data = Post::getById($id);
        View::render('posts/show.php', ['data' => $data]);
    }

    public function create() {
        View::render('posts/create.php');
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
        $data = Post::getById($id);
        View::render('posts/edit.php', ['data' => $data]);
    }

    public function update($id) {
        $title = $_POST['title'];
        $content = $_POST['content'];
        $data = Post::update($id, $title, $content);
        View::render('posts/update.php', ['data' => $data]);
    }

    public function destroy($id) {
        $data = Post::destroy($id);
        View::render('posts/destroy.php', ['data' => $data]);
    }

    public function search() {
        $keyword = $_POST['keyword'];
        $data = Post::search($keyword);
        View::render('posts/search.php', ['data' => $data]);
    }


}
