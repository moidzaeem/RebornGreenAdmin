@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>User Details</h4>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-4"><strong>ID:</strong></div>
                        <div class="col-md-8">{{ $customer->id }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4"><strong>Name:</strong></div>
                        <div class="col-md-8">{{ $customer->name }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4"><strong>Email:</strong></div>
                        <div class="col-md-8">{{ $customer->email }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4"><strong>Joining Date:</strong></div>
                        <div class="col-md-8">{{ \Carbon\Carbon::parse($customer->created_at)->format('F d, Y') }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4"><strong>Trees Purchased:</strong></div>
                        <div class="col-md-8">{{$treesCount}}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4"><strong>Climate Points:</strong></div>
                        <div class="col-md-8">{{$climatePointsCount}}</div>
                    </div>

                    
                    {{-- <div class="row">
                        <div class="col-md-12">
                            <a href="" class="btn btn-primary">Edit</a>
                            <a href="" class="btn btn-secondary">Back to List</a>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>

    <div class="page-content-wrapper mt-5">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card m-b-20">
                        <div class="card-body">
    
                            <h4 class="mt-0 header-title">Subscriptions</h4>
    
                            <table id="datatable" class="table table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Grand Total</th>
                                        <th>Subscription Type</th>
                                        <th>Created At</th>
                                        <th>End Date</th>
                                    </tr>
                                </thead>
    
    
                                <tbody>
                                    @foreach ($subscriptions as $subscription)
                                    <tr>
                                        <td>{{$subscription->id}}</td>
                                        <td>{{$subscription->grand_total}}</td>
                                        <td>Climate Offset</td>
                                        <td>{{ \Carbon\Carbon::parse($subscription->createdAt)->format('F d, Y') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($subscription->end_date)->format('F d, Y') }}</td>

                                    

                                    </tr>
                                    @endforeach
                                
                                </tbody>
                            </table>
    
                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->
        </div><!-- container-fluid -->
    </div>
</div>
@endsection
