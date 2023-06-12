<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use BaoPham\DynamoDb\DynamoDbModel;

class Article extends DynamoDbModel
{
    use HasFactory;

    protected $table = 'TblArticle';
    protected $primaryKey = 'article_id';
    protected $compositeKey = ['article_id', 'category'];

    protected $fillable = ['article_id','category','title','author','date','image','brief','url','contents','docsbrief','docslist','documents','processjson','drawio','timeline'];

}