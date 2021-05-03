<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Purchase;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $purchase = Purchase::whereClientToken($request->client_token)->first();

        $start_time = \Carbon\Carbon::now();
        $finish_time = \Carbon\Carbon::parse($purchase->expire_date);

        $date = $start_time->diffInDays($finish_time, false);
        $verification = "OK";

        if ($date < 0){
            $verification = "Not OK";

            return response([
                'message' => 'Aboneliğiniz sona ermiştir.',
                'success' => $verification
            ]);
        } else {
            return response([
                'message' => 'Aboneliğiniz devam etmektedir. Kalan gün sayısı ' . $date ."'dur.",
                'success' => $verification
            ]);
        }


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
