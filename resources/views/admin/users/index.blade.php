@extends('layouts.admin' , ['sectionName' => 'کاربران'])

@section('title' , 'کاربران')

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
                text:'ایا می خواهید کاربر موردنظر را تغییر وضعیت دهید؟'
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
        @if($users->isNotEmpty())
            <div class="col-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">کاربران</h4>
                        <div class="table-responsive">
                            <table class="table text-center">
                                <thead>
                                <tr>
                                    <th class="text-white"> # </th>
                                    <th class="text-white"> نام </th>
                                    <th class="text-white"> شماره </th>
                                    <th class="text-white"> شهر </th>
                                    <th class="text-white"> نقش </th>
                                    @can('viewShow' , \App\Models\User::class)
                                    <th class="text-white"> نمایش </th>
                                    @endcan
                                    @can('edit' , \App\Models\User::class)
                                    <th class="text-white"> ویرایش </th>
                                    @endcan
                                    @can('changeStatus' , \App\Models\User::class)
                                    <th class="text-white"> وضعیت
                                    @endcan
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($users as $key => $user)
                                    <tr>
                                        <td class="text-white">{{$users->firstItem() + $key}}</td>
                                        <td class="text-white">{{$user->name}}</td>
                                        <td class="text-white">{{$user->number}}</td>
                                        <td class="text-white">{{$user->city->name}}</td>
                                        <td class="text-white">{{$user->role->name}}</td>
                                        @can('viewShow' , \App\Models\User::class)
                                        <td class="text-white"><a class="btn text-decoration-none" href="{{route('admin.users.show',$user->id)}}"><i class="mdi mdi-eye"></i></a></td>
                                        @endcan
                                        @can('edit' , \App\Models\User::class)
                                        <td class="text-white"><a class="btn text-decoration-none" href="{{route('admin.users.edit',$user->id)}}"><i class="mdi mdi-pencil"></i></a></td>
                                        @endcan
                                        @can('changeStatus' , \App\Models\User::class)
                                        <td class="text-white">
                                            <a class="btn text-decoration-none" id="open_delete_panel_{{$key}}" href="{{route('admin.users.status',$user->id)}}">
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
