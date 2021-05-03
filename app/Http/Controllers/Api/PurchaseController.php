<?php

namespace App\Http\Controllers\Api;

use App\Events\StartedEvent;
use App\Http\Controllers\Controller;
use App\Http\Traits\PurchaseTrait;
use App\Models\Purchase;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    use PurchaseTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $purchase = Purchase::simplePaginate(100);

        return response()->json($purchase);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        if ($request->osId == 2){
            $purchaseVerification = $this->googleVerification($request);
        } else {
            $purchaseVerification = $this->iosVerification($request);
        }

        if ($purchaseVerification['message'] == 'OK'){
            $purchase = new Purchase();
            $purchase->device_id = $request->device_id;
            $purchase->client_token = $request->client_token;
            $purchase->receipt = $request->receipt;
            $purchase->status = $purchaseVerification['status'];
            $purchase->expire_date = $purchaseVerification['expire-date'];
            $purchase->save();

//            event(new StartedEvent($purchase));

            return response()->json($purchase);
        } else {
            return response()->json('Satın alma işlemi başarısız.');
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
}
