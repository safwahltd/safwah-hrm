@extends('admin.layout.app')
@section('title','Create New Expense')
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
                <h3 class="fw-bold mb-0 text-white">Create New Expense</h3>
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
                    <form action="{{ route('admin.expense.store') }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="receipt_no" class="form-label">Receipt No <span class="text-danger">*</span></label>
                                    <input type="text" name="receipt_no" class="form-control" id="receipt_no" required>
                                </div>
                                <div class="mb-3">
                                    <label for="leave_type_idAdd" class="form-label">Receipt Type <span class="text-danger">*</span></label>
                                    <select class="form-control receipt_type" name="receipt_type" id="leave_type_idAdd" required>
                                        <option value="" disabled selected>Select Receipt Type</option>
                                        <option {{old('receipt_type') == 'advance_money_receipt' ? 'selected':''}} value="advance_money_receipt">Advance Money Receipt</option>
                                        <option {{old('receipt_type') == 'money_receipt' ? 'selected':''}} value="money_receipt">Money Receipt</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="date" class="form-label">Date <span class="text-danger">*</span></label>
                                    <input type="date" name="date" class="form-control" id="date" required>
                                </div>
                                <div class="mb-3">
                                    <label for="user_id" class="form-label">User <span class="text-danger">*</span></label>
                                    <select class="form-control select2-example"  name="user_id" id="user_id" required>
                                        @foreach($users as $user)
                                            <option {{ old('user_id') == $user->id ? 'selected':'' }} value="{{ $user->id }}">{{ $user->name }} <sub>({{ $user->userInfo->employee_id }})</sub></option>
                                        @endforeach
                                    </select>
                                </div>
                                {{--Advance Money Receipt--}}
                                <div class="mb-3 date_group input-groups">
                                    <label for="payment_type" class="form-label">Payment Type </label>
                                    <select class="form-control"  name="advance_payment_type" id="payment_type">
                                        <option  {{ old('advance_payment_type') == 'cash' ? 'selected':'' }} value="cash">CASH</option>
                                        <option  {{ old('advance_payment_type') == 'bank' ? 'selected':'' }} value="bank">BANK</option>
                                        <option  {{ old('advance_payment_type') == 'mfs' ? 'selected':'' }} value="mfs">MFS</option>
                                    </select>
                                </div>
                                {{-- Money Receipt --}}
                                <div class="mb-3 time_group">
                                    <label for="money_payment_typeAdd" class="form-label"> Payment Type <span class="text-danger"> * </span></label>
                                    <select class="form-control money_payment_type" name="money_payment_type" id="money_payment_typeAdd">
                                        <option value="" disabled selected> Select Payment Type </option>
                                        <option {{old('money_payment_type') == 'cash' ? 'selected':''}} value="cash">CASH</option>
                                        <option {{old('money_payment_type') == 'cheque' ? 'selected':''}} value="cheque">CHEQUE</option>
                                        <option {{old('money_payment_type') == 'mfs' ? 'selected':''}} value="mfs">MFS</option>
                                        <option {{old('money_payment_type') == 'others' ? 'selected':''}} value="others">OTHERS</option>
                                    </select>
                                </div>
                                {{--Cheque --}}
                                <div class="mb-3 cheque_group">
                                    <label for="cheque_noAdd" class="form-label"> Cheque No </label>
                                    <input class="form-control" type="text" name="cheque_no" value="{{old('cheque_no')}}" id="cheque_noAdd">
                                </div>
                                <div class="mb-3 cheque_group">
                                    <label for="end_timeAdd" class="form-label"> Bank </label>
                                    <input class="form-control" type="text" name="cheque_bank" value="{{old('cheque_bank')}}" id="cheque_bankAdd">
                                </div>
                                <div class="mb-3 cheque_group">
                                    <label for="cheque_dateAdd" class="form-label"> Cheque Date </label>
                                    <input class="form-control" type="date" name="cheque_date" value="{{old('cheque_date')}}" id="cheque_dateAdd">
                                </div>
                                {{-- MFS --}}
                                <div class="mb-3 mfs_group">
                                    <label for="mfs_sender_noAdd" class="form-label"> Sender No </label>
                                    <input class="form-control" type="text" name="mfs_sender_no" value="{{old('mfs_sender_no')}}" id="mfs_sender_noAdd">
                                </div>
                                <div class="mb-3 mfs_group">
                                    <label for="mfs_receiver_noAdd" class="form-label"> Receiver No </label>
                                    <input class="form-control" type="text" name="mfs_receiver_no" value="{{old('mfs_receiver_no')}}" id="mfs_receiver_noAdd">
                                </div>
                                <div class="mb-3 mfs_group">
                                    <label for="mfs_transaction_noAdd" class="form-label"> Transaction No </label>
                                    <input class="form-control" type="text" name="mfs_transaction_no" value="{{old('mfs_transaction_no')}}" id="mfs_transaction_noAdd">
                                </div>
                                {{-- Others --}}
                                <div class="mb-3 others_group input-groups">
                                    <label for="othersAdd" class="form-label"> Others </label>
                                    <input class="form-control" type="text" name="others" value="{{old('others')}}" id="others">
                                </div>
                            </div>
                            <div class="col-md-6">
                                {{-- End Money Receipt --}}
                                <div class="mb-3 time_group">
                                    <label for="adjusted_receipt_no" class="form-label">Adjusted Receipt No ? <span class="text-muted">(optional)</span> </label>
                                    <select style="width: 100%" class="form-control select2-example adjusted_receipt_no" name="adjusted_receipt_no" id="adjusted_receipt_noAdd">
                                        <option value="" disabled selected> Select Receipt No </option>
                                        @foreach($receipts as $receipt)
                                            <option {{ old('adjusted_receipt_no') == $receipt->receipt_no ? 'selected':''}} value="{{ $receipt->receipt_no }}">{{ $receipt->receipt_no }} ({{ $receipt->date }})</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="amount" class="form-label">Amount <span class="text-danger">*</span></label>
                                    <input type="number" name="amount" min="0" class="form-control" id="amount" value="{{old('amount')}}">
                                </div>
                                <div class="mb-3 time_group">
                                    <label for="payment" class="form-label">Payment <span class="text-danger">*</span></label>
                                    <input type="number" name="payment" min="0" class="form-control" id="payment" value="{{old('amount')}}" >
                                </div>
                                <div class="mb-3 time_group">
                                    <label for="due" class="form-label">Due <span class="text-danger">*</span></label>
                                    <input type="number" name="due" min="0" class="form-control" id="due" value="{{old('amount')}}" >
                                </div>
                                <div class="mb-3">
                                    <label for="reason" class="form-label">Reason <span class="text-danger">*</span></label>
                                    <textarea class="form-control" name="reason" id="reason" cols="30" rows="6" required> {{ old('reason') }}</textarea>
                                </div>
                                <div class="mb-3 date_group input-groups">
                                    <label for="reason" class="form-label">Checked By </label>
                                    <input type="checkbox" name="checked_by" id="checked_by" style="width: 50px;" value="{{ auth()->user()->id }}">
                                </div>
                                <div class="mb-3 date_group input-groups">
                                    <label for="reason" class="form-label">Approved By </label>
                                    <input type="checkbox" name="approved_by" id="approved_by" style="width: 50px;" value="{{ auth()->user()->id }}">
                                </div>
                                <div class="mb-3 time_group">
                                    <label for="reason" class="form-label">Received By </label>
                                    <input type="checkbox" name="received_by" id="received_by" style="width: 50px;" value="{{ auth()->user()->id }}">
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Status </label>
                            <select style="width: 100%" class="form-control" name="status" id="status">
                                <option value="0"> Pending </option>
                                <option value="1"> Accepted </option>
                                <option value="2"> Rejected </option>
                            </select>

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


