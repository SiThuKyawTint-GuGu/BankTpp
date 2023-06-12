<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use BaoPham\DynamoDb\DynamoDbModel;
use Illuminate\Support\Facades\Log;

class Page extends DynamoDbModel
{
    use HasFactory;

    protected $table = 'TblPageText';
    protected $primaryKey = 'pagename';
    protected $fillable = ['title','subtitle','textlines','textsections','fieldlabels','photos','itemList1','itemList2','itemList3'];

    public function update_bank_rates($bankname,$buyusd,$sellusd,$buysgd,$sellsgd,$updated_datetime) {

        //Update the page
        $page = Page::where('pagename', 'rates')->first();

        $ratearray = [];
        $i = 0;
        foreach ($page->itemList1 as $bankrate) {

            $ratearray[$i] = $bankrate;

            if(str_contains($bankrate['avatar'], $bankname)) {

                //AYA Bank
                $attributes = [
                    'avatar' => $bankrate['avatar'],
                    'buyusd' => last(explode(" ",$buyusd)),
                    'sellusd' => last(explode(" ",$sellusd)),
                    'buysgd' => last(explode(" ",$buysgd)),
                    'sellsgd' => last(explode(" ",$sellsgd)),
                    'subicon'  => $bankrate['subicon'],
                    'subtext' => $updated_datetime,
                    'color'  => $bankrate['color'],
                    'icon'  => $bankrate['icon'],
                    'title'  => $bankrate['title'],
                ];

                //Update back
                $ratearray[$i]  = $attributes;
            } else { //No changes
                $ratearray[$i] = $bankrate;
            }
            $i++;

//            Log::error('$page->itemList1 @parse- '.$bankrate['avatar']);
        }

//        Log::error('Rate array @parse- '.json_encode($ratearray));
        $page->itemList1 = $ratearray;
        $page->save();

    }
}
