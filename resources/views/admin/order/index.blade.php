@extends('template.admin')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-2xl font-bold mb-6">Orders</h1>

    <table class="w-full bg-white rounded shadow">
        <thead>
            <tr class="bg-gray-200">
                <th class="p-4 text-left">Order ID</th>
                <th class="p-4 text-left">User</th>
                <th class="p-4 text-left">Total</th>
                <th class="p-4 text-left">Payment Method</th>
                <th class="p-4 text-left">Created At</th>
                <th class="p-4 text-left">Actions</th>
            </tr>
        </thead>

        <tbody>
            @foreach($orders as $order)
            <tr>
                <td class="border-t p-4">{{ $order->id }}</td>
                <td class="border-t p-4">{{ $order->user->name }}</td>
                <td class="border-t p-4">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                <td class="border-t p-4">{{ $order->payment_method }}</td>
                <td class="border-t p-4">{{ $order->created_at->format('d-m-Y H:i:s') }}</td>
                <td class="border-t p-4">
                    <a href="{{ route('admin.orders.show', $order->id) }}" class="bg-blue-500 text-white px-4 py-2 rounded">View</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
