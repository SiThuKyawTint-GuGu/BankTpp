<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Scorecard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ScorecardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'user_id' => ['required'],
            'score' => ['required']
        ]);

        //
        $scorecard = new Scorecard();
        $scorecard->user_id = (int)$request->user_id;
        $scorecard->age = $request->age ? $request->age : '';
        $scorecard->mthincome = $request->mthincome ? $request->mthincome : 0;
        $scorecard->mthloanpayment = $request->mthloanpayment ? $request->mthloanpayment : 0;
        $scorecard->numdependents = $request->numdependents ? $request->numdependents : '';
        $scorecard->emptype = $request->emptype ? $request->emptype : '';
        $scorecard->emplength = $request->emplength ? $request->emplength : '';
        $scorecard->housingstatus = $request->emptype ? $request->housingstatus : '';
        $scorecard->housinglength = $request->housinglength ? $request->housinglength : '';
        $scorecard->numcreditcards = $request->numcreditcards ? $request->numcreditcards : '';
        $scorecard->bankaccts = $request->bankaccts ? $request->bankaccts : '';
        $scorecard->loantypes = $request->loantypes ? $request->loantypes : '';
        $scorecard->houseloanamt = $request->houseloanamt ? $request->houseloanamt : 0;
        $scorecard->carloanamt = $request->carloanamt ? $request->carloanamt : 0;
        $scorecard->unsecuredloanamt = $request->unsecuredloanamt ? $request->unsecuredloanamt : 0;
        $scorecard->score = $request->score;
        $scorecard->scorerange = $request->scorerange ? $request->scorerange : '';
        $scorecard->maxloan = $request->maxloan ? $request->maxloan : 0;

        if($scorecard->save()) {
            return response()->json([
                'status' => true,
                'message' => 'Scorecard saved successfully.',
            ], 200
            );

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getscore(Request $request)
    {

        Log::info('');
        Log::info('Hit to ScorecardController@getscore');
        Log::info('Age - ' . $request->age);
        Log::info('Number of Dependents - ' . $request->numdependents);
        Log::info('Employment Type - ' . $request->emptype);
        Log::info('Employment Length - ' . $request->emplength);
        Log::info('Housing Status - ' . $request->housingstatus);
        Log::info('Housing Length - ' . $request->housinglength);
        Log::info('Number of Credit Cards - ' . $request->numcreditcards);
        Log::info('Bank Account Types - ' . json_encode($request->bankaccts));
        Log::info('Number of Loans - ' . json_encode($request->loantypes));
        Log::info('Monthly Income - ' . $request->mthincome);
        Log::info('Est Monthly Repayment Amount - ' . $request->mthloanpayment);

        $request->validate([
            'age' => ['required'],
            'mthincome' => ['required'],
            'mthloanpayment' => ['required']
        ]);

        //Get Page data
        $scorepagedata = Page::findOrFail('scorecard');
        Log::info('Page data - ' . $scorepagedata->title);
        $scorepagearray = json_decode($scorepagedata, true);
        $parameters = $scorepagearray['itemList1'][0];
        $scorerangedata = $scorepagearray['itemList2'][0];
        $maxloandata = $scorepagearray['itemList3'][0];
        Log::info('Test - ' . json_encode($parameters));

        //Get each score by matching
        $numdependentsScore = $this->getMatchScoreFieldValue($parameters['number_of_dependents'], $request->numdependents);
        $employmentTypeScore = $this->getMatchScoreFieldValue($parameters['employment_type'], $request->emptype);
        $employmentLengthScore = $this->getMatchScoreFieldValue($parameters['employment_length'], $request->emplength);
        $housingStatusScore = $this->getMatchScoreFieldValue($parameters['housing_status'], $request->housingstatus);
        $housestayLengthScore = $this->getMatchScoreFieldValue($parameters['housestay_length'], $request->housinglength);
        $creditCardScore = $this->getMatchScoreFieldValue($parameters['creditcards_count'], $request->numcreditcards);

        //Get each score by comparison
        $ageScore = $this->getRangeScoreFieldValue($parameters['age'], $request->age);

        //Get each score by totaling
        $bankAcctScore = $this->getTotalScoreFieldValue($parameters['deposit_accounts'], $request->bankaccts);
        $loanTypesScore = $this->getTotalScoreFieldValue($parameters['loans_type'], $request->loantypes);


        Log::info('');
        Log::info('Computing...');
        Log::info('Dependents Grid - ' . $numdependentsScore);
        Log::info('Employment Type Grid - ' . $employmentTypeScore);
        Log::info('Employment Length Grid - ' . $employmentLengthScore);
        Log::info('Housing Status Grid - ' . $housingStatusScore);
        Log::info('Housing Length Grid - ' . $housestayLengthScore);
        Log::info('Age Score - ' . $ageScore);
        Log::info('Bank Accounts Score - ' . $bankAcctScore);
        Log::info('Credit Card Score - ' . $creditCardScore);
        Log::info('Loan Types Score - ' . $loanTypesScore);

        //Do the math
        $score =
            $numdependentsScore +
            $employmentTypeScore +
            $employmentLengthScore +
            $housingStatusScore +
            $housestayLengthScore +
            $ageScore +
            $bankAcctScore +
            $creditCardScore +
            $loanTypesScore;

        $scorerange = $this->getRangeScoreFieldValue($scorerangedata['range_grid'], $score);
        $maxloanoffer = $this->getRangeScoreFieldValue($maxloandata['offer_grid'], $score);

        //Record the Scorecard
        if($score > 0) {
            $request->request->add(['score' => $score, 'scorerange' => $scorerange, 'maxloan' => $maxloanoffer]); //add request
            $this->store($request);
        }

        //Reponse
        return response()->json([
            'score' => $score,
            'range' => $scorerange,
            'maxloan' => $maxloanoffer
        ]);

    }

    //Get exact match score field value
    public function getMatchScoreFieldValue($items, $key)
    {
        $value = '';
        foreach ($items as $item) {
            if ($item['field'] == $key)
                return $item['value'];

        }

        return $value;

    }

    //Get the Score value by Comparison
    public function getRangeScoreFieldValue($items, $input)
    {
        foreach ($items as $item) {
            if ($input >= $item['field']) {
                return $item['value'];
            }
        }
    }

    //Total up the Score value
    public function getTotalScoreFieldValue($items, $keys)
    {
        $totalAcctScore = 0;
        foreach ($items as $item) {
            if (in_array($item['field'], $keys))
                $totalAcctScore += $item['value'];
        }
        return $totalAcctScore;

    }
}
