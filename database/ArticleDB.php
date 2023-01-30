<?php

$pdo = require_once "database.php";

class ArticleDB
{

    private PDOStatement|false $statementReadAllCategories;
    private PDOStatement|false $statementCreateOne;
    private PDOStatement|false $statementDeleteOne;
    private PDOStatement|false $statementUpdateOne;
    private PDOStatement|false $statementReadOne;
    private PDOStatement|false $statementReadAll;

    public function __construct(private PDO $pdo){
        $this->statementReadAllCategories = $pdo->prepare('SELECT * FROM category');
        $this->statementCreateOne = $pdo->prepare('INSERT INTO article (
                     title,
                     image,
                     content,
                     category_id
            ) values (
                     :title,
                     :image,
                     :content,
                     :category_id
            );');
        $this->statementUpdateOne = $pdo->prepare('UPDATE article SET 
                   title = :title,
                   image = :image,
                   content = :content,
                   category_id = :category_id
                   WHERE article.id = :id');
        $this->statementReadOne = $pdo->prepare('SELECT article.id,title, content,image,category_id, name FROM article LEFT JOIN category c on article.category_id  = c.id
                                        WHERE article.id=:id');
        $this->statementDeleteOne = $pdo->prepare('DELETE FROM article WHERE id = :id');
        $this->statementReadAll = $pdo->prepare('SELECT article.id as article_id,title, content,image,category_id, name  FROM article LEFT JOIN category c on c.id = article.category_id');
        $this->statementReadOne =  $pdo->prepare('SELECT article.id,title, content,image,category_id, name FROM article LEFT JOIN category c on article.category_id  = c.id
                                    WHERE article.id=:id');
    }
    public function fetchAll(){
        $this->statementReadAll->execute();
        return $this->statementReadAll->fetchAll();
    }
    public function fetchAllCategories(){
        $this->statementReadAllCategories->execute();
        return $this->statementReadAllCategories->fetchAll();
    }
    public function fetchOne(int $id){
        $this->statementReadOne->bindValue(':id',$id);
        $this->statementReadOne->execute();
        return $this->statementReadOne->fetch();
    }
    public function deleteOne(int $id){
        $this->statementDeleteOne->bindValue(':id',$id);
        $this->statementDeleteOne->execute();
        return $id;
    }
    public function createOne($article){
        $this->statementCreateOne->bindvalue(':title', $article['title']);
        $this->statementCreateOne->bindvalue(':image', $article['image']);
        $this->statementCreateOne->bindvalue(':category_id', $article['category']);
        $this->statementCreateOne->bindvalue(':content',$article['content'] );
        $this->statementCreateOne->execute();
        return $this->fetchOne($this->pdo->lastInsertId());
    }
    public function updateOne($article){
        $this->statementUpdateOne->bindvalue(':title', $article['title']);
        $this->statementUpdateOne->bindvalue(':image', $article['image']);
        $this->statementUpdateOne->bindvalue(':category_id', $article['category']);
        $this->statementUpdateOne->bindvalue(':content',$article['content'] );
        $this->statementUpdateOne->bindvalue(':id', $article['id']);
        $this->statementUpdateOne->execute();
        return $article;

    }

}
return new ArticleDB($pdo);