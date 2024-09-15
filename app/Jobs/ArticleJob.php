<?php

namespace App\Jobs;

use App\Models\Article;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ArticleJob implements ShouldQueue
{
    use Queueable;
    public $product;
    /**
     * Create a new job instance.
     */
    public function __construct($product)
    {
        $this->product = $product;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $product = $this->product;
        Article::create([
            "name" => $product->name,
            "sku" => $product->sku,
            "mfm_product_id" => $product->mfm_product_id,
            "HSN_code" => $product->HSN_code
        ]);
    }
}
