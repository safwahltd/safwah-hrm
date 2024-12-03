@extends('admin.layout.app')
@section('title','Edit Expense')
@section('body')
    <style>
        .input-groups {
            display: none; /* Hide all input groups by default */
        }
        .cheque_group {
            display: none; /* Hide all input groups by default */
        }
        .mfs_group {
            display: none; /* Hide all input groups by default */
        }
        .others_group {
            display: none; /* Hide all input groups by default */
        }
        .time_group {
            display: none; /* Hide all input groups by default */
        }
    </style>
    <div class="row align-items-center">
        <div class="border-0 mb-4">
            <div class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
                <h3 class="fw-bold mb-0 text-white">Update Expense</h3>
                <div class="col-auto d-flex w-sm-100">
                    <a href="{{route('admin.expense.index')}}" class="btn btn-dark btn-set-task w-sm-100"><i class="icofont-list me-2 fs-6"></i>All Expenses</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Row end  -->

    <div class="row clearfix justify-content-center g-3">
        <div class="col-sm-12">
            <div class="card mb-3">
                <div class="card-body export-table bg-dark-subtle">
                    <div class="">
                        <p class="fw-bold" align="right">Receipt No : {{ $expense->receipt_no }}</p>
                    </div>
                    <form action="{{ route('admin.expense.update',$expense->id) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="receipt_no" class="form-label">Receipt No <span class="text-danger">*</span></label>
                                    <input type="text" value="{{$expense->receipt_no}}" name="receipt_no" class="form-control" id="receipt_no" required>
                                </div>
                                <div class="mb-3">
                                    <label for="leave_type_idAdd" class="form-label">Receipt Type <span class="text-danger">*</span></label>
                                    <p class="form-control">{{ ucwords(str_replace('_',' ',$expense->receipt_type))}}</p>
                                </div>
                                <div class="mb-3">
                                    <label for="date" class="form-label">Date <span class="text-danger">*</span></label>
                                    <input type="date" value="{{$expense->date}}" name="date" class="form-control" id="date" required>
                                </div>
                                <div class="mb-3">
                                    <label for="user_id" class="form-label">User <span class="text-danger">*</span></label>
                                    <select class="form-control select2-example"  name="user_id" id="user_id" required>
                                        @foreach($users as $user)
                                            <option {{ $expense->user_id == $user->id ? 'selected':'' }} value="{{ $user->id }}">{{ $user->name }} <sub>({{ $user->userInfo->employee_id }})</sub></option>
                                        @endforeach
                                    </select>
                                </div>
                                {{--Advance Money Receipt--}}
                                <div class="mb-3 date_group {{$expense->receipt_type == 'advance_money_receipt' ? '':'input-groups'}}">
                                    <label for="payment_type" class="form-label">Payment Type </label>
                                    <select class="form-control"  name="advance_payment_type" id="payment_type">
                                        <option  {{ $expense->advance_payment_type == 'cash' ? 'selected':'' }} value="cash">CASH</option>
                                        <option  {{ $expense->advance_payment_type == 'bank' ? 'selected':'' }} value="bank">BANK</option>
                                        <option  {{ $expense->advance_payment_type == 'mfs' ? 'selected':'' }} value="mfs">MFS</option>
                                    </select>
                                </div>
                                {{-- Money Receipt --}}
                                <div class="mb-3  {{$expense->receipt_type == 'money_receipt' ? '':'time_group'}} ">
                                    <label for="money_payment_typeAdd" class="form-label"> Payment Type <span class="text-danger"> * </span></label>
                                    <p class="form-control">{{ ucwords(str_replace('_',' ',$expense->money_payment_type))}}</p>
                                </div>
                                {{--Cheque --}}
                                <div class="mb-3 {{$expense->money_payment_type == 'cheque' ? '':'cheque_group'}}">
                                    <label for="cheque_noAdd" class="form-label"> Cheque No </label>
                                    <input class="form-control" type="text" name="cheque_no" value="{{$expense->cheque_no}}" id="cheque_noAdd">
                                </div>
                                <div class="mb-3 {{$expense->money_payment_type == 'cheque' ? '':'cheque_group'}}">
                                    <label for="end_timeAdd" class="form-label"> Bank </label>
                                    <input class="form-control" type="text" name="cheque_bank" value="{{$expense->cheque_bank}}" id="cheque_bankAdd">
                                </div>
                                <div class="mb-3 {{$expense->money_payment_type == 'cheque' ? '':'cheque_group'}} ">
                                    <label for="cheque_dateAdd" class="form-label"> Cheque Date </label>
                                    <input class="form-control" type="date" name="cheque_date" value="{{$expense->cheque_date}}" id="cheque_dateAdd">
                                </div>
                                {{-- MFS --}}
                                <div class="mb-3 {{$expense->money_payment_type == 'mfs' ? '':'mfs_group'}}">
                                    <label for="mfs_sender_noAdd" class="form-label"> Sender No </label>
                                    <input class="form-control" type="text" name="mfs_sender_no" value="{{ $expense->mfs_sender_no }}" id="mfs_sender_noAdd">
                                </div>
                                <div class="mb-3 {{$expense->money_payment_type == 'mfs' ? '':'mfs_group'}} ">
                                    <label for="mfs_receiver_noAdd" class="form-label"> Receiver No </label>
                                    <input class="form-control" type="text" name="mfs_receiver_no" value="{{$expense->mfs_receiver_no}}" id="mfs_receiver_noAdd">
                                </div>
                                <div class="mb-3 {{$expense->money_payment_type == 'mfs' ? '':'mfs_group'}}">
                                    <label for="mfs_transaction_noAdd" class="form-label"> Transaction No </label>
                                    <input class="form-control" type="text" name="mfs_transaction_no" value="{{ $expense->mfs_transaction_no }}" id="mfs_transaction_noAdd">
                                </div>
                                {{-- Others --}}
                                <div class="mb-3  {{$expense->money_payment_type == 'others' ? '':'others_group'}}">
                                    <label for="othersAdd" class="form-label"> Others </label>
                                    <input class="form-control" type="text" name="others" value="{{ $expense->others }}" id="others">
                                </div>
                            </div>
                            <div class="col-md-6">
                                {{-- End Money Receipt --}}
                                <div class="mb-3  {{$expense->receipt_type == 'money_receipt' ? '':'time_group'}}">
                                    <label for="adjusted_receipt_no" class="form-label">Adjusted Receipt No ? <span class="text-muted">(optional)</span> </label>
                                    <select style="width: 100%" class="form-control select2-example adjusted_receipt_no" name="adjusted_receipt_no" id="adjusted_receipt_noAdd">
                                        <option value="" disabled selected> Select Receipt No </option>
                                        @foreach($receipts as $receipt)
                                            <option {{ $expense->adjusted_receipt_no == $receipt->receipt_no ? 'selected':''}} value="{{ $receipt->receipt_no }}">{{ $receipt->receipt_no }} ({{ $receipt->date }})</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="amount" class="form-label">Amount <span class="text-danger">*</span></label>
                                    <input type="number" name="amount" min="0" class="form-control" id="amount" value="{{$expense->amount}}">
                                </div>
                                <div class="mb-3  {{$expense->receipt_type == 'money_receipt' ? '':'time_group'}}">
                                    <label for="payment" class="form-label">Payment <span class="text-danger">*</span></label>
                                    <input type="number" name="payment" min="0" class="form-control" id="payment" value="{{$expense->payment}}" >
                                </div>
                                <div class="mb-3  {{$expense->receipt_type == 'money_receipt' ? '':'time_group'}}">
                                    <label for="due" class="form-label">Due <span class="text-danger">*</span></label>
                                    <input type="number" name="due" min="0" class="form-control" id="due" value="{{$expense->due}}" >
                                </div>
                                <div class="mb-3">
                                    <label for="reason" class="form-label">Reason <span class="text-danger">*</span></label>
                                    <textarea class="form-control" name="reason" id="reason" cols="30" rows="6" required> {{ $expense->reason }}</textarea>
                                </div>

                                @if($expense->receipt_type == 'advance_money_receipt')
                                    <div class="mb-3">
                                        <label for="reason" class="form-label">Checked By </label>
                                        @if($expense->checked_by == null)
                                            <input type="checkbox" name="checked_by" id="checked_by" style="width: 50px;" value="{{ auth()->user()->id }}">
                                        @endif
                                        <p class="form-control">{{ $expense->checkedBy->name ?? 'Not Checked Yet' }} {{ $expense->checked_date ?? ''}}</p>
                                    </div>
                                <div class="mb-3">
                                    <label for="reason" class="form-label">Approved By </label>
                                    @if($expense->approved_by == null)
                                        <input type="checkbox" name="approved_by" id="approved_by" style="width: 50px;" value="{{ auth()->user()->id }}">
                                    @endif
                                    <p class="form-control">{{ $expense->approvedBy->name ?? 'Not Approved Yet' }} {{ $expense->approved_date ?? ''}}</p>
                                </div>
                                @endif
                                @if($expense->receipt_type == 'money_receipt')
                                <div class="mb-3">
                                    <label for="reason" class="form-label">Received By </label>
                                    @if($expense->received_by == null)
                                        <input type="checkbox" name="received_by" id="received_by" style="width: 50px;" value="{{ auth()->user()->id }}">
                                    @endif
                                    <p class="form-control">{{ $expense->receivedBy->name ?? 'Not Received Yet' }} @if($expense->received_by != null ) {{ $expense->receivedBy->userInfo->employee_id ?? '' }}) @endif {{ $expense->received_date ?? ''}}</p>
                                </div>
                                @endif
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status </label>
                                    <select style="width: 100%" class="form-control" name="status" id="status">
                                        <option {{$expense->status == 0 ? 'selected':''}} {{ $expense->received_by != null ? 'disabled':''}} {{ $expense->approved_by != null ? 'disabled':''}} {{$expense->status == 1 ? 'disabled':''}}  {{$expense->status == 2 ? 'disabled':''}} value="0"> Pending </option>
                                        <option {{$expense->status == 1 ? 'selected':''}} value="1"> Accepted </option>
                                        <option {{$expense->status == 2 ? 'selected':''}} {{ $expense->received_by != null ? 'disabled':''}} {{ $expense->approved_by != null ? 'disabled':''}} value="2"> Rejected </option>
                                    </select>

                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Row End -->

