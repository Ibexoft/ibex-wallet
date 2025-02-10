@extends('layouts.app')

@php
    use App\Enums\TransactionType as TransactionType;
@endphp

@section('content')
    <div class="container-fluid">

        <div class="my-4 row justify-content-center">
            <div class="col-md-12 order-2 order-md-1 mt-md-auto mt-4">
                <div class="row">
                    <div class="col-lg-8 col-12">
                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-12">
                                <div class="card">
                                    <span class="mask bg-dark bg-gradient opacity-10 border-radius-lg"></span>
                                    <div class="card-body p-3 position-relative">
                                        <div class="row">
                                            <div class="col-9 text-start">
                                                <div class="icon icon-shape bg-white shadow text-center border-radius-2xl">
                                                    <i class="fa-solid fa-coins text-primary text-gradient text-lg opacity-10"
                                                        aria-hidden="true"></i>
                                                </div>
                                                <h5 class="text-white font-weight-bolder  mb-0 mt-3">
                                                    <span class="text-xs">PKR </span>{{ number_format($totalIncome) }}
                                                </h5>
                                                <span class="text-white text-sm">Income</span>
                                            </div>
                                            <div class="col-3">
                                                <div class="dropdown text-end mb-6">
                                                    <a href="javascript:;" class="cursor-pointer" id="dropdownUsers1"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="fa fa-ellipsis-h text-white"></i>
                                                    </a>
                                                    <ul class="dropdown-menu px-2 py-3" aria-labelledby="dropdownUsers1">
                                                        <li><a class="dropdown-item border-radius-md" href="javascript:;">1
                                                                month</a></li>
                                                        <li><a class="dropdown-item border-radius-md" href="javascript:;">6
                                                                months</a></li>
                                                        <li><a class="dropdown-item border-radius-md" href="javascript:;">12
                                                                months</a></li>
                                                        <li><a class="dropdown-item border-radius-md"
                                                                href="javascript:;">Overall</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-12 mt-4 mt-md-0">
                                <div class="card">
                                    <span class="mask bg-dark bg-gradient opacity-10 border-radius-lg"></span>
                                    <div class="card-body p-3 position-relative">
                                        <div class="row">
                                            <div class="col-9 text-start">
                                                <div class="icon icon-shape bg-white shadow text-center border-radius-2xl">
                                                    <i class="fa-solid fa-credit-card text-primary text-gradient text-lg opacity-10"
                                                        aria-hidden="true"></i>
                                                </div>
                                                <h5 class="text-white font-weight-bolder mb-0 mt-3">
                                                    <span class="text-xs">PKR </span> {{ number_format($totalExpense) }}
                                                </h5>
                                                <span class="text-white text-sm">Expenses</span>
                                            </div>
                                            <div class="col-3">
                                                <div class="dropdown text-end mb-6">
                                                    <a href="javascript:;" class="cursor-pointer" id="dropdownUsers1"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="fa fa-ellipsis-h text-white"></i>
                                                    </a>
                                                    <ul class="dropdown-menu px-2 py-3" aria-labelledby="dropdownUsers1">
                                                        <li><a class="dropdown-item border-radius-md"
                                                                href="javascript:;">Action</a></li>
                                                        <li><a class="dropdown-item border-radius-md"
                                                                href="javascript:;">Another action</a></li>
                                                        <li><a class="dropdown-item border-radius-md"
                                                                href="javascript:;">Something else here</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-12 mt-4 mt-md-0">
                                <div class="card">
                                    <span class="mask bg-dark bg-gradient opacity-10 border-radius-lg"></span>
                                    <div class="card-body p-3 position-relative">
                                        <div class="row">
                                            <div class="col-9 text-start">
                                                <div class="icon icon-shape bg-white shadow text-center border-radius-2xl">
                                                    <i class="fa-solid fa-money-bill text-primary text-gradient text-lg opacity-10"
                                                        aria-hidden="true"></i>
                                                </div>
                                                <h5 class="text-white font-weight-bolder mb-0 mt-3">
                                                    <span class="text-xs">PKR </span>
                                                    {{ number_format($totalIncome - $totalExpense) }}
                                                </h5>
                                                <span class="text-white text-sm">Remaining</span>
                                            </div>
                                            <div class="col-3">
                                                <div class="dropdown text-end mb-6">
                                                    <a href="javascript:;" class="cursor-pointer" id="dropdownUsers3"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="fa fa-ellipsis-h text-white"></i>
                                                    </a>
                                                    <ul class="dropdown-menu px-2 py-3" aria-labelledby="dropdownUsers3">
                                                        <li><a class="dropdown-item border-radius-md"
                                                                href="javascript:;">Action</a></li>
                                                        <li><a class="dropdown-item border-radius-md"
                                                                href="javascript:;">Another action</a></li>
                                                        <li><a class="dropdown-item border-radius-md"
                                                                href="javascript:;">Something else here</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="col-lg-12 mt-4">
                                <div class="card z-index-2">
                                    <div class="card-body p-3">
                                        <h6 class="ms-2 mb-0"> Your Accounts </h6>
                                        <p class="text-sm ms-2"> (<span class="font-weight-bolder">+23%</span>) than last
                                            week
                                        </p>
                                        <div class="container border-radius-lg">
                                            <div class="row">
                                                @foreach ($accounts as $account)
                                                    <div
                                                        class="{{ count($accounts) > 2 ? 'col-md-3' : 'col-md-6' }} col-sm-6 col-12 py-3 ps-0">
                                                        <div class="d-flex mb-2">
                                                            <div
                                                                class="icon icon-shape icon-xxs shadow border-radius-sm bg-primary bg-gradient text-center me-2 d-flex align-items-center justify-content-center">
                                                                <i class="{{ config('custom.account_types')[$account->type]['icon'] }} text-xxs opacity-10 mt-2"
                                                                    aria-hidden="true"></i>
                                                            </div>
                                                            <p class="text-xs mt-1 mb-0 font-weight-bold">
                                                                {{ $account->name }}</p>
                                                        </div>
                                                
                                                        <h5 class="font-weight-bolder"><span class="text-xs">PKR </span>
                                                            {{ number_format($account->balance) }}</h5>
                                                        <div class="progress w-75">
                                                            <div class="progress-bar bg-dark w-60" role="progressbar"
                                                                aria-valuenow="60" aria-valuemin="0" aria-valuemax="100">
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12 mt-4">
                                <div class="card z-index-2">
                                    <div class="card-body p-3">
                                        <h6 class="ms-2 mb-0"> Past 6 months Income & Expenses </h6>
                                        <p class="text-sm ms-2"> (<span class="font-weight-bolder">+23%</span>) than last
                                            week
                                        </p>
                                        <div class="bg-white border-radius-md py-3 pe-1 mb-3">
                                            <div class="chart">
                                                <canvas id="chart-bars" class="chart-canvas" height="120"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="col-lg-12 mt-4">
                                <div class="card z-index-2">
                                    <div class="card-header pb-0">
                                        <h6>Income & Expenses</h6>
                                        <div class="d-flex gap-3">
                                            <p class="text-sm">
                                                <i class="fa fa-arrow-up text-success"></i>
                                                <span class="font-weight-bold">4% more</span> in Jan
                                            </p>
                                            <p class="text-sm">
                                                <i class="fa fa-arrow-down text-danger"></i>
                                                <span class="font-weight-bold">3% less</span> in Jan
                                            </p>
                                        </div>
                                    </div>
                                    <div class="card-body p-3">
                                        <div class="chart">
                                            <canvas id="chart-line-2" class="chart-canvas" height="100"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-12 mt-4 mt-lg-0">
                        <div class="row">
                            <div class="card min-h-60">
                                <style>
                                    .min-h-60 {
                                        min-height: 370px;
                                    }
                                </style>
                                <div class="card-header pb-0">
                                    <h6 class="mb-0">Recent Transactions</h6>
                                </div>
                                <div class="card-body p-3">
                                    @foreach ($recentTransactions as $transaction)
                                        <div class="timeline timeline-one-side">
                                            <div class="timeline-block mb-3">
                                                <span class="timeline-step">
                                                    <i
                                                        class="fa fa-{{ $transaction->type == TransactionType::Expense ? 'circle-up text-danger' : 'circle-down text-success' }} text-gradient text-lg"></i>
                                                </span>
                                                <div class="timeline-content">
                                                    <div class="d-flex justify-content-between">
                                                        <h6 class="text-dark text-sm font-weight-bold mb-0"><span
                                                                class="text-xxs">PKR </span>
                                                            {{ number_format($transaction->amount) }}
                                                        </h6>
                                                        <h6 class="text-body font-weight-bold text-xs mt-1 mb-0">
                                                            {{ $transaction->category->name }}
                                                        </h6>
                                                    </div>
                                                    <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">
                                                        {{ \Carbon\Carbon::parse($transaction->transaction_date)->format('d M Y g:i A') }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <a class="text-secondary text-xs mx-auto my-3 font-weight-bold icon-move-right"
                                    href="javascript:;">
                                    see all
                                    <i class="fas fa-arrow-right text-xs ms-1" aria-hidden="true"></i>
                                </a>
                            </div>
                            <div class="card mt-4">
                                <div class="card-header pb-0">
                                    <h6>Income & Expenses</h6>
                                    <div class="d-flex gap-3">
                                        <p class="text-xs">
                                            <i class="fa fa-arrow-up text-success"></i>
                                            <span class="font-weight-bold">4% more</span> in Jan
                                        </p>
                                        <p class="text-xs">
                                            <i class="fa fa-arrow-down text-danger"></i>
                                            <span class="font-weight-bold">3% less</span> in Jan
                                        </p>
                                    </div>
                                </div>
                                <div class="card-body p-3">
                                    <div class="chart">
                                        <canvas id="chart-line" class="chart-canvas" height="160"></canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="card shadow h-100 mt-4">
                                <div class="card-header pb-0 p-3">
                                    <h6 class="mb-0">Categories Expenses</h6>
                                </div>
                                <div class="card-body pb-0 p-3">
                                    <ul class="list-group">
                                        @foreach ($categoriesProgress as $category)
                                            <li class="list-group-item border-0 d-flex align-items-center px-0 mb-2">
                                                <div class="w-100">
                                                    <div class="d-flex mb-2">
                                                        <span
                                                            class="me-2 text-sm font-weight-bold text-dark">{{ $category['name'] }}</span>
                                                        <span
                                                            class="ms-auto text-sm font-weight-bold">{{ $category['percentage'] }}%</span>
                                                    </div>
                                                    <div>
                                                        <div class="progress progress-md">
                                                            <div class="progress-bar bg-primary" role="progressbar"
                                                                style="width: {{ $category['percentage'] }}%"
                                                                aria-valuenow="{{ $category['percentage'] }}"
                                                                aria-valuemin="0" aria-valuemax="100">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                                <a class="text-secondary text-xs mx-auto my-3 font-weight-bold icon-move-right"
                                    href="/categories">
                                    see all categories
                                    <i class="fas fa-arrow-right text-xs ms-1" aria-hidden="true"></i>
                                </a>
                            </div>
                        </div>
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
        document.addEventListener("DOMContentLoaded", function() {
            window.transactionRoutes = {
                store: "{{ route('transactions.store') }}",
                update: "{{ route('transactions.update', ['transaction' => '__TRANSACTION_ID__']) }}",
                destroy: "{{ route('transactions.destroy', ['transaction' => '__TRANSACTION_ID__']) }}",
                show: "{{ route('transactions.show', ['transaction' => '__TRANSACTION_ID__']) }}"
            };

            const ctxBar = document.getElementById('chart-bars').getContext('2d');

            const monthlyData = @json($monthlyData);

            const labels = monthlyData.map(data => data.month);
            const incomes = monthlyData.map(data => data.income);
            const expenses = monthlyData.map(data => data.expense);
            console.log(monthlyData)
            new Chart(ctxBar, {
                type: 'bar',
                data: {
                    labels: labels, // Months
                    datasets: [{
                            label: 'Income',
                            data: incomes,
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1,
                        },
                        {
                            label: 'Expense',
                            data: expenses,
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 1,
                        },
                    ],
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: true,
                        },
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                        },
                    },
                },
            });


            // Line Chart
            const ctxLine = document.getElementById('chart-line').getContext('2d');
            const ctxLine2 = document.getElementById('chart-line-2').getContext('2d')

            // Get data from the controller
            const chartData = @json($chartData);

            const labelsLineGraph = chartData.labels; // X-axis labels
            const incomeDataLineGraph = chartData.income; // Income data
            const expenseDataLineGraph = chartData.expense; // Expense data

            // Create the line chart
            new Chart(ctxLine, {
                type: 'line',
                data: {
                    labels: labelsLineGraph, // X-axis labels
                    datasets: [{
                            label: 'Income',
                            data: incomeDataLineGraph,
                            borderColor: 'rgba(75, 192, 192, 1)', // Line color for income
                            backgroundColor: 'rgba(75, 192, 192, 0.2)', // Fill under the line
                            tension: 0.4, // Smooth curves
                            borderWidth: 2,
                            fill: true,
                        },
                        {
                            label: 'Expense',
                            data: expenseDataLineGraph,
                            borderColor: 'rgba(255, 99, 132, 1)', // Line color for expense
                            backgroundColor: 'rgba(255, 99, 132, 0.2)', // Fill under the line
                            tension: 0.4, // Smooth curves
                            borderWidth: 2,
                            fill: true,
                        },
                    ],
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: true, // Show legend
                        },
                    },
                    scales: {
                        y: {
                            beginAtZero: true, // Start Y-axis from 0
                        },
                    },
                },
            });


            new Chart(ctxLine2, {
                type: 'line',
                data: {
                    labels: labelsLineGraph, // X-axis labels
                    datasets: [{
                            label: 'Income',
                            data: incomeDataLineGraph,
                            borderColor: 'rgba(75, 192, 192, 1)', // Line color for income
                            tension: 0.4, // Smooth curves
                            borderWidth: 2,
                            fill: false,
                        },
                        {
                            label: 'Expense',
                            data: expenseDataLineGraph,
                            borderColor: 'rgba(255, 99, 132, 1)', // Line color for expense
                            tension: 0.4, // Smooth curves
                            borderWidth: 2,
                            fill: false,
                        },
                    ],
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: true, // Show legend
                        },
                    },
                    scales: {
                        y: {
                            beginAtZero: true, // Start Y-axis from 0
                        },
                    },
                },
            });
        });
    </script>
@endsection
