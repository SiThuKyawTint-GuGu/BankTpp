<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use BaoPham\DynamoDb\DynamoDbModel;

class Scorecard extends DynamoDbModel
{
    use HasFactory;

    protected $table = 'TblScorecard';
    protected $primaryKey = 'user_id';
    protected $fillable = ['age','mthincome','mthloanpayment','numdependents','emptype','emplength','housingstatus','housinglength','numcreditcards','bankaccts','loantypes','houseloanamt','carloanamt','unsecuredloanamt'];
}
