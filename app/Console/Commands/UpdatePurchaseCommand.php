<?php

namespace App\Console\Commands;

use App\Http\Traits\PurchaseTrait;
use App\Models\Device;
use App\Models\Purchase;
use Illuminate\Console\Command;

class UpdatePurchaseCommand extends Command
{
    use PurchaseTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:purchase';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Iptal edilmeyen ve abonelik tarihi dolan satın alımlar guncellendi.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Purchase::chunk(100, function ($purchases){
            $this->info('Satın alımlar kontrol ediliyor.');
            foreach ($purchases as $purchase) {
                $start_time = \Carbon\Carbon::now();
                $finish_time = \Carbon\Carbon::parse($purchase->expire_date);
                $date = $start_time->diffInDays($finish_time, false);

                if ($purchase->is_canceled == 0 && $date < 0) {
                    $device = Device::where('uId', $purchase->device_id)->first();

                    if ($device->osId == 1) {
                        $verification = $this->iosVerification($purchase);
                    } else {
                        $verification = $this->googleVerification($purchase);
                    }

                    if ($verification['message'] == 'OK'){
                        $purchase->expire_date = date('Y-m-d H:i:s', strtotime("+1 month"));
                        $purchase->update();
                    }
                }
            }
            $this->info('Güncelleme işlemleri başarılı.');
        });

        return 'İşlem başarılı';
    }
}
