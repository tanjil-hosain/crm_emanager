<?php
namespace App\Http\Controllers;
use App\Models\Branch;
use App\Models\Product;
use Illuminate\Http\Request;

class BranchProductController extends Controller
{
    // Show products assigned to a branch
    public function index(Branch $branch)
    {
        $branch->load('products');

        $assignedProductIds = $branch->products->pluck('id');

        $availableProducts = Product::whereNotIn('id', $assignedProductIds)
            ->where('status', 'active')
            ->get();

        return view(
            'crm_emanager.backend.admin.branches.products.index',
            compact('branch', 'availableProducts')
        );
    }

    // Assign product to branch
    public function store(Request $request, Branch $branch)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'purchase_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'alert_quantity' => 'required|integer|min:0',
        ]);

        if ($branch->products()->where('products.id', $validated['product_id'])->exists()) {
            return back()->with('error', 'This product is already assigned to this branch.');
        }

        $branch->products()->attach($validated['product_id'], [
            'purchase_price' => $validated['purchase_price'],
            'selling_price' => $validated['selling_price'],
            'stock_quantity' => $validated['stock_quantity'],
            'alert_quantity' => $validated['alert_quantity'],
            'status' => 'active',
        ]);

        return back()->with('success', 'Product assigned successfully.');
    }

    // Update branch product
    public function update(Request $request, Branch $branch, Product $product)
    {
        $validated = $request->validate([
            'purchase_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'alert_quantity' => 'required|integer|min:0',
            'status' => 'required|in:active,inactive',
        ]);

        if (!$branch->products()->where('products.id', $product->id)->exists()) {
            abort(404);
        }

        $branch->products()->updateExistingPivot($product->id, $validated);

        return back()->with('success', 'Branch product updated successfully.');
    }

    // Remove product from branch
    public function destroy(Branch $branch, Product $product)
    {
        $branch->products()->detach($product->id);

        return back()->with('success', 'Product removed from branch.');
    }
}
