@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">

        <div class="col-md-12">

            @if (Session::has('success'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                    {{ Session::get('success') }}
                </div>
            @endif

            {{-- <div class="d-flex justify-content-end">
                <a href="{{ route('admin.customer.create') }}" class="btn btn-primary">Create Customers</a>
            </div> --}}

        </div>
    </div>

    {{-- DATATABLE --}}

    <div class="page-content-wrapper mt-5">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card m-b-20">
                        <div class="card-body">

                            <h4 class="mt-0 header-title">All Subscriptions Info</h4>

                            <table id="datatable" class="table table-bordered dt-responsive nowrap" cellspacing="0"
                                width="100%">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Status</th>
                                        <th>User Email</th>
                                        <th>Created Date</th>
                                        <th>Grand Total</th>
                                    </tr>
                                </thead>


                                <tbody>
                                    @foreach ($subscriptions as $subscription)
                                        <tr>
                                            <td>{{ $subscription->id }}</td>
                                            <td>{{ $subscription->status }}</td>
                                            <td>{{ $subscription->user->email }}</td>
                                            <td>{{ \Carbon\Carbon::parse($subscription->createdAt)->format('F d, Y') }}</td>
                                            <td>{{ $subscription->grand_total }}</td>
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
@endsection

@section('pageSpecificJs')
@endsection
