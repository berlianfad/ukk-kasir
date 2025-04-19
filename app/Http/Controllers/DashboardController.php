<?php

namespace App\Http\Controllers;
use App\Models\Order;
use App\Models\Product;
use App\Models\Toko;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $now = Carbon::now();
        $currentMonth = $now->month;
        $currentYear = $now->year;
        $toko = Toko::first();

        $orders = Order::whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->selectRaw('DAY(created_at) as day, COUNT(*) as total')
            ->groupBy('day')
            ->orderBy('day')
            ->get();

        $days = $orders->pluck('day')->map(function ($day) use ($currentMonth, $currentYear) {
            return Carbon::createFromDate($currentYear, $currentMonth, $day)->translatedFormat('d M Y');
        })->toArray();

        $totals = $orders->pluck('total')->toArray();

        if (empty($days)) {
            $days = [$now->translatedFormat('d M Y')];
            $totals = [0];
        }

        $products = Product::select('name', 'stock')->get();

        return view('admin.dashboard', [
            'days' => $days,
            'totals' => $totals,
            'products' => $products,
            'toko' => $toko,
        ]);
    }
    public function employeeDashboard()
    {
        $today = Carbon::today();
        $toko = Toko::first();

        $ordersToday = Order::whereDate('created_at', $today)->get();

        $totalHariIni = $ordersToday->sum(function ($order) {
            return (int) $order->total;
        });

        $jumlahTransaksiHariIni = $ordersToday->count();

        return view('employee.dashboard', [
            'totalHariIni' => $totalHariIni,
            'jumlahTransaksi' => $jumlahTransaksiHariIni,
            'lastUpdated' => now()->format('d M Y H:i'),
            'toko' => $toko,
        ]);
    }


}
