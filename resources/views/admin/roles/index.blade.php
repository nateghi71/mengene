@extends('layouts.admin' , ['sectionName' => 'نقش ها'])

@section('title' , 'نقش ها')

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
        @if($roles->isNotEmpty())
            <div class="col-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">نقش ها</h4>
                        <div class="table-responsive">
                            <table class="table text-center">
                                <thead>
                                <tr>
                                    <th> # </th>
                                    <th> نام </th>
                                    <th> نمایش </th>
                                    <th> ویرایش </th>
                                    <th>حذف</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($roles as $key => $role)
                                    <tr>
                                        <td>{{$roles->firstItem() + $key}}</td>
                                        <td>{{$role->name}}</td>
                                        <td><a class="btn text-decoration-none" href="{{route('admin.roles.show',$role->id)}}"><i class="mdi mdi-eye"></i></a></td>
                                        <td><a class="btn text-decoration-none" href="{{route('admin.roles.edit',$role->id)}}"><i class="mdi mdi-autorenew"></i></a></td>
                                        <td><a href="{{route('admin.roles.destroy',$role->id)}}" id="open_delete_panel_{{$key}}" class="btn btn-outline-danger" type="button"><i class="mdi mdi-delete"></i></a></td>
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
    {{$roles->links()}}

@endsection
