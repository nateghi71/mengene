@extends('layouts.admin' , ['sectionName' => 'سفارش ها'])

@section('title' , 'سفارش ها')

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
    <script>
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
        @if($orders->isNotEmpty())
            <div class="col-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">سفارش ها</h4>
                        <div class="table-responsive">
                            <table class="table text-center">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>کاربر</th>
                                    <th>املاکی</th>
                                    <th>مقدار پرداختی</th>
                                    <th>موفقیت پرداخت</th>
                                    <th> نمایش </th>
                                    <th> ویرایش </th>
                                    <th>حذف</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($orders as $key => $order)
                                    <tr>
                                        <td>{{$orders->firstItem() + $key}}</td>
                                        <th>
                                            {{$order->user->name}}
                                        </th>
                                        <th>
                                            {{$order->business->name}}
                                        </th>

                                        <th>
                                            {{number_format($order->paying_amount)}}
                                        </th>
                                        <th>
                                            {{$order->payment_status}}
                                        </th>
                                        <td><a class="btn text-decoration-none" href="{{route('admin.orders.show',$order->id)}}"><i class="mdi mdi-eye"></i></a></td>
                                        <td><a class="btn text-decoration-none" href="{{route('admin.orders.edit',$order->id)}}"><i class="mdi mdi-autorenew"></i></a></td>
                                        <td><a href="{{route('admin.orders.destroy',$order->id)}}" id="open_delete_panel_{{$key}}" class="btn btn-outline-danger" type="button"><i class="mdi mdi-delete"></i></a></td>
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
    {{$orders->links()}}

@endsection
