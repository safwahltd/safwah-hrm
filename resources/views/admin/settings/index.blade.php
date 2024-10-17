@extends('admin.layout.app')
@section('title','Settings')
@section('body')
    <div class="row row-sm">
        <div class="col-lg-12">
            <div class="card">
                <div class="border-bottom m-3">
                    <div class="row">
                        <div class="card-header border-bottom justify-content-between">
                            <h3 class="card-title">Settings</h3>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form class="form-horizontal" action="{{route('admin.company.setting.update',$companySetting->id)}}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row mb-4">
                            <div class="col-md-6 mx-0" style="gap: 0">
                                <div class="row input-group mb-4">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text text-white  col-4 bg-black" id="company_name">Company Name</span>
                                        <input type="text" name="company_name" class="form-control" value="{{$companySetting->company_name}}" placeholder="company name" aria-label="company name" aria-describedby="basic-addon1">
                                    </div>
                                </div>
                                <div class="row input-group mb-4">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text text-white col-4 bg-black" id="company_title">Company Title</span>
                                        <input type="text" name="company_title" class="form-control bg-dark-subtle" value="{{$companySetting->company_title}}" placeholder="company title" aria-label="company title" aria-describedby="basic-addon1">
                                    </div>
                                </div>
                                <div class="row input-group mb-4">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text text-white  col-4 bg-black" id="phone">Phone</span>
                                        <input type="text" name="phone" class="form-control" value="{{$companySetting->phone}}" placeholder="phone" aria-label="phone" aria-describedby="basic-addon1">
                                    </div>
                                </div>
                                <div class="row input-group mb-4">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text text-white  col-4 bg-black" id="hotLine">HotLine</span>
                                        <input type="text" name="hotLine" class="form-control" value="{{$companySetting->hotLine}}" placeholder="hotLine" aria-label="hotLine" aria-describedby="basic-addon1">
                                    </div>
                                </div>
                                <div class="row input-group mb-4">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text text-white  col-4 bg-black" id="email">email</span>
                                        <input type="email" name="email" class="form-control" value="{{$companySetting->email}}" placeholder="email" aria-label="email" aria-describedby="basic-addon1">
                                    </div>
                                </div>
                                <div class="row input-group mb-4">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text  text-white col-4 bg-black" id="address">address</span>
                                        <textarea class="form-control" aria-label="address" placeholder="address"  aria-describedby="basic-addon1" name="address" id="address" cols="30" rows="3">{{$companySetting->address}}</textarea>
                                    </div>
                                </div>
                                <div class="row input-group mb-4">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text text-white col-4 bg-black" id="logo">logo</span>
                                        <input type="file" name="logo" class="form-control col-5 image-input" value="" id="banner" placeholder="logo" aria-label="logo" aria-describedby="basic-addon1">
                                        <img class="img-fluid img-responsive mx-1" id="imagePreview-banner" src="{{asset($companySetting->logo)}}"
                                             alt="Your Image" style="width: 100px; height: auto;" />
                                    </div>
                                </div>
                                <div class="row input-group mb-4">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text text-white  col-4 bg-black" id="favicon">Favicon</span>
                                        <input type="file" name="favicon" class="form-control col-5 image-input" value="" id="favicon" placeholder="favicon" aria-label="favicon" aria-describedby="basic-addon1">
                                        <img class="img-fluid img-responsive my-2 mx-2" id="imagePreview-favicon" src="{{asset($companySetting->favicon)}}" alt="Your Image" style="width: 70px; height: auto;" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mx-0">
                                <div class="row input-group mb-4">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text text-white col-4 bg-black" id="website_link">Website Link</span>
                                        <input type="text" name="website_link" class="form-control" value="{{$companySetting->website_link}}" placeholder="website link" aria-label="website link" aria-describedby="basic-addon1">
                                    </div>
                                </div>
                                <div class="row input-group mb-4">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text text-white  col-4 bg-black" id="app_link">App Link</span>
                                        <input type="text" name="app_link" class="form-control" value="{{$companySetting->app_link}}" placeholder="app link" aria-label="app link" aria-describedby="basic-addon1">
                                    </div>
                                </div>
                                <div class="row input-group mb-4">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text text-white  col-4 bg-black" id="ios_link">Ios Link</span>
                                        <input name="ios_link" type="text" class="form-control" value="{{$companySetting->ios_link}}" placeholder="ios link" aria-label="ios link" aria-describedby="basic-addon1">
                                    </div>
                                </div>
                                <div class="row input-group mb-4">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text text-white  col-4 bg-black" id="meta_title">Meta Title</span>
                                        <input name="meta_title" type="text" class="form-control" value="{{$companySetting->meta_title}}" placeholder="meta title" aria-label="meta title" aria-describedby="basic-addon1">
                                    </div>
                                </div>
                                <div class="row input-group mb-4">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text text-white col-4 bg-black" id="meta_keyword">Meta Keyword</span>
                                        <input name="meta_keyword" type="text" class="form-control" value="{{$companySetting->meta_keyword}}" placeholder="meta keyword" aria-label="meta keyword" aria-describedby="basic-addon1">
                                    </div>
                                </div>
                                <div class="row input-group mb-4">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text  text-white col-4 bg-black" id="meta_description">Meta Description</span>
                                        <textarea class="form-control" aria-label="meta_description" placeholder="meta description"  aria-describedby="basic-addon1" name="meta_description" id="meta_description" cols="30" rows="2">{{$companySetting->meta_description}}</textarea>
                                    </div>
                                </div>
                                <div class="row input-group mb-4">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text  text-white col-4 bg-black" id="meta_author">Meta Author</span>
                                        <textarea class="form-control" aria-label="meta_author" placeholder="meta author"  aria-describedby="basic-addon1" name="meta_author" id="meta_author" cols="30" rows="2">{{$companySetting->meta_author}}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if(auth()->user()->hasPermission('admin company setting update'))
                            <button class="btn btn-primary float-end" type="submit">update</button>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

