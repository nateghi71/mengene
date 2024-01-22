@extends('layouts.admin' , ['sectionName' => 'کاربران'])

@section('title' , 'کاربران')

@section('head')
    <style>
        #deletePanel {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 9999;
            overflow: hidden;
            background: rgba(0,0,0,0.5);
        }

        #deleteBox {
            position: fixed;
            padding: 20px;
            top: 50%;
            left: 50%;
            background: rgba(0,0,0,1);
            transform: translate(-50%, -50%);
        }
    </style>
@endsection

@section('scripts')
    <script>
        $('.btn-close').on('click' , function (){
            $('#message').remove()
        })

        $('#deletePanel').hide()

        $('[id^=open_delete_panel_]').on('click' , function (e){
            e.preventDefault()
            $('#deletePanel').show()
            $('#deleteBox').children().children().eq(0).attr('action' , $(this).attr('href'))
        })
        $('#not_delete_btn').on('click' , function (){
            $('#deletePanel').hide()
        })
    </script>

@endsection

@section('content')
    @if (session()->has('message'))
        <div class="alert alert-success d-flex justify-content-between" id="message">
            {{session()->get('message')}}
            <button type="button" class="btn-close" aria-label="Close"></button>
        </div>
    @endif

    <div id="deletePanel">
        <div id="deleteBox">
            <p class="text-end pb-3">ایا می خواهید فایل موردنظر را حذف کنید؟</p>
            <div class="d-flex justify-content-between">
                <form method="post">
                    @csrf
                    @method('DELETE')
                    <button id="delete_btn" class="btn btn-danger" type="submit">بله</button>
                </form>
                <button id="not_delete_btn" class="btn btn-success" type="button">خیر</button>
            </div>
        </div>
    </div>

    <div class="row">
        @if($users->isNotEmpty())
            <div class="col-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">کاربران</h4>
                        <div class="table-responsive">
                            <table class="table text-center">
                                <thead>
                                <tr>
                                    <th> # </th>
                                    <th> نام </th>
                                    <th> شماره </th>
                                    <th> شهر </th>
                                    <th> نقش </th>
                                    @can('viewShow' , \App\Models\User::class)
                                    <th> نمایش </th>
                                    @endcan
                                    @can('edit' , \App\Models\User::class)
                                    <th> ویرایش </th>
                                    @endcan
                                    @can('changeStatus' , \App\Models\User::class)
                                    <th> وضعیت
                                    @endcan
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($users as $key => $user)
                                    <tr>
                                        <td>{{$users->firstItem() + $key}}</td>
                                        <td>{{$user->name}}</td>
                                        <td>{{$user->number}}</td>
                                        <td>{{$user->city->name}}</td>
                                        <td>{{$user->role->name}}</td>
                                        @can('viewShow' , \App\Models\User::class)
                                        <td><a class="btn text-decoration-none" href="{{route('admin.users.show',$user->id)}}"><i class="mdi mdi-eye"></i></a></td>
                                        @endcan
                                        @can('edit' , \App\Models\User::class)
                                        <td><a class="btn text-decoration-none" href="{{route('admin.users.edit',$user->id)}}"><i class="mdi mdi-pencil"></i></a></td>
                                        @endcan
                                        @can('changeStatus' , \App\Models\User::class)
                                        <td>
                                            <a class="btn text-decoration-none" href="{{route('admin.users.status',$user->id)}}">
                                                {!! $user->status === 'active' ? '<span class="text-danger">غیرفعال کردن</span>' : '<span class="text-success">فعال کردن</span>' !!}
                                            </a>
                                        </td>
                                        @endcan
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="d-flex justify-content-center">
                <p>نقشی وجود ندارد.</p>
            </div>
        @endif
    </div>
    {{$users->links()}}

@endsection
