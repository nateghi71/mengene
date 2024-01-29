@extends('layouts.admin' , ['sectionName' => 'کوپن ها'])

@section('title' , 'کوپن ها')

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
    <div id="deletePanel">
        <div id="deleteBox">
            <p class="text-end pb-3">ایا می خواهید کوپن موردنظر را حذف کنید؟</p>
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
        @if($coupons->isNotEmpty())
            <div class="col-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">کوپن ها</h4>
                        <div class="table-responsive">
                            <table class="table text-center">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>نام</th>
                                    <th>کد</th>
                                    <th>درصد</th>
                                    <th>تاریخ انقضا</th>
                                    @can('viewShow' , \App\Models\Coupon::class)
                                        <th> نمایش </th>
                                    @endcan
                                    @can('edit' , \App\Models\Coupon::class)
                                        <th> ویرایش </th>
                                    @endcan
                                    @can('delete' , \App\Models\Coupon::class)
                                        <th>حذف</th>
                                    @endcan
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($coupons as $key => $coupon)
                                    <tr>
                                        <td>{{$coupons->firstItem() + $key}}</td>
                                        <th>
                                            {{$coupon->name}}
                                        </th>
                                        <th>
                                            {{$coupon->code}}
                                        </th>

                                        <th>
                                            {{$coupon->percentage}}
                                        </th>
                                        <th>
                                            {{$coupon->expire_date}}
                                        </th>
                                        @can('viewShow' , \App\Models\Coupon::class)
                                            <td><a class="btn text-decoration-none" href="{{route('admin.coupons.show',$coupon->id)}}"><i class="mdi mdi-eye"></i></a></td>
                                        @endcan
                                        @can('edit' , \App\Models\Coupon::class)
                                            <td><a class="btn text-decoration-none" href="{{route('admin.coupons.edit',$coupon->id)}}"><i class="mdi mdi-autorenew"></i></a></td>
                                        @endcan
                                        @can('delete' , \App\Models\Coupon::class)
                                            <td><a href="{{route('admin.coupons.destroy',$coupon->id)}}" id="open_delete_panel_{{$key}}" class="btn btn-outline-danger" type="button"><i class="mdi mdi-delete"></i></a></td>
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
                <p>کوپنی وجود ندارد.</p>
            </div>
        @endif
    </div>
    {{$coupons->links()}}

@endsection
