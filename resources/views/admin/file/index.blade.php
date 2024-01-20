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
        @if($files->isNotEmpty())
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
                                    <th> شماره تماس </th>
                                    <th> ثبت کننده </th>
                                    <th> نوع </th>
                                    <th>
                                        @if($files->pluck('status')->contains('غیرفعال') ||
                                            $files->pluck('type_sale')->contains('خرید') && $files->pluck('type_sale')->contains('رهن و اجاره'))
                                            قیمت / رهن
                                        @elseif($files->pluck('type_sale')->contains('رهن و اجاره'))
                                            رهن
                                        @else
                                            قیمت
                                        @endif
                                    </th>
                                    <th>زمان باقیمانده </th>
                                    <th> نمایش </th>
                                    <th> ویرایش </th>
                                    <th>حذف</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($files as $key => $file)
                                    <tr>
                                        <td>{{$files->firstItem() + $key}}</td>
                                        <td>
                                            {{$file->name}}
                                            @if($file->getRawOriginal('status') == 'active')
                                                <span class="mdi mdi-checkbox-blank-circle text-success"></span>
                                            @elseif($file->getRawOriginal('status') == 'unknown')
                                                <span class="mdi mdi-checkbox-blank-circle" style="color:#FFA500;"></span>
                                            @else
                                                <span class="mdi mdi-checkbox-blank-circle text-danger"></span>
                                            @endif
                                        </td>
                                        <td>{{$file->number}}</td>
                                        <td>{{$file->user->name}}</td>
                                        <td>{{$file->type_sale}}</td>
                                        <td>{{$file->getRawOriginal('selling_price') !== 0 ? $file->selling_price : $file->rahn_amount}}</td>
                                        <td>{{$file->daysLeft ? $file->daysLeft . ' روز' : 'منقضی'}} </td>
                                        <td><a class="text-white text-decoration-none" href="{{route('admin.files.show',$file->id)}}"><i class="mdi mdi-eye"></i></a></td>
                                        <td><a class="text-white text-decoration-none" href="{{route('admin.files.edit',$file->id)}}"><i class="mdi mdi-lead-pencil"></i></a></td>
                                        <td>
                                            <a href="{{route('admin.files.destroy',$file->id)}}" id="open_delete_panel_{{$key}}" class="text-decoration-none text-danger" type="button"><i class="mdi mdi-delete"></i></a>
                                        </td>
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
                <p>فایلی وجود ندارد.</p>
            </div>
        @endif
    </div>
    {{$files->links()}}

@endsection
