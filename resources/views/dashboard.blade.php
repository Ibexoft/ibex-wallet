@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="mt-4 row justify-content-center">
            <div class="col-md-8">
                @include('transactions.list', ['transactions' => $transactions])
            </div>
            {{-- @include('transactions.add-edit-modal') --}}

            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        @include('transactions.create-widget')
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('script')
    <script>
       $(document).ready(function() {
            transactionInitialConfiguration();
            window.transactionRoutes = {
                store: "{{ route('transactions.store') }}",
                update: "{{ route('transactions.update', ['transaction' => '__TRANSACTION_ID__']) }}",
                destroy: "{{ route('transactions.destroy', ['transaction' => '__TRANSACTION_ID__']) }}",
                show: "{{ route('transactions.show', ['transaction' => '__TRANSACTION_ID__']) }}"
            };
        });
    </script>
@endsection
