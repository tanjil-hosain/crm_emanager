<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DasboardController extends Controller
{
    public function index()
    {
        // Today's date range
        $todayStart = now()->copy()->startOfDay()->toDateTimeString();
        $todayEnd = now()->copy()->endOfDay()->toDateTimeString();

        // This month's date range
        $monthStart = now()->copy()->startOfMonth()->toDateTimeString();
        $monthEnd = now()->copy()->endOfMonth()->toDateTimeString();

        // Current year
        $year = now()->year;

        // Get sales totals for a date range
        $getSalesTotals = function ($start = null, $end = null) {

            $query = DB::table('sales')
                ->whereNull('deleted_at')
                ->where('status', 'completed');

            if ($start && $end) {
                $query->whereBetween('sold_at', [$start, $end]);
            }

            return $query->selectRaw('
                COALESCE(SUM(total_amount), 0) as revenue,
                COALESCE(SUM(total_cost), 0) as cost
            ')->first();
        };

        // Get completed return amount for a date range
        $getReturnAmount = function ($start = null, $end = null) {

            $query = DB::table('sales_returns')
                ->where('status', 'completed');

            if ($start && $end) {
                $query->whereBetween('returned_at', [$start, $end]);
            }

            return (float) $query->sum('total_amount');
        };

        // Get cost of returned products using original sale item cost
        $getReturnedCost = function ($start = null, $end = null) {

            $query = DB::table('sales_return_items as sri')
                ->join('sales_returns as sr', 'sr.id', '=', 'sri.sales_return_id')
                ->join('sale_items as si', 'si.id', '=', 'sri.sale_item_id')
                ->where('sr.status', 'completed');

            if ($start && $end) {
                $query->whereBetween('sr.returned_at', [$start, $end]);
            }

            return (float) $query->sum(
                DB::raw('sri.quantity * si.unit_cost')
            );
        };


        // Total Customers and Leads
        $totalCustomers = DB::table('customers')
            ->whereNull('deleted_at')
            ->count();

        $totalLeads = DB::table('leads')
            ->whereNull('deleted_at')
            ->count();

        $newLeads = DB::table('leads')
            ->whereNull('deleted_at')
            ->where('status', 'new')
            ->count();


        // Today's Revenue and Profit
        $todaySales = $getSalesTotals($todayStart, $todayEnd);

        $todayRevenue = (float) $todaySales->revenue
            - $getReturnAmount($todayStart, $todayEnd);

        $todayCost = (float) $todaySales->cost
            - $getReturnedCost($todayStart, $todayEnd);

        $todayProfit = $todayRevenue - $todayCost;


        // Total Sales Cost (after returned product cost)
        $totalSalesCost = (float) DB::table('sales')
            ->whereNull('deleted_at')
            ->where('status', 'completed')
            ->sum('total_cost')
            - $getReturnedCost();


        // This Month Revenue and Profit
        $monthlySales = $getSalesTotals($monthStart, $monthEnd);

        $thisMonthRevenue = (float) $monthlySales->revenue
            - $getReturnAmount($monthStart, $monthEnd);

        $thisMonthCost = (float) $monthlySales->cost
            - $getReturnedCost($monthStart, $monthEnd);

        $monthlyProfit = $thisMonthRevenue - $thisMonthCost;


        // Leads Overview
        $leadCounts = DB::table('leads')
            ->whereNull('deleted_at')
            ->select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        $leadsState = [
            (int) ($leadCounts['new'] ?? 0),
            (int) ($leadCounts['contacted'] ?? 0),
            (int) ($leadCounts['qualified'] ?? 0),
            (int) ($leadCounts['converted'] ?? 0),
            (int) ($leadCounts['lost'] ?? 0),
        ];


        // Monthly Revenue and Cost Chart
        $salesByMonth = DB::table('sales')
            ->whereNull('deleted_at')
            ->where('status', 'completed')
            ->whereYear('sold_at', $year)
            ->selectRaw('
                MONTH(sold_at) as month,
                SUM(total_amount) as revenue,
                SUM(total_cost) as cost
            ')
            ->groupByRaw('MONTH(sold_at)')
            ->get()
            ->keyBy('month');


        $returnsByMonth = DB::table('sales_returns')
            ->where('status', 'completed')
            ->whereYear('returned_at', $year)
            ->selectRaw('
                MONTH(returned_at) as month,
                SUM(total_amount) as amount
            ')
            ->groupByRaw('MONTH(returned_at)')
            ->get()
            ->keyBy('month');


        $returnedCostByMonth = DB::table('sales_return_items as sri')
            ->join('sales_returns as sr', 'sr.id', '=', 'sri.sales_return_id')
            ->join('sale_items as si', 'si.id', '=', 'sri.sale_item_id')
            ->where('sr.status', 'completed')
            ->whereYear('sr.returned_at', $year)
            ->selectRaw('
                MONTH(sr.returned_at) as month,
                SUM(sri.quantity * si.unit_cost) as cost
            ')
            ->groupByRaw('MONTH(sr.returned_at)')
            ->get()
            ->keyBy('month');


        $monthLabels = [];
        $monthlyRevenue = [];
        $monthlyCost = [];
        $monthlyProfits = [];

        for ($month = 1; $month <= 12; $month++) {

            $monthLabels[] = now()->month($month)->format('M');

            $saleData = $salesByMonth->get($month);
            $returnData = $returnsByMonth->get($month);
            $returnCostData = $returnedCostByMonth->get($month);

            $revenue = (float) ($saleData->revenue ?? 0)
                - (float) ($returnData->amount ?? 0);

            $cost = (float) ($saleData->cost ?? 0)
                - (float) ($returnCostData->cost ?? 0);

            $monthlyRevenue[] = round($revenue, 2);
            $monthlyCost[] = round($cost, 2);
            $monthlyProfits[] = round($revenue - $cost, 2);
        }


        // Current Year Revenue vs Cost
        $yearRevenueTotal = array_sum($monthlyRevenue);
        $yearCostTotal = array_sum($monthlyCost);


        return view(
            'crm_emanager.backend.dashboard',
            compact(
                'totalCustomers',
                'totalLeads',
                'todayRevenue',
                'todayProfit',
                'totalSalesCost',
                'thisMonthRevenue',
                'monthlyProfit',
                'newLeads',
                'leadsState',
                'monthLabels',
                'monthlyRevenue',
                'monthlyCost',
                'monthlyProfits',
                'yearRevenueTotal',
                'yearCostTotal'
            )
        );
    }
}