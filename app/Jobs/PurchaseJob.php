<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Purchase;

class PurchaseJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected Purchase $purchase;
    protected $total_price;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Purchase $purchase, $total_price)
    {
        $this->purchase = $purchase;
        $this->total_price = $total_price;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        
        $this->purchase->update([
            "status" => "completed",
            "payment_amount" => $this->total_price
        ]);
        
    }
}
