<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class OrdersExport implements FromCollection, WithHeadings
{
    protected $orders;

    public function __construct($orders)
    {
        $this->orders = $orders;
    }

    public function collection()
    {
        return $this->orders->map(function ($order) {
            return [
                'invoice'        => $order->invoice,
                'customer_name'  => $order->customer_name ?? 'Bukan Member',
                'products'       => collect(json_decode($order->products))->map(function($product) {
                    return [$product->name, $product->quantity, $product->subtotal];
                })->toArray(),
                'total'          => $order->total,
                'phone_number'   => $order->phone_number,
                'status'         => $order->status,
                'kembalian'      => $order->kembalian,
                'poin_digunakan' => $order->poin_digunakan,
                'tanggal'        => $order->created_at->format('d-m-Y H:i'),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Invoice',
            'Nama Customer',
            'Produk',
            'Total',
            'No. HP',
            'Status',
            'Kembalian',
            'Poin Digunakan',
            'Tanggal Order',
        ];
    }
}
