<?php
    $filename = __DIR__.'/data/articles.json';
    $articles = [];
    if(file_exists($filename)){
        $articles = json_decode(file_get_contents($filename) ,true) ?? [];
    }
    $_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $id = $_GET['id'] ?? '';

    if($id){
        $articleIndex = array_search($id, array_column($articles, 'id'));
        $article = $articles[$articleIndex] ?? [];
        if($article['id'] !== (int)$id ){
            header('Location: /');
        }
        array_splice($articles,$articleIndex,1);
        file_put_contents($filename,json_encode($articles));
        header('Location: /');
    }else{
        header('Location: /');
    }