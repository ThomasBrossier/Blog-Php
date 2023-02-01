<?php

class ArticleDB
{

    private PDOStatement|false $statementReadAllCategories;
    private PDOStatement|false $statementCreateOne;
    private PDOStatement|false $statementDeleteOne;
    private PDOStatement|false $statementUpdateOne;
    private PDOStatement|false $statementReadOne;
    private PDOStatement|false $statementReadAll;
    private PDOStatement|false $statementReadByUser;

    public function __construct(private PDO $pdo){
        $this->statementReadAllCategories = $pdo->prepare('SELECT * FROM category');
        $this->statementCreateOne = $pdo->prepare('INSERT INTO article (
                     title,
                     image,
                     content,
                     category_id,
                     author
            ) values (
                     :title,
                     :image,
                     :content,
                     :category_id,
                     :userid
            );');
        $this->statementUpdateOne = $pdo->prepare('UPDATE article SET 
                   title = :title,
                   image = :image,
                   content = :content,
                   category_id = :category_id
                   WHERE article.id = :id');
        $this->statementReadOne = $pdo->prepare('SELECT article.id ,article.author, article.title, article.content, article.image,  article.category_id,u.firstname, u.lastname, c.name 
                                                       FROM article
                                                       LEFT JOIN category c 
                                                       ON article.category_id  = c.id
                                                       LEFT JOIN user u 
                                                       ON u.id = article.author
                                                       WHERE article.id=:id;');
        $this->statementDeleteOne = $pdo->prepare('DELETE FROM article WHERE id = :id');
        $this->statementReadAll = $pdo->prepare('SELECT article.id as article_id,title, content,image,author, category_id, c.name, u.firstname, u.lastname  
                                                       FROM article 
                                                       LEFT JOIN category c ON c.id = article.category_id 
                                                       JOIN user u ON article.author=u.id');
        $this->statementReadByUser = $pdo->prepare('SELECT article.id as article_id,title, content,image,author, category_id, c.name  
                                                       FROM article 
                                                       LEFT JOIN category c ON c.id = article.category_id 
                                                       LEFT JOIN user u ON article.author=u.id
                                                       WHERE article.author=:id');
    }
    public function fetchAll() :array{
        $this->statementReadAll->execute();
        return $this->statementReadAll->fetchAll();
    }
    public function fetchAllCategories() :array{
        $this->statementReadAllCategories->execute();
        return $this->statementReadAllCategories->fetchAll();
    }
    public function fetchOne(string $id) :array{
        $this->statementReadOne->bindValue(':id',(int)$id);
        $this->statementReadOne->execute();
        return $this->statementReadOne->fetch();
    }
    public function deleteOne(string $id) :int {
        $this->statementDeleteOne->bindValue(':id',(int)$id);
        $this->statementDeleteOne->execute();
        return $id;
    }
    public function createOne(array $article) :array{
        $this->statementCreateOne->bindvalue(':title', $article['title']);
        $this->statementCreateOne->bindvalue(':image', $article['image']);
        $this->statementCreateOne->bindvalue(':category_id', $article['category']);
        $this->statementCreateOne->bindvalue(':content',$article['content'] );
        $this->statementCreateOne->bindvalue(':userid',$article['author'] );
        $this->statementCreateOne->execute();
        return $this->fetchOne($this->pdo->lastInsertId());
    }
    public function updateOne(array $article) :array{
        $this->statementUpdateOne->bindvalue(':title', $article['title']);
        $this->statementUpdateOne->bindvalue(':image', $article['image']);
        $this->statementUpdateOne->bindvalue(':category_id', $article['category']);
        $this->statementUpdateOne->bindvalue(':content',$article['content'] );
        $this->statementUpdateOne->bindvalue(':id', $article['id']);
        $this->statementUpdateOne->execute();
        return $article;

    }
    public function fetchUserArticles(int $id) :array {
        $this->statementReadByUser->bindvalue(':id', $id);
        $this->statementReadByUser->execute();
        return $this->statementReadByUser->fetchAll();
    }

}
return new ArticleDB($pdo);