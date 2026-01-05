<?php

namespace App\Console\Commands;

use App\Mail\LowStockMail;
use App\Models\Product;
use App\Repositories\ProductRepository;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class NotifyLowStock extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stock:notify-low';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notify admin about low stock products';

    /**
     * Execute the console command.
     */
    public function handle(ProductRepository $productRepository){
		
		$products = $productRepository->getLowStockProducts();

		if($products->isNotEmpty()){
			 Mail::to(config('constants.admin_email'))->send(new LowStockMail($products));
		}

        foreach($products as $product){
			$productRepository->updateProductNotifiedAt($product, now());
        }

        return Command::SUCCESS;
    }
}
