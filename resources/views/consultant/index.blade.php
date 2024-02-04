@extends('layouts.dashboard' , ['sectionName' => 'داشبورد'])

@section('title' , 'داشبورد')

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
            top: calc(50% - 60px);
            left: calc(50% - 140px);
            background: rgba(0,0,0,1);
        }
    </style>
@endsection

@section('scripts')
    <script>
        if ($("#transaction-history").length) {
            let business = @json($business);
            let landowner = (business.landowners_count * 100 )/(business.customers_count + business.landowners_count);
            let customer = (business.customers_count * 100 )/(business.customers_count + business.landowners_count);
            var areaData = {
                labels: [ "مالک","متقاضی"],
                datasets: [{
                    data: [(landowner).toFixed(1), (customer).toFixed(1)],
                    backgroundColor: [
                        "#00d25b","#ffab00"
                    ]
                }
                ]
            };
            var areaOptions = {
                responsive: true,
                maintainAspectRatio: true,
                segmentShowStroke: false,
                cutoutPercentage: 70,
                elements: {
                    arc: {
                        borderWidth: 0
                    }
                },
                legend: {
                    display: false
                },
                tooltips: {
                    enabled: true
                }
            }
            var transactionhistoryChartPlugins = {
                beforeDraw: function(chart) {
                    var width = chart.chart.width,
                        height = chart.chart.height,
                        ctx = chart.chart.ctx;

                    ctx.restore();
                    var fontSize = 1;
                    ctx.font = fontSize + "rem sans-serif";
                    ctx.textAlign = 'left';
                    ctx.textBaseline = "middle";
                    ctx.fillStyle = "#ffffff";

                    var text = business.customers_count + business.landowners_count,
                        textX = Math.round((width - ctx.measureText(text).width) / 2),
                        textY = height / 2.4;

                    ctx.fillText(text, textX, textY);

                    ctx.restore();
                    var fontSize = 0.75;
                    ctx.font = fontSize + "rem sans-serif";
                    ctx.textAlign = 'left';
                    ctx.textBaseline = "middle";
                    ctx.fillStyle = "#6c7293";

                    var texts = "تعداد کل",
                        textsX = Math.round((width - ctx.measureText(text).width) / 2.2),
                        textsY = height / 1.7;

                    ctx.fillText(texts, textsX, textsY);
                    ctx.save();
                }
            }
            var transactionhistoryChartCanvas = $("#transaction-history").get(0).getContext("2d");
            var transactionhistoryChart = new Chart(transactionhistoryChartCanvas, {
                type: 'doughnut',
                data: areaData,
                options: areaOptions,
                plugins: transactionhistoryChartPlugins
            });
        }
        $('#open_delete_panel').on('click' , deleteBox)

        function deleteBox(e)
        {
            e.preventDefault()
            let wrapper = $('<div>' , {class:'deletePanel'})
            let box = $('<div>', {class:'deleteBox'})
            let btnContainer = $('<div>' , {class:"d-flex justify-content-between"})

            let message = $('<p>' , {
                class:"text-end pb-3",
                text:'ایا می خواهید از کار با این اژانس املاک انصراف دهید؟'
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
        <div class="col-12 grid-margin stretch-card">
            <div class="card corona-gradient-card">
                <div class="card-body py-0 px-0 px-sm-3">
                    <div class="row align-items-center">
                        <div class="col-4 col-sm-3 col-xl-2">
                            <img src="{{asset('Admin/assets/images/dashboard/Group126@2x.png')}}" class="gradient-corona-img img-fluid" alt="">
                        </div>
                        <div class="col-5 col-sm-7 col-xl-8 p-0">
                            <h4 class="mb-1 mb-sm-0">شما هم اکنون در داشبورد هستید!</h4>
                            <p class="mb-0 font-weight-normal d-none d-sm-block">خوش امدید</p>
                        </div>
                        <div class="col-3 col-sm-2 col-xl-2 ps-0 text-center">
                        <span>
                          <span class="btn btn-outline-light btn-rounded get-started-btn">داشبورد</span>
                        </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
            <div class="card bg-primary bg-gradient bg-opacity-50">
                <a href="{{route('landowner.create')}}" class="text-decoration-none text-white">
                    <div class="card-body">
                        <div class="icon">
                            <div class="d-flex align-items-center align-self-start text-white">
                                <span class="mdi mdi-account-plus icon-item text-white"></span>
                                <h3 class="pe-2 mb-0 fs-6">ایجاد مالک</h3>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
            <div class="card bg-primary bg-gradient bg-opacity-50">
                <a href="{{route('landowner.index')}}" class="text-decoration-none text-white">
                    <div class="card-body">
                        <div class="icon">
                            <div class="d-flex align-items-center align-self-start text-white">
                                <span class="mdi mdi-account-search icon-item text-white"></span>
                                <h3 class="pe-2 mb-0 fs-6">مالکان</h3>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
            <div class="card bg-primary bg-gradient bg-opacity-50">
                <a href="{{route('customer.create')}}" class="text-decoration-none text-white">
                    <div class="card-body">
                        <div class="icon">
                            <div class="d-flex align-items-center align-self-start text-white">
                                <span class="mdi mdi-account-plus icon-item text-white"></span>
                                <h3 class="pe-2 mb-0 fs-6">ایجاد متقاضی</h3>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
            <div class="card bg-primary bg-gradient bg-opacity-50">
                <a href="{{route('customer.index')}}" class="text-decoration-none text-white">
                    <div class="card-body">
                        <div class="icon">
                            <div class="d-flex align-items-center align-self-start text-white">
                                <span class="mdi mdi-account-search icon-item text-white"></span>
                                <h3 class="pe-2 mb-0 fs-6">متقاضیان</h3>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-row justify-content-between">
                        <h4 class="card-title mb-1">مشخصات املاکی</h4>
                        <p class="text-muted mb-1">اطلاعات</p>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="preview-list">
                                <div class="preview-item border-bottom">
                                    <div class="preview-thumbnail">
                                        <div class="preview-icon bg-primary">
                                            <i class="mdi mdi-file-document"></i>
                                        </div>
                                    </div>
                                    <div class="preview-item-content d-sm-flex flex-grow">
                                        <div class="flex-grow">
                                            <h6 class="preview-subject">وضعیت :</h6>
                                            <p class="text-muted mb-0">توضیحات</p>
                                        </div>
                                        <div class="me-auto text-sm-right pt-2 pt-sm-0 text-start">
                                            <p class="text-white">
                                                {!!  $user->businessUser()->first()->is_accepted ?
                                                    '<span class="text-success">تایید شده</span>' : '<span class="text-danger">در انتظار تایید</span>'!!}
                                            </p>
                                            <p class="text-muted mb-0">مورد تایید قرار گرفتید یا خیر</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="preview-item border-bottom">
                                    <div class="preview-thumbnail">
                                        <div class="preview-icon bg-primary">
                                            <i class="mdi mdi-rename-box"></i>
                                        </div>
                                    </div>
                                    <div class="preview-item-content d-sm-flex flex-grow">
                                        <div class="flex-grow">
                                            <h6 class="preview-subject">نام املاکی :</h6>
                                            <p class="text-muted mb-0">مالک</p>
                                        </div>
                                        <div class="me-auto text-sm-right pt-2 pt-sm-0 text-start">
                                            <p class="text-white">{{$business->name}}</p>
                                            <p class="text-muted mb-0">{{$business->owner->name}}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="preview-item border-bottom">
                                    <div class="preview-thumbnail">
                                        <div class="preview-icon bg-success">
                                            <i class="mdi mdi-city"></i>
                                        </div>
                                    </div>
                                    <div class="preview-item-content d-sm-flex flex-grow">
                                        <div class="flex-grow">
                                            <h6 class="preview-subject">شهر :</h6>
                                            <p class="text-muted mb-0">منطقه</p>
                                        </div>
                                        <div class="me-auto text-sm-right pt-2 pt-sm-0 text-start">
                                            <p class="text-white">{{$business->city->name}}</p>
                                            <p class="text-muted mb-0">{{$business->area}}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="preview-item border-bottom">
                                    <div class="preview-thumbnail">
                                        <div class="preview-icon bg-warning">
                                            <i class="mdi mdi-city"></i>
                                        </div>
                                    </div>
                                    <div class="preview-item-content d-sm-flex flex-grow">
                                        <div class="flex-grow">
                                            <h6 class="preview-subject">ادرس :</h6>
                                            <p class="text-muted mb-0">تلفن</p>
                                        </div>
                                        <div class="me-auto text-sm-right pt-2 pt-sm-0 text-start">
                                            <p class="text-">{{$business->address}}</p>
                                            <p class="text-muted mb-0">{{$business->owner->number}}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="preview-item border-bottom">
                                    <div class="preview-thumbnail">
                                        <div class="preview-icon bg-info">
                                            <i class="mdi mdi-file-image"></i>
                                        </div>
                                    </div>
                                    <div class="preview-item-content d-sm-flex flex-grow">
                                        <div class="flex-grow">
                                            <h6 class="preview-subject">عکس :</h6>
                                            <p class="text-muted mb-0"></p>
                                        </div>
                                        <div class="me-auto text-sm-right pt-2 pt-sm-0 text-start">
                                            <p class="text-">
                                                <img src="{{asset(env('BUSINESS_IMAGES_UPLOAD_PATH')) .'/'. $business->image}}" width="50">
                                            </p>
                                            <p class="text-muted mb-0"></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="preview-item">
                                    <div class="preview-thumbnail">
                                        <div class="preview-icon bg-warning">
                                            <i class="mdi mdi-delete"></i>
                                        </div>
                                    </div>
                                    <div class="preview-item-content d-sm-flex flex-grow">
                                        <div class="flex-grow">
                                            <h6 class="preview-subject">لغو همکاری</h6>
                                            <p class="text-muted mb-0">توضیحات</p>
                                        </div>
                                        <div class="me-auto text-sm-right pt-2 pt-sm-0 text-start">
                                            <p class="text-white">
                                                <a href="{{route('consultant.leave.member',['user' => auth()->user()->id])}}" id="open_delete_panel" class="btn btn-outline-danger">لغو همکاری</a>
                                            </p>
                                            <p class="text-muted mb-0">لغو همکاری</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">تعداد فایل ها</h4>
                    <canvas id="transaction-history" class="transaction-chart"></canvas>
                    <div class="bg-gray-dark d-flex d-md-block d-xl-flex flex-row py-3 px-4 px-md-3 px-xl-4 rounded mt-3">
                        <div class="text-md-center text-xl-left">
                            <h6 class="mb-1">تعداد متقاضیان</h6>
                            <p class="text-muted mb-0">{{\Carbon\Carbon::now()}}</p>
                        </div>
                        <div class="align-self-center flex-grow text-right text-md-center text-xl-right py-md-2 py-xl-0">
                            <h6 class="font-weight-bold mb-0">{{$business->customers_count}}</h6>
                        </div>
                    </div>
                    <div class="bg-gray-dark d-flex d-md-block d-xl-flex flex-row py-3 px-4 px-md-3 px-xl-4 rounded mt-3">
                        <div class="text-md-center text-xl-left">
                            <h6 class="mb-1">تعداد مالکان</h6>
                            <p class="text-muted mb-0">{{\Carbon\Carbon::now()}}</p>
                        </div>
                        <div class="align-self-center flex-grow text-right text-md-center text-xl-right py-md-2 py-xl-0">
                            <h6 class="font-weight-bold mb-0">{{$business->landowners_count}}</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
