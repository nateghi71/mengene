@extends('layouts.admin' , ['sectionName' => 'کوپن ها'])

@section('title' , 'کوپن ها')

@section('head')
    <style>
        .deletePanel {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 9999;
            overflow: hidden;
            background: rgba(0,0,0,0.5);
        }

        .deleteBox {
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
    <script type="module">
        $('[id^=open_delete_panel_]').on('click' , deleteBox)

        function deleteBox(e)
        {
            e.preventDefault()
            let wrapper = $('<div>' , {class:'deletePanel'})
            let box = $('<div>', {class:'deleteBox'})
            let message = $('<p>' , {
                class:"text-end pb-3",
                text:'ایا می خواهید کوپن موردنظر را حذف کنید؟'
            })

            let btnContainer = $('<div>' , {class:"d-flex justify-content-between"})
            let deleteForm = $('<form>' , {
                method:"post",
                action : $(this).attr('href')
            })
            let methodInput = $('<input>' , {
                type:"hidden",
                name:"_method",
                value : "DELETE"
            })
            let csrfInput = $('<input>' , {
                type:"hidden",
                name:"_token",
                value : "{{ csrf_token() }}"
            })


            let closeBtn = $('<button>' , {
                class:"btn btn-success",
                type:"button",
                click: ()=> wrapper.remove(),
                text:'خیر'
            })

            let actionBtn = $('<button>' , {
                class:"btn btn-danger",
                type:"submit",
                text:'بله',
            })

            wrapper.append(box)
            box.append(message)
            box.append(btnContainer)
            btnContainer.append(closeBtn)
            btnContainer.append(deleteForm)
            deleteForm.append(methodInput)
            deleteForm.append(csrfInput)
            deleteForm.append(actionBtn)

            $('#selectBox').append(wrapper)
        }
    </script>
@endsection

@section('content')
    <div id="selectBox">

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
                                    <th class="text-white">#</th>
                                    <th class="text-white">نام</th>
                                    <th class="text-white">کد</th>
                                    <th class="text-white">درصد</th>
                                    <th class="text-white">تاریخ انقضا</th>
                                    @can('viewShow' , \App\Models\Coupon::class)
                                        <th class="text-white"> نمایش </th>
                                    @endcan
                                    @can('edit' , \App\Models\Coupon::class)
                                        <th class="text-white"> ویرایش </th>
                                    @endcan
                                    @can('delete' , \App\Models\Coupon::class)
                                        <th class="text-white">حذف</th>
                                    @endcan
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($coupons as $key => $coupon)
                                    <tr>
                                        <td class="text-white">{{$coupons->firstItem() + $key}}</td>
                                        <th class="text-white">
                                            {{$coupon->name}}
                                        </th>
                                        <th class="text-white">
                                            {{$coupon->code}}
                                        </th>

                                        <th class="text-white">
                                            {{$coupon->percentage}}
                                        </th>
                                        <th class="text-white">
                                            {{$coupon->expire_date}}
                                        </th>
                                        @can('viewShow' , \App\Models\Coupon::class)
                                            <td class="text-white"><a class="btn text-decoration-none" href="{{route('admin.coupons.show',$coupon->id)}}"><i class="mdi mdi-eye"></i></a></td>
                                        @endcan
                                        @can('edit' , \App\Models\Coupon::class)
                                            <td class="text-white"><a class="btn text-decoration-none" href="{{route('admin.coupons.edit',$coupon->id)}}"><i class="mdi mdi-autorenew"></i></a></td>
                                        @endcan
                                        @can('delete' , \App\Models\Coupon::class)
                                            <td class="text-white"><a href="{{route('admin.coupons.destroy',$coupon->id)}}" id="open_delete_panel_{{$key}}" class="btn btn-outline-danger" type="button"><i class="mdi mdi-delete"></i></a></td>
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
