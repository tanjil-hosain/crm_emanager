<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Lead;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\Request;

class DasboardController extends Controller
{
    public function index(){
        $totalCustomers= Customer::count();

        //Leads chart
        $leadsState=[
            Lead::where('status','new')->count(),
            Lead::where('status','contacted')->count(),
            Lead::where('status','qualified')->count(),
            Lead::where('status','converted')->count(),
            Lead::where('status','lost')->count(),
        ];

        $totalLeads = Lead::count();
        $newLeads = Lead::where('status','new')->count();
         // Today Sales
        $todaySales = Sale::whereDate('sold_at', today())
            ->sum('total_amount');

        // Today Profit
        $todayProfit = Sale::whereDate('sold_at', today())
            ->selectRaw('SUM(total_amount - total_cost) as profit')
            ->value('profit') ?? 0;

        // Available Products
        $availableProducts = Product::sum('stock_quantity');

        // Monthly Profit
        $monthlyProfit = Sale::whereMonth('sold_at', now()->month)
            ->whereYear('sold_at', now()->year)
            ->selectRaw('SUM(total_amount - total_cost) as profit')
            ->value('profit') ?? 0;
        return view('crm_emanager.backend.dashboard', compact('totalCustomers','leadsState','totalLeads','newLeads','todaySales', 'todayProfit',  'availableProducts', 'monthlyProfit' ));
    }


    public function accounts(){
        $bkash= 45000;
        $nagad = 55000;
        $cash = 83000;
        $bank = 200000;

        return view('crm_emanager.backend.account', compact('bkash', 'nagad', 'cash', 'bank'));
    }
}
