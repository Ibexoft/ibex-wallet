@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="mt-4 row justify-content-center">
            <div class="col-md-8 order-2 order-md-1 mt-md-auto mt-4">
                @include('transactions.list', ['transactions' => $transactions])
            </div>

            <div class="col-md-4 order-1 order-md-2">
                <div class="card">
                    <div class="card-body">
                        @include('transactions.create-widget')
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div id="modalDiv">
        @include('transactions.add-edit-modal')
    </div>
@endsection

@section('script')
    <script>
        document.addEventListener("DOMContentLoaded", function () {
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
