@extends('admin.layout.app')
@section('title','Office Expenses Management')
@section('body')
    <div class="row align-items-center">
        <div class="border-0 mb-4">
            <div class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
                <h3 class="fw-bold mb-0 text-white">Office Expenses Management</h3>
                <div class="col-auto d-flex w-sm-100">
                    <a href="#" data-bs-toggle="modal" data-bs-target="#expenseAdd" class="btn btn-dark btn-set-task w-sm-100"><i class="icofont-plus-circle me-2 fs-6"></i>Create New Office Expense</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Row end  -->

    <div class="row clearfix g-3">
        <div class="col-sm-12">
            <div class="card mb-3">
                <div class="card-body table-responsive export-table bg-dark-subtle">
                    <table id="basic-datatable" class="table table-bordered text-nowrap table-secondary key-buttons border-bottom w-100">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Date</th>
                            <th>Purpose</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($officeExpenses as $key => $officeExpense)
                            <tr>
                                <td>
                                    <span class="fw-bold">{{$loop->iteration}}</span>
                                </td>
                                <td>{{$officeExpense->date ?? '-'}}</td>
                                <td>{{$officeExpense->purpose ?? '-'}}</td>
                                <td>{{$officeExpense->amount ?? '-'}}</td>
                                <td> <span class="text-white {{$officeExpense->status == 1 ? 'bg-success':'bg-danger'}} p-1 rounded-3">{{$officeExpense->status == 1 ? 'Active':'Inactive'}}</span></td>
                                <td class="d-sm-flex d-grid align-items-center">
                                    <a class="m-1" href="" data-bs-toggle="modal" data-bs-target="#expenseShow{{$key}}"><i class="fa-solid btn btn-info btn-sm fa-eye m-r-5"></i></a>
                                    @if(auth()->user()->hasPermission('admin office expenses update'))
                                    <a class="m-1" href="" data-bs-toggle="modal" data-bs-target="#degedit{{$key}}"><i class="fa-solid btn btn-success btn-sm fa-pencil m-r-5"></i></a>
                                    @endif
                                    @if(auth()->user()->hasPermission('admin office expenses destroy'))
                                    <a href="" class="m-1" onclick="return confirm('are you sure to delete ?') ? document.getElementById('destroy-form-{{$key}}').submit():''">
                                        <i onclick="" class="fa-regular btn btn-danger btn-sm text-white fa-trash-can m-r-5" type="submit"></i>
                                    </a>
                                    <form class="" id="destroy-form-{{$key}}" action="{{ route('admin.office.expenses.destroy',$officeExpense->id) }}" method="post">
                                        @csrf
                                        @method('PUT')
                                    </form>
                                    @endif
                                </td>
                            </tr>
                            <!-- Edit Department-->
                            <div class="modal fade" id="degedit{{$key}}" tabindex="-1"  aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-md modal-dialog-scrollable">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title  fw-bold" id="depeditLabel"> Office Expense Edit</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="deadline-form">
                                                <form action="{{route('admin.office.expenses.update',$officeExpense->id)}}" method="post">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label for="purposeEdit" class="form-label">Purpose <span class="text-danger">*</span></label>
                                                            <input type="text" value="{{$officeExpense->purpose}}" name="purpose" class="form-control" id="purposeEdit" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="dateEdit" class="form-label">Date <span class="text-danger">*</span></label>
                                                            <input type="date" value="{{$officeExpense->date}}" name="date" class="form-control" id="dateEdit" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="amountEdit" class="form-label">Amount <span class="text-danger">*</span></label>
                                                            <input type="number" value="{{$officeExpense->amount}}" name="amount" class="form-control" id="amountEdit" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="remarksEdit" class="form-label">Remarks <span class="text-danger">*</span></label>
                                                            <textarea class="form-control" name="remarks" id="remarksEdit" cols="30" rows="4">{{$officeExpense->remarks}}</textarea>
                                                        </div>
                                                        <div class="deadline-form">
                                                            <div class="row g-3 mb-3">
                                                                <div class="col-sm-6">
                                                                    <label for="payment_type_edit" class="form-label">Payment Type <span class="text-danger">*</span></label>
                                                                    <select class="form-control" name="payment_type" id="payment_type_edit" required>
                                                                        <option disabled value="">select one</option>
                                                                        <option {{ $officeExpense->payment_type == 'Cash' ? 'selected':''}}  value="Cash">Cash</option>
                                                                        <option {{ $officeExpense->payment_type == 'Bank' ? 'selected':''}}  value="Bank">Bank</option>
                                                                        <option {{ $officeExpense->payment_type == 'Mfs' ? 'selected':''}}  value="Mfs">Mfs</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <label for="statusEdit" class="form-label">Status</label>
                                                                    <select class="form-control" name="status" id="statusEdit">
                                                                        <option {{$officeExpense->status == 1 ? 'selected':''}} value="1">Active</option>
                                                                        <option {{$officeExpense->status == 0 ? 'selected':''}} value="0">Inactive</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-primary">Submit</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="expenseShow{{$key}}" tabindex="-1"  aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-md modal-dialog-scrollable">
                                    <div class="modal-content bg-black-subtle">
                                        <div class="modal-header ">
                                            <h5 class="modal-title text-center fw-bold" id="depaddLabel"> {{ ucwords(str_replace('_',' ',$officeExpense->purpose))}} </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row px-2 border-0 fw-bold ">
                                                <div class="col-4"><label for="asset_name" class="form-label">Purpose </label></div>
                                                <div class="col-2">:</div>
                                                <div class="col-6"><p class="">{{ ucwords(str_replace('_',' ',$officeExpense->purpose))}}</p></div>
                                            </div>
                                            <div class="row px-2 border-0 fw-bold">
                                                <div class="col-4"><label for="asset_model" class="form-label">Date </label></div>
                                                <div class="col-2">:</div>
                                                <div class="col-6"><p class="">{{$officeExpense->date}}</p></div>
                                            </div>
                                            <div class="row px-2 border-0 fw-bold">
                                                <div class="col-4"><label for="asset_model" class="form-label">Amount </label></div>
                                                <div class="col-2">:</div>
                                                <div class="col-6"><p class="">৳ {{$officeExpense->amount}}</p></div>
                                            </div>
                                            <div class="row px-2 border-0 fw-bold">
                                                <div class="col-4"><label for="asset_model" class="form-label">Payment Type </label></div>
                                                <div class="col-2">:</div>
                                                <div class="col-6"><p class="">{{$officeExpense->payment_type}}</p></div>
                                            </div>
                                            <div class="row px-2">
                                                <div class="col-4"><label for="description" class="form-label fw-bold">Remarks</label></div>
                                                <div class="col-2">:</div>
                                                <div class="col-6"><p class="">{{$officeExpense->remarks ?? '-'}}</p></div>
                                            </div>
                                            <div class="row px-2  fw-bold ">
                                                <div class="col-4"><label for="description" class="form-label">Status</label></div>
                                                <div class="col-2">:</div>
                                                <div class="col-6">
                                                    <p class=""><span style="" class="text-white p-1 me-1 rounded-2 {{ $officeExpense->status == 1 ? 'bg-success':'bg-danger'}}">{{ $officeExpense->status == 1 ? 'Active':'Inactive'}}</span></p>
                                                </div>
                                            </div>
                                            <div class="row px-2  fw-bold ">
                                                <div class="col-4"><label for="description" class="form-label">Created By</label></div>
                                                <div class="col-2">:</div>
                                                <div class="col-6">
                                                    <p class=""><span style="" class="">{{ $officeExpense->user->name }} ({{ $officeExpense->user->userInfo->employee_id }})</span></p>
                                                </div>
                                            </div>
                                            <div class="row px-2  fw-bold ">
                                                <div class="col-4"><label for="description" class="form-label">Created At</label></div>
                                                <div class="col-2">:</div>
                                                <div class="col-6">
                                                    <p class=""><span style="" class="">{{ \Illuminate\Support\Carbon::parse($officeExpense->created_at)->format('d M, Y h:i:s A') }}</span></p>
                                                </div>
                                            </div>
                                            <div class="row px-2  fw-bold ">
                                                <div class="col-4"><label for="description" class="form-label">Last Update </label></div>
                                                <div class="col-2">:</div>
                                                <div class="col-6">
                                                    <p class=""><span style="" class="">{{ \Illuminate\Support\Carbon::parse($officeExpense->updated_at)->format('d M, Y h:i:s A') }}</span></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="text-white my-3 d-grid justify-content-center">
                        {{$officeExpenses->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Row End -->

    <!-- Add Designation-->
    <div class="modal fade" id="expenseAdd" tabindex="-1"  aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title  fw-bold" id="depaddLabel"> New Office Expense </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{route('admin.office.expenses.store')}}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="purposeEdit" class="form-label">Purpose <span class="text-danger">*</span></label>
                            <input type="text" value="{{old('purpose')}}" name="purpose" class="form-control" id="purposeEdit" required>
                        </div>
                        <div class="mb-3">
                            <label for="dateEdit" class="form-label">Date <span class="text-danger">*</span></label>
                            <input type="date" value="{{old('date')}}" name="date" class="form-control" id="dateEdit" required>
                        </div>
                        <div class="mb-3">
                            <label for="amountEdit" class="form-label">Amount <span class="text-danger">*</span></label>
                            <input type="number" value="{{old('amount')}}" name="amount" class="form-control" id="amountEdit" required>
                        </div>
                        <div class="mb-3">
                            <label for="remarksEdit" class="form-label">Remarks</label>
                            <textarea class="form-control" name="remarks" id="remarksEdit" cols="30" rows="4">{{old('remarks')}}</textarea>
                        </div>
                        <div class="deadline-form">
                            <div class="row g-3 mb-3">
                                <div class="col-sm-6">
                                    <label for="payment_type_edit" class="form-label">Payment Type <span class="text-danger">*</span></label>
                                    <select class="form-control" name="payment_type" id="payment_type_edit" required>
                                        <option disabled value="">select one</option>
                                        <option {{ old('payment_type') == 'Cash' ? 'selected':''}}  value="Cash">Cash</option>
                                        <option {{ old('payment_type') == 'Bank' ? 'selected':''}}  value="Bank">Bank</option>
                                        <option {{ old('payment_type') == 'Mfs' ? 'selected':''}}  value="Mfs">Mfs</option>
                                    </select>
                                </div>
                                <div class="col-sm-6">
                                    <label for="statusEdit" class="form-label">Status</label>
                                    <select class="form-control" name="status" id="statusEdit">
                                        <option {{ old('status') == 1 ? 'selected':''}} value="1">Active</option>
                                        <option {{ old('status') == 0 ? 'selected':''}} value="0">Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Row End -->

@endsection



