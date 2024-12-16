@extends('layouts.app')

@section('content')
<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>Customer Details</h5>
                    <div class="ibox-tools">
                        <a href="{{ route('customers.index') }}" class="btn btn-xs btn-white">
                            <i class="fa fa-arrow-left"></i> Back to List
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Username:</label>
                                <p class="form-control-static">{{ $user->username }}</p>
                            </div>
                            <div class="form-group">
                                <label class="font-weight-bold">Email:</label>
                                <p class="form-control-static">{{ $user->email }}</p>
                            </div>
                            <div class="form-group">
                                <label class="font-weight-bold">Status:</label>
                                <p class="form-control-static">
                                    <span class="badge {{ $user->status === 'active' ? 'badge-success' : 'badge-danger' }}">
                                        {{ ucfirst($user->status) }}
                                    </span>
                                </p>
                            </div>
                            <div class="form-group">
                                <label class="font-weight-bold">Member Since:</label>
                                <p class="form-control-static">{{ $user->created_at->format('F d, Y') }}</p>
                            </div>
                        </div>
                    </div>

                    @if($orders->count() > 0)
                    <div class="row mt-4">
                        <div class="col-lg-12">
                            <div class="ibox">
                                <div class="ibox-title">
                                    <h5>Order History</h5>
                                </div>
                                <div class="ibox-content">
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Order ID</th>
                                                    <th>Total Amount</th>
                                                    <th>Status</th>
                                                    <th>Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($orders as $order)
                                                <tr>
                                                    <td>{{ $order->order_id }}</td>
                                                    <td>₱{{ number_format($order->total_amount, 2) }}</td>
                                                    <td>
                                                        <span class="badge 
                                                            @if($order->status == 'completed') badge-success
                                                            @elseif($order->status == 'pending') badge-warning
                                                            @elseif($order->status == 'cancelled') badge-danger
                                                            @else badge-info
                                                            @endif">
                                                            {{ ucfirst($order->status) }}
                                                        </span>
                                                    </td>
                                                    <td>{{ $order->created_at->format('M d, Y') }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
