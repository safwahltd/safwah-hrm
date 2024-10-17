@extends('admin.layout.app')
@section('title','Leave Report')
@section('body')
    <style>
        table {
            width: 100%;
        }

        th, td {
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        .td {
            max-width: 300px;
        }
        label {
            display: inline-block;
            padding-bottom: 10px;
        }
    </style>
    <div class="row align-items-center">
        <div class="border-0 mb-4">
            <div class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
                <h3 class="fw-bold text-white mb-0">Leave Report</h3>
            </div>
        </div>
    </div>
    <!-- Row end  -->

    <div class="row clearfix g-3">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="panel panel-primary">
                            <div class="tab-menu-heading border-bottom-0 my-2">
                                <div class="tabs-menu4 border-bottomo-sm">
                                    <!-- Tabs -->
                                    <nav class="nav d-sm-flex d-block">
                                        <a class="nav-link border border-bottom-0 br-sm-5 me-2 active" data-bs-toggle="tab" href="#full">
                                            Full Day
                                        </a>
                                        <a class="nav-link border border-bottom-0 br-sm-5 me-2" data-bs-toggle="tab" href="#half">
                                            Half Day
                                        </a>
                                    </nav>
                                </div>
                            </div>
                            <div class="panel-body tabs-menu-body">
                                <div class="tab-content">
                                    <div class="tab-pane active table-responsive export-table bg-dark-subtle" id="full">

                                            <table id="file-datatable" class="table table-bordered text-nowrap table-secondary key-buttons border-bottom w-100">
                                                <div class="">
                                                    <h5 class="text-center bg-primary py-1 text-white fw-bold">FULL DAY REPORT</h5>
                                                </div>
                                            <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Name <sub>(Id)</sub></th>
                                                <th>Sick Leave</th>
                                                <th>Casual Leave</th>
                                                <th>Total <sub>(Sick Leave & Casual Leave)</sub></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($users as $key => $user)
                                                <tr>
                                                    <td><span class="fw-bold">{{$loop->iteration}}</span></td>
                                                    <td class="fw-bold">{{$user->name}} <sub>({{$user->userInfo->employee_id}})</sub></td>
                                                    @php
                                                        $currentYear = \Illuminate\Support\Carbon::now()->year;
                                                            $sickLeave = \App\Models\Leave::where('user_id', $user->id)
                                                            ->whereIn('leave_type', ['sick'])
                                                            ->where('status',1)
                                                            ->whereYear('created_at', $currentYear)
                                                            ->count();
                                                    @endphp
                                                    <td>
                                                        <span class="fw-bold text-success">Available : 10 </span><br>
                                                        <span class="fw-bold text-danger">Spent : {{ $sickLeave }}</span><br>
                                                        <span class="fw-bold text-primary">Left : {{ 10 - $sickLeave }}</span>
                                                    </td>

                                                    @php
                                                        $casualLeave = \App\Models\Leave::where('user_id', $user->id)
                                                        ->whereIn('leave_type', ['casual'])
                                                        ->where('status',1)
                                                        ->whereYear('created_at', $currentYear)
                                                        ->count();
                                                    @endphp
                                                    <td>
                                                        <span class="fw-bold text-success">Available : 10 </span><br>
                                                        <span class="fw-bold text-danger">Spent : {{ $casualLeave }}</span><br>
                                                        <span class="fw-bold text-primary">Left : {{ 10 - $casualLeave }}</span>
                                                    </td>
                                                    <td>
                                                        <span class="fw-bold text-success">Available : 20 </span><br>
                                                        <span class="fw-bold text-danger">Spent : {{ $total = $casualLeave + $sickLeave }}</span><br>
                                                        <span class="fw-bold text-primary">Left : {{ (10 + 10) - $total }}</span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                        <div class="text-white my-3 d-grid justify-content-center">
                                            {{$users->links()}}
                                        </div>
                                    </div>
                                    <div class="tab-pane table-responsive export-table bg-dark-subtle" id="half">
                                        <table id="example3" class="table table-bordered text-nowrap table-secondary key-buttons border-bottom w-100">
                                            <div class="">
                                                <h5 class="text-center bg-primary py-1 text-white fw-bold">HALF DAY REPORT</h5>
                                            </div>
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Name <sub>(Id)</sub></th>
                                                    @foreach (range(1, 12) as $month)
                                                        <th class="col-3">{{ \Carbon\Carbon::create()->month($month)->format('F') }}</th>
                                                    @endforeach
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            @foreach ($report as $userData)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td class="fw-bold">{{ $userData['name'] }} <sub>({{$userData['id']}})</sub></td>
                                                    @php($total = 0)
                                                    @foreach ($userData['half_day'] as $month => $count)
                                                        <td class="col-3 p-2" style="max-width: 250px">
                                                            <span class="fw-bold text-success">T : 2</span><br>
                                                            <span class="fw-bold text-danger">S : {{ $count }}</span><br>
                                                            <span class="fw-bold text-primary">L : {{ 2 - $count }}</span>
                                                        </td>
                                                        <p hidden>{{$total = $total + $count}}</p>
                                                    @endforeach
                                                    <td>
                                                        <span class="fw-bold text-success">T : 24</span><br>
                                                        <span class="fw-bold text-danger">S : {{ $total }}</span><br>
                                                        <span class="fw-bold text-primary">L : {{ 24 - $total }}</span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                        <div class="text-white my-3 d-grid justify-content-center">
                                            {{$users->links()}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
