@extends('admin.layout.app')
@section('title','Notifications')
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
                <h3 class="fw-bold mb-0 text-white">Notifications</h3>
            </div>
        </div>
    </div>
    <!-- Row end  -->

    <div class="row clearfix g-3">
        <div class="col-sm-12">
            @forelse ($notifications as $key => $notification)
                    <div class="alert card" role="alert">
                        <a href="#" class="" data-bs-toggle="modal" id="notice{{$key}}" data-bs-target="#noticeShow{{$key}}">
                            <span class="fw-bold  {{ $notification->read_at == null ? '':'text-muted' }}">{{ ucfirst(str_replace('_', ' ', $notification->data['type'])) }}</span>  <small class=" {{ $notification->read_at == null ? '':'text-muted' }}">{{ $notification->created_at->diffForHumans() }}</small>
                            <br><span class=" {{ $notification->read_at == null ? '':'text-muted' }}">{{ ucfirst(str_replace('_', ' ', $notification->data['message'])) }}</span>
                        </a>
                        <span class="my-2">
                        @if( $notification->read_at == null )
                                <form action="{{route('notifications.markAsRead',$notification->id)}}" method="post">
                                    @csrf
                                    <button>mark as read</button>
                                </form>
                        @endif
                        </span>
                    </div>
                @php
                  $user = \App\Models\User::find($notification->data['data']['user_id']);
                @endphp
                <div class="modal fade" id="noticeShow{{$key}}" tabindex="-1"  aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
                        <div class="modal-content bg-secondary-subtle ">
                            <div class="modal-header">
                                <h5 class="modal-title  fw-bold" id="depeditLabel">{{ ucwords(str_replace('_', ' ', $notification->data['type'])) }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="deadline-form">
                                    <div class="modal-body">
                                        <div class="">
                                            @if(isset($notification->data['data']['content']))
                                            <p align="justify">{!! isset($notification->data['data']['content']) ? $notification->data['data']['content'] : '' !!}</p><br>
                                            @endif
                                            <p align="justify">
                                                @if($notification->data['type'] == 'new_notice')
                                                <span>Sincerely,</span><br>
                                                @endif
                                                <span>{{ isset($user->name) ? $user->name : 'User Not Find' }}</span><br>
                                                <span>{{ isset($user->userInfo->designations->name) ? $user->userInfo->designations->name : '' }}</span><br>
                                                <span>{{ isset($setting->company_name) ? $setting->company_name : '' }}</span><br>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="alert card" role="alert">
                    <p class="text-center"> No Notification Found</p>
                </div>
            @endforelse
        </div>
        <div class="d-grid justify-content-center">
            {{ $notifications->links() }}
        </div>

    </div>


@endsection