@endsection

@push('js')
    <script>
        $(document).ready(function() {
            $('.receipt_type').change(function() {
                var leaveType = $(this).val();
                $('.input-groups').hide();
                if (leaveType === 'advance_money_receipt') {
                    $('.cheque_group').hide();
                    $('.mfs_group').hide();
                    $('.others_group').hide();
                    $('.time_group').hide();
                    $('.date_group').show();
                } else if (leaveType === 'money_receipt') {
                    $('.time_group').show();
                }
            });

            $('.receipt_edit_type').change(function() {
                var leaveType = $(this).val();
                var leaveId = $(this).data('id');
                $('.input-groups').hide();
                if (leaveType === 'advance_money_receipt') {
                    $('.date_group_edit.leaveId').show();
                } else if (leaveType === 'money_receipt') {
                    $('.time_group.leaveId').show();
                }
            });
            $('.money_payment_type').change(function() {
                var payment = $(this).val();
                var paymentId = $(this).data('id');

                $('.input-groups').hide();
                if (payment === 'cash') {
                    $('.others_group').hide();
                    $('.mfs_group').hide();
                    $('.cheque_group').hide();
                } else if (payment === 'cheque') {
                    $('.others_group').hide();
                    $('.mfs_group').hide();
                    $('.cheque_group').show();
                }
                else if (payment === 'mfs') {
                    $('.cheque_group').hide();
                    $('.others_group').hide();
                    $('.mfs_group').show();
                }
                else if (payment === 'others') {
                    $('.cheque_group').hide();
                    $('.mfs_group').hide();
                    $('.others_group').show();
                }
            });



        });
    </script>
@endpush



