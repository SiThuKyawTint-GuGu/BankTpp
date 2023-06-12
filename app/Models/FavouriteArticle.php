<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use BaoPham\DynamoDb\DynamoDbModel;

class FavouriteArticle extends DynamoDbModel
{
    use HasFactory;

    protected $table = 'TblFavourite';
    protected $primaryKey = 'user_id';
    protected $compositeKey = ['user_id', 'article_id'];

    protected $fillable = ['user_id','article_id'];
}
