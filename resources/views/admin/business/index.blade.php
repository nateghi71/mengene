@extends('layouts.admin' , ['sectionName' => 'املاکی ها'])

@section('title' , 'املاکی ها')

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
            let btnContainer = $('<div>' , {class:"d-flex justify-content-between"})

            let message = $('<p>' , {
                class:"text-end pb-3",
                text:'ایا می خواهید املاکی موردنظر را تغییر وضعیت دهید؟'
            })

            let closeBtn = $('<button>' , {
                class:"btn btn-success",
                type:"button",
                click: ()=> wrapper.remove(),
                text:'خیر'
            })

            let actionBtn = $('<a>' , {
                class:"btn btn-danger",
                text:'بله',
                href: $(this).attr('href')
            })

            wrapper.append(box)
            box.append(message)
            box.append(btnContainer)
            btnContainer.append(closeBtn)
            btnContainer.append(actionBtn)

            $('#selectBox').append(wrapper)
        }
    </script>

@endsection

@section('content')
    <div id="selectBox">

    </div>

    <div class="row">
        @if($businesses->isNotEmpty())
            <div class="col-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">املاکی ها</h4>
                        <div class="table-responsive">
                            <table class="table text-center">
                                <thead>
                                <tr>
                                    <th class="text-white"> # </th>
                                    <th class="text-white"> نام </th>
                                    <th class="text-white"> شهر </th>
                                    <th class="text-white"> شماره تماس </th>
                                    @can('viewShow' , \App\Models\Business::class)
                                    <th class="text-white"> نمایش </th>
                                    @endcan
                                    @can('changeStatus' , \App\Models\Business::class)
                                    <th class="text-white">تغییر وضعیت</th>
                                    @endcan
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($businesses as $key => $business)
                                    <tr>
                                        <td class="text-white">{{$businesses->firstItem() + $key}}</td>
                                        <td class="text-white">{{$business->name}}</td>
                                        <td class="text-white">{{$business->city->name}}</td>
                                        <td class="text-white">{{$business->owner->number}}</td>
                                        @can('viewShow' , \App\Models\Business::class)
                                        <td class="text-white"><a class="btn text-decoration-none" href="{{route('admin.business.show',$business->id)}}"><i class="mdi mdi-eye"></i></a></td>
                                        @endcan
                                        @can('changeStatus' , \App\Models\Business::class)

                                        <td class="text-white">
                                            <a href="{{route('admin.business.changeStatus',$business->id)}}" id="open_delete_panel_{{$key}}" class="text-decoration-none" type="button">
                                                {!! $business->status === 'active' ? '<span class="text-danger">غیرفعال کردن</span>' : '<span class="text-success">فعال کردن</span>' !!}
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
                <p>املاکی وجود ندارد.</p>
            </div>
        @endif
    </div>
    {{$businesses->links()}}

@endsection
