<?php

namespace App\Http\Traits;

use App\Models\Purchase;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

trait PurchaseTrait
{
    public function googleVerification($purchase)
    {
        $verification = null;
        $receipt = substr($purchase->receipt, -1);

        if ($receipt % 2 != 0){
            $response = array('message' => 'OK', 'status' => true, 'expire-date' => date('Y-m-d H:i:s', strtotime("+1 month")) );
            return $response;
        } else {
            $response = array('message' => 'Not OK', 'status' => false, 'expire-date' => null);
            return $response;
        }
    }

    public function iosVerification($purchase)
    {
        $verification = null;
        $receipt = substr($purchase->receipt, -1);

        if ($receipt % 2 != 0){
            $response = array('message' => 'OK', 'status' => true, 'expire-date' => date('Y-m-d H:i:s', strtotime("+1 month")) );
            return $response;
        } else {
            $response = array('message' => 'Not OK', 'status' => false, 'expire-date' => null);
            return $response;
        }
    }
}
