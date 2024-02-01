@extends('layouts.admin' , ['sectionName' => 'نقش ها'])

@section('title' , 'نقش ها')

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
            background: rgba(0, 0, 0, 0.5);
        }

        .deleteBox {
            position: fixed;
            padding: 20px;
            top: 50%;
            left: 50%;
            background: rgba(0, 0, 0, 1);
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

            let message = $('<p>' , {
                class:"text-end pb-3",
                text:'ایا می خواهید فایل موردنظر را حذف کنید؟'
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
        @if($landowners->isNotEmpty())
            <div class="col-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">فایل ها</h4>
                        <div class="table-responsive">
                            <table class="table text-center">
                                <thead>
                                <tr>
                                    <th> #</th>
                                    <th> نام</th>
                                    <th> شماره تماس</th>
                                    <th> ثبت کننده</th>
                                    <th> نوع</th>
                                    <th>
                                        @if($landowners->pluck('status')->contains('غیرفعال') ||
                                            $landowners->pluck('type_sale')->contains('خرید') && $landowners->pluck('type_sale')->contains('رهن و اجاره'))
                                            قیمت / رهن
                                        @elseif($landowners->pluck('type_sale')->contains('رهن و اجاره'))
                                            رهن
                                        @else
                                            قیمت
                                        @endif
                                    </th>
                                    <th>زمان باقیمانده</th>
                                    @can('adminViewShow' , \App\Models\landowner::class)
                                        <th> نمایش</th>
                                    @endcan
                                    @can('adminEdit' , \App\Models\landowner::class)
                                        <th> ویرایش</th>
                                    @endcan
                                    @can('adminDelete' , \App\Models\landowner::class)
                                        <th>حذف
                                    @endcan
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($landowners as $key => $landowner)
                                    <tr>
                                        <td>{{$landowners->firstItem() + $key}}</td>
                                        <td>
                                            {{$landowner->name}}
                                            @if($landowner->getRawOriginal('status') == 'active')
                                                <span class="mdi mdi-checkbox-blank-circle text-success"></span>
                                            @elseif($landowner->getRawOriginal('status') == 'unknown')
                                                <span class="mdi mdi-checkbox-blank-circle"
                                                      style="color:#FFA500;"></span>
                                            @else
                                                <span class="mdi mdi-checkbox-blank-circle text-danger"></span>
                                            @endif
                                        </td>
                                        <td>{{$landowner->number}}</td>
                                        <td>{{$landowner->user->name}}</td>
                                        <td>{{$landowner->type_sale}}</td>
                                        <td>{{$landowner->getRawOriginal('selling_price') !== 0 ? $landowner->selling_price : $landowner->rahn_amount}}</td>
                                        <td>{{$landowner->daysLeft ? $landowner->daysLeft . ' روز' : 'منقضی'}} </td>
                                        @can('adminViewShow' , \App\Models\landowner::class)
                                            <td><a class="text-white text-decoration-none"
                                                   href="{{route('admin.landowners.show',$landowner->id)}}"><i
                                                            class="mdi mdi-eye"></i></a></td>
                                        @endcan
                                        @can('adminEdit' , \App\Models\landowner::class)
                                            <td>
                                                <button type="button" class="btn btn-link text-decoration-none text-white" id="edit" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="mdi mdi-lead-pencil"></i>
                                                </button>
                                                <ul class="dropdown-menu" aria-labelledby="edit">
                                                    <li><a class="dropdown-item" href="{{route('admin.landowners.edit',$landowner->id)}}">ویرایش</a></li>
                                                    <li><a class="dropdown-item" href="{{route('admin.landowner.edit_images',$landowner->id)}}">ویرایش عکس</a></li>
                                                </ul>
                                            </td>
                                        @endcan
                                        @can('adminDelete' , \App\Models\landowner::class)
                                            <td>
                                                <a href="{{route('admin.landowners.destroy',$landowner->id)}}"
                                                   id="open_delete_panel_{{$key}}"
                                                   class="text-decoration-none text-danger" type="button"><i
                                                            class="mdi mdi-delete"></i></a>
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
                <p>فایلی وجود ندارد.</p>
            </div>
        @endif
    </div>
    {{$landowners->links()}}

@endsection
