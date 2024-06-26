@extends('layouts.home')

@section('title' , 'متقاضیان عمومی')

@section('head')
@endsection

@section('scripts')
@endsection

@section('content')
    <!-- ======= Hero Section ======= -->
    <section id="hero" class="d-flex align-items-center">
        <div class="container">
            <div class="row">
                <div
                    class="col-lg-6 d-flex flex-column justify-content-center pt-4 pt-lg-0 order-2 order-lg-1"
                    data-aos="fade-up"
                    data-aos-delay="200"
                >
                    <h1>متقاضیان عمومی</h1>
                </div>
                <div
                    class="col-lg-6 order-1 order-lg-2 hero-img"
                    data-aos="zoom-in"
                    data-aos-delay="100"
                >
                    <img
                        src="{{asset('Home/assets/img/4310987.png')}}"
                        class="img-fluid animated"
                        alt=""
                    />
                </div>
            </div>
        </div>
    </section>
    <!-- End Hero -->

    <div class="w-100 row border-bottom">
        @if($customers->isNotEmpty())
            <div class="col-12 mx-auto">
                <div class="px-5 py-5">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped text-center">
                            <thead>
                            <tr>
                                <th> شماره </th>
                                <th> نام املاکی </th>
                                <th> نوع </th>
                                <th> قبمت/رهن </th>
                                <th> متراژ </th>
                                <th> زمان باقیمانده </th>
                                <th> نمایش </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($customers as $key => $customer)
                                <tr>
                                    <td> {{$customers->firstItem() + $key}} </td>
                                    <td>
                                        @if($customer->business_id !== null)
                                        {{$customer->business->name}}
                                        @else
                                            {{$customer->name}}
                                        @endif
                                        @if($customer->getRawOriginal('status') == 'active')
                                            <span class="mdi mdi-checkbox-blank-circle text-success"></span>
                                        @elseif($customer->getRawOriginal('status') == 'unknown')
                                            <span class="mdi mdi-checkbox-blank-circle" style="color:#FFA500;"></span>
                                        @else
                                            <span class="mdi mdi-checkbox-blank-circle text-danger"></span>
                                        @endif
                                    </td>
                                    <td>{{$customer->type_sale}}</td>
                                    <td>{{$customer->getRawOriginal('selling_price') !== 0 ? $customer->selling_price : $customer->rahn_amount}}</td>
                                    <td>{{$customer->scale}}</td>
                                    <td>{{$customer->daysLeft ? $customer->daysLeft . ' روز' : 'منقضی'}} </td>
                                    <td><a class="btn text-decoration-none" href="{{route('customer.public.show',$customer->id)}}"><i class="mdi mdi-eye"></i></a></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{$customers->links('bootstrap-5-home')}}

                </div>
            </div>
        @else
            <div class="my-5 d-flex justify-content-center">
                <p>متقاضی وجود ندارد.</p>
            </div>
        @endif
    </div>
@endsection
