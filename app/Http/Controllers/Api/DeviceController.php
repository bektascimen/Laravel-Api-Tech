<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Device;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;

class DeviceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $devices = Device::simplePaginate(100);

        foreach ($devices as $device) {
            $device->application;
            $device->language;
            $device->os;
        }

        return response()->json($devices);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $is_device = Device::where('uId', $request->uId)->where('appId', $request->appId)->first();

        if (!$is_device) {
            $device = new Device();
            $device->uId = $request->uId;
            $device->appId = $request->appId;
            $device->languageId = $request->languageId;
            $device->osId = $request->osId;
            $device->save();
        } else {
            $device = null;
        }

        if ($device) {
            $message = "OK";
            $client_token = uniqid();
            $data = [
                'client_token' => $client_token,
                'uId' => $device->uId
            ];
            Cache::put('key', $data, 60);
        } else {
            $message = "Not OK";
        }

        if ($message == "OK") {
            return response([
                'data' => $device,
                'message' => 'OK',
                'client-token' => $client_token
            ]);
        } else {
            return response([
                'message' => 'Bu cihazın ilgili uygulamaya ait zaten bir aboneliği bulunuyor!'
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $device = Device::find($id);
        $device->application;
        $device->language;
        $device->os;

        return response()->json($device);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, int $id): Response
    {
        $device = Device::find($id);
        $device->uId = $request->uId;
        $device->appId = $request->appId;
        $device->languageId = $request->languageId;
        $device->osId = $request->osId;
        $device->update();

        return response([
            'data' => $device,
            'message' => 'OK'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $device = Device::destroy($id);

        return response()->json($device);
    }
}
