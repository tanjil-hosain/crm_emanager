<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::transaction(function () {

            // Create Main Branch
            $branchId = DB::table('branches')->insertGetId([
                'branch_name' => 'Main Branch',
                'branch_code' => 'MAIN',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Copy existing products, prices and stock
            $products = DB::table('products')->get();

            foreach ($products as $product) {
                DB::table('branch_product')->insert([
                    'branch_id' => $branchId,
                    'product_id' => $product->id,
                    'purchase_price' => $product->purchase_price,
                    'selling_price' => $product->selling_price,
                    'stock_quantity' => $product->stock_quantity,
                    'alert_quantity' => 5,
                    'status' => $product->status === 'active' ? 'active' : 'inactive',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // Assign existing sales to Main Branch
            DB::table('sales')->update([
                'branch_id' => $branchId,
            ]);
        });
    }

    public function down(): void
    {
        // Keep existing product and sales data safe.
        // Do not automatically delete Main Branch data.
    }
};