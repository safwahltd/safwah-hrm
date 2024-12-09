@extends('admin.layout.app')
@section('title','Holidays')
@section('body')
    <div class="row align-items-center">
        <div class="border-0 mb-4">
            <div class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
                <h3 class="fw-bold mb-0 text-white">Holiday</h3>
                <div class="col-md-2 col-3 text-center d-flex">
                    <form action="{{route('employee.holiday.index')}}" class="w-100" method="get">
                        <select name="type" id="" class="w-100 text-center" style="width: 100%;" onchange="this.form.submit()">
                            <option {{$type == 'all' ? 'selected' : ''}} value="all">All</option>
                            <option {{$type == 'left' ? 'selected' : ''}} value="left">Left</option>
                        </select>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Row end  -->

    <div class="row clearfix g-3">
        <div class="col-sm-12">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="table-responsive export-table">
                        <table id="basic-datatable" class="table table-hover table-striped align-middle mb-0" style="width:100%">
                            <thead class="bg-primary">
                            <tr class="bg-secondary">
                                <th class="bg-primary-subtle">SL</th>
                                <th  class="bg-primary-subtle">Name</th>
                                <th  class="bg-primary-subtle">From</th>
                                <th  class="bg-primary-subtle">To</th>
                                <th  class="bg-primary-subtle">Total</th>
                                <th  class="bg-primary-subtle">Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($holidays as $key => $holiday)
                                <tr>
                                    <td><span class="fw-bold">{{$loop->iteration}}</span></td>
                                    <td>{{$holiday->name}}</td>
                                    <td>{{ \Illuminate\Support\Carbon::parse($holiday->date_from)->format('d M,  Y') }}</td>
                                    <td>{{ \Illuminate\Support\Carbon::parse($holiday->date_to)->format('d M,  Y') }}</td>
                                    <td>{{ $holiday->total_day }} {{$holiday->total_day <= 1 ? 'day':'days'}}</td>
                                    <td><span class="p-1 px-3 rounded-2 text-white {{ $holiday->date_to > \Illuminate\Support\Carbon::now() ? 'bg-success' : 'bg-danger' }}">{{ $holiday->date_to > \Illuminate\Support\Carbon::now() ? 'In Coming' : 'Passed' }}</span></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center"><span class="fw-bold">No Result</span></td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- Row End -->
@endsection

