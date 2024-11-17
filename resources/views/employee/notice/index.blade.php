@extends('admin.layout.app')
@section('title','notices')
@section('body')
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.5; }
        h1 { text-align: center; }
        .content { margin: 0 auto; width: 80%; }
        .signature { margin-top: 50px; }
        label {
            display: inline-block;
            padding-bottom: 10px;
        }
    </style>
    <div class="row align-items-center">
        <div class="border-0 mb-4">
            <div class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
                <h3 class="fw-bold mb-0 text-white">notices</h3>
            </div>
        </div>
    </div>
    <!-- Row end  -->

    <div class="row clearfix g-3">
        <div class="col-sm-12">
            @foreach ($notices as $key => $notice)
                <a href="#" class="" data-bs-toggle="modal" id="notice{{$key}}" data-bs-target="#noticeShow{{$key}}">
                    <div class="alert alert-primary" role="alert">
                         <span class="fw-bold">{{ $notice->title }}</span>  <small>{{ $notice->created_at->diffForHumans() }}</small>
                        <p>{{ \Illuminate\Support\Str::limit($notice->content, 70) }}</p>
                    </div>
                </a>
                <div class="modal fade" id="noticeShow{{$key}}" tabindex="-1"  aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
                        <div class="modal-content bg-secondary-subtle ">
                            <div class="modal-header">
                                <h5 class="modal-title  fw-bold" id="depeditLabel">{{ $notice->title }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="deadline-form">
                                    <div class="modal-body">
                                        <div class="">
                                            <p align="justify">{{ $notice->content }}</p><br>
                                            <address>
                                                Regards & Thanks <br>
                                                {{ $notice->user->userInfo->designations->name ?? 'Managing Director' }}<br>
                                                Shahjadpur,Gulsan-2,Confidence Center,Dhaka-1212,Bangladesh<br>
                                                info@safwahltd.com<br>
                                            </address>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>


@endsection

