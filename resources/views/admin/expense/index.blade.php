@extends('admin.layout.app')
@section('title','Money Receipts Management')
@section('body')
    <div class="row align-items-center">
        <div class="border-0 mb-4">
            <div class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
                <h3 class="fw-bold mb-0 text-white">Money Receipts Management</h3>
                <div class="col-auto d-flex w-sm-100">
                    <a href="{{route('admin.expense.create')}}" class="btn btn-dark btn-set-task w-sm-100"><i class="icofont-plus-circle me-2 fs-6"></i>Create New Money Receipt</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Row end  -->

    <div class="row clearfix justify-content-center g-3">
        <div class="col-sm-12">
            <div class="card p-2">
                <div class="table-responsive" id="assetTable">
                    <table id="basic-datatable" class="table table-striped table-bordered mb-0">
                        <thead>
                        <tr>
                            <th>SL</th>
                            <th>Receipt No</th>
                            <th>Receipt Type</th>
                            <th>Date</th>
                            <th>User</th>
                            <th>Status</th>
                            <th>Amount</th>
                            <th class="text-center">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($expenses as $key => $expense)
                            <tr style="font-size: 12px">
                                <td>{{$loop->iteration}}</td>
                                <td>RC- {{$expense->receipt_no}}</td>
                                <td>{{ ucwords(str_replace('_',' ',$expense->receipt_type))}}</td>
                                <td>{{$expense->date}}</td>
                                <td>{{$expense->user->name}} <sub>({{$expense->user->userInfo->employee_id}})</sub> </td>
                                <td>
                                    <span style="background-color: {{ $expense->status == 0 ? '#9e7c50':''}}{{ $expense->status == 1 ? '#5BC43A':''}}{{ $expense->status == 2 ? 'red':''}}; " class="text-white px-1 mx-1 rounded-2">{{ $expense->status == 0 ? 'Pending':''}}{{ $expense->status == 1 ? 'Accepted':''}}{{ $expense->status == 2 ? 'Rejected':''}} </span>
                                @if($expense->checked_by != null)
                                    <span class="bg-success text-white px-1 mx-1 rounded-2">{{ $expense->checked_by != null ? 'Checked':''}} </span>
                                    @endif
                                    @if($expense->approved_by != null)
                                    <span class="bg-primary text-white px-1 mx-1 rounded-2">{{ $expense->approved_by != null ? 'Approved':''}} </span>
                                    @endif
                                    @if($expense->received_by != null)
                                    <span class="bg-success text-white mx-1 px-1 rounded-2">{{ $expense->received_by != null ? 'Received':''}} </span>
                                    @endif
                                </td>
                                <td align="center">{{ $expense->amount }} /-</td>
                                <td class="d-sm-flex d-grid align-items-center">
                                    <a class="m-1" href="#" data-bs-toggle="modal" data-bs-target="#show_asset{{$key}}"><i class="fa-solid btn btn-primary text-white btn-sm fa-eye m-r-5"></i></a>
                                    <a class="m-1" href="{{route('admin.expense.edit',$expense->id)}}"><i class="fa-solid btn btn-success btn-sm text-white fa-pencil m-r-5"></i></a>
                                    <a href="#" class="m-1" onclick="return confirm('are you sure to delete ?') ? document.getElementById('destroy-form-{{$key}}').submit():''">
                                        <i onclick="" class="fa-regular btn btn-danger btn-sm text-white fa-trash-can m-r-5" type="submit"></i>
                                    </a>
                                    <form class="" id="destroy-form-{{$key}}" action="{{route('admin.expense.destroy',$expense->id)}}" method="post">
                                        @csrf
                                        @method('PUT')
                                    </form>
                                    <a target="_blank" class="m-1" href="{{route('admin.expense.download',$expense->id)}}"><i class="fa-solid btn text-white btn-info btn-sm fa-print"></i></a>
                                </td>
                            </tr>
                            <!-- Show Asset Modal-->
                            <div class="modal fade " id="show_asset{{$key}}" tabindex="-1"  aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content bg-black-subtle">
                                        <div class="modal-header ">
                                            <h5 class="modal-title text-center fw-bold" id="depaddLabel"> {{ ucwords(str_replace('_',' ',$expense->receipt_type))}} {{ $expense->receipt_no}} </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row px-2 border-0 fw-bold ">
                                                <div class="col-4"><label for="asset_name" class="form-label">Receipt Type </label></div>
                                                <div class="col-2">:</div>
                                                <div class="col-6"><p class="">{{ ucwords(str_replace('_',' ',$expense->receipt_type))}}</p></div>
                                            </div>
                                            <div class="row px-2 border-0 fw-bold ">
                                                <div class="col-4"><label for="asset_model" class="form-label">Receipt No </label></div>
                                                <div class="col-2">:</div>
                                                <div class="col-6"><p class="">{{$expense->receipt_no}}</p></div>
                                            </div>
                                            <div class="row px-2 border-0 fw-bold ">
                                                <div class="col-4"><label for="asset_id" class="form-label">Date </label></div>
                                                <div class="col-2">:</div>
                                                <div class="col-6"><p class="">{{$expense->date}}</p></div>
                                            </div>
                                            <div class="row px-2  fw-bold ">
                                                <div class="col-4"><label for="asset_id" class="form-label">Name</label></div>
                                                <div class="col-2">:</div>
                                                <div class="col-6"><p class="">{{$expense->user->name}} (<small>{{$expense->user->userInfo->employee_id}}</small>)</p></div>
                                            </div>
                                            @if($expense->receipt_type == 'advance_money_receipt')
                                            <div class="row px-2  fw-bold ">
                                                <div class="col-4"><label for="purchase_date" class="form-label">Advance Payment Type</label></div>
                                                <div class="col-2">:</div>
                                                <div class="col-6"><p class="">{{ ucwords($expense->advance_payment_type)}}</p></div>
                                            </div>
                                            @endif
                                            @if($expense->receipt_type == 'money_receipt')
                                                <div class="row px-2  fw-bold ">
                                                    <div class="col-4"><label for="purchase_date" class="form-label">Money Payment Type</label></div>
                                                    <div class="col-2">:</div>
                                                    <div class="col-6"><p class="">{{ucwords($expense->money_payment_type)}}</p></div>
                                                </div>
                                                @if($expense->money_payment_type == 'cheque')
                                                <div class="row px-2  fw-bold">
                                                    <div class="col-4"><label for="purchase_date" class="form-label">Cheque No</label></div>
                                                    <div class="col-2">:</div>
                                                    <div class="col-6"><p class="">{{$expense->cheque_no ?? 'N/A'}}</p></div>
                                                </div>
                                                <div class="row px-2  fw-bold ">
                                                    <div class="col-4"><label for="purchase_date" class="form-label">Cheque Bank</label></div>
                                                    <div class="col-2">:</div>
                                                    <div class="col-6"><p class="">{{$expense->cheque_bank ?? 'N/A'}}</p></div>
                                                </div>
                                                <div class="row px-2  fw-bold ">
                                                    <div class="col-4"><label for="purchase_date" class="form-label">Cheque Date</label></div>
                                                    <div class="col-2">:</div>
                                                    <div class="col-6"><p class="">{{$expense->cheque_date ?? 'N/A'}}</p></div>
                                                </div>
                                                @endif
                                                @if($expense->money_payment_type == 'mfs')
                                                <div class="row px-2  fw-bold ">
                                                    <div class="col-4"><label for="purchase_date" class="form-label">MFS Sender No</label></div>
                                                    <div class="col-2">:</div>
                                                    <div class="col-6"><p class="">{{$expense->mfs_sender_no ?? 'N/A'}}</p></div>
                                                </div>
                                                <div class="row px-2  fw-bold ">
                                                    <div class="col-4"><label for="purchase_date" class="form-label">MFS Receiver No</label></div>
                                                    <div class="col-2">:</div>
                                                    <div class="col-6"><p class="">{{$expense->mfs_receiver_no ?? 'N/A'}}</p></div>
                                                </div>
                                                <div class="row px-2  fw-bold ">
                                                    <div class="col-4"><label for="purchase_date" class="form-label">MFS Transaction No</label></div>
                                                    <div class="col-2">:</div>
                                                    <div class="col-6"><p class="">{{$expense->mfs_transaction_no ?? 'N/A'}}</p></div>
                                                </div>
                                                @endif
                                                @if($expense->money_payment_type == 'others')
                                                <div class="row px-2  fw-bold ">
                                                    <div class="col-4"><label for="purchase_date" class="form-label">Others</label></div>
                                                    <div class="col-2">:</div>
                                                    <div class="col-6"><p class="">{{$expense->others ?? 'N/A'}}</p></div>
                                                </div>
                                                @endif
                                                <div class="row px-2  fw-bold ">
                                                    <div class="col-4"><label for="purchase_date" class="form-label">Adjusted Receipt No</label></div>
                                                    <div class="col-2">:</div>
                                                    <div class="col-6"><p class="">{{$expense->adjusted_receipt_no ?? '-'}}</p></div>
                                                </div>
                                            @endif
                                            <div class="row px-2">
                                                <div class="col-4"><label for="description" class="form-label fw-bold">Reason</label></div>
                                                <div class="col-2">:</div>
                                                <div class="col-6"><p class="">{{$expense->reason ?? '-'}}</p></div>
                                            </div>
                                            <div class="row px-2  fw-bold ">
                                                <div class="col-4"><label for="description" class="form-label">Amount</label></div>
                                                <div class="col-2">:</div>
                                                <div class="col-6"><p class="">৳ {{$expense->amount ?? 0}}</p></div>
                                            </div>
                                            @if($expense->receipt_type == 'money_receipt')
                                            <div class="row px-2  fw-bold ">
                                                <div class="col-4"><label for="description" class="form-label">Payment</label></div>
                                                <div class="col-2">:</div>
                                                <div class="col-6"><p class="">৳ {{$expense->payment ?? 0}}</p></div>
                                            </div>
                                            <div class="row px-2  fw-bold ">
                                                <div class="col-4"><label for="description" class="form-label">Due</label></div>
                                                <div class="col-2">:</div>
                                                <div class="col-6"><p class="">৳ {{$expense->due ?? 0}}</p></div>
                                            </div>
                                                <div class="row px-2  fw-bold ">
                                                    <div class="col-4"><label for="description" class="form-label">Recieved By</label></div>
                                                    <div class="col-2">:</div>
                                                    <div class="col-6"><p class="">{{ $expense->receivedBy->name ?? 'Not Received Yet' }} {{ $expense->received_date ?? ''}}</p></div>
                                                </div>
                                            @endif
                                            @if($expense->receipt_type == 'advance_money_receipt')
                                                <div class="row px-2  fw-bold ">
                                                    <div class="col-4"><label for="description" class="form-label">Checked By</label></div>
                                                    <div class="col-2">:</div>
                                                    <div class="col-6"><p class="">{{ $expense->checkedBy->name ?? 'Not Checked Yet' }} {{ $expense->checked_date ?? ''}}</p></div>
                                                </div>
                                                <div class="row px-2  fw-bold ">
                                                    <div class="col-4"><label for="description" class="form-label">Approved By</label></div>
                                                    <div class="col-2">:</div>
                                                    <div class="col-6"><p class="">{{ $expense->approvedBy->name ?? 'Not Approved Yet' }} {{ $expense->approved_date ?? ''}}</p></div>
                                                </div>
                                            @endif
                                            <div class="row px-2  fw-bold ">
                                                <div class="col-4"><label for="description" class="form-label">Status</label></div>
                                                <div class="col-2">:</div>
                                                <div class="col-6">
                                                    <p class=""><span style="background-color: {{ $expense->status == 0 ? '#9e7c50':''}}{{ $expense->status == 1 ? '#5BC43A':''}}{{ $expense->status == 2 ? 'red':''}}; " class="text-white p-1 me-1 rounded-2">{{ $expense->status == 0 ? 'Pending':''}}{{ $expense->status == 1 ? 'Accepted':''}}{{ $expense->status == 2 ? 'Rejected':''}} </span></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Row End -->

@endsection


