@extends('layouts.home')

@section('title' , 'مالکان عمومی')

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
                    <h1>مالکان عمومی</h1>
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
        @if($landowners->isNotEmpty())
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
                        @foreach($landowners as $key => $landowner)
                            <tr>
                                <td> {{$landowners->firstItem() + $key}} </td>
                                <td>
                                    @if($landowner->business_id !== null)
                                        {{$landowner->business->name}}
                                    @else
                                        {{$landowner->name}}
                                    @endif

                                    @if($landowner->getRawOriginal('status') == 'active')
                                        <span class="mdi mdi-checkbox-blank-circle text-success"></span>
                                    @elseif($landowner->getRawOriginal('status') == 'unknown')
                                        <span class="mdi mdi-checkbox-blank-circle" style="color:#FFA500;"></span>
                                    @else
                                        <span class="mdi mdi-checkbox-blank-circle text-danger"></span>
                                    @endif
                                </td>
                                <td>{{$landowner->type_sale}}</td>
                                <td>{{$landowner->getRawOriginal('selling_price') !== 0 ? $landowner->selling_price : $landowner->rahn_amount}}</td>
                                <td>{{$landowner->scale}}</td>
                                <td>{{$landowner->daysLeft ? $landowner->daysLeft . ' روز' : 'منقضی'}} </td>
                                <td><a class="btn text-decoration-none" href="{{route('landowner.public.show',$landowner->id)}}"><i class="mdi mdi-eye"></i></a></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                {{$landowners->links('bootstrap-5-home')}}
            </div>
        </div>
        @else
            <div class="my-5 d-flex justify-content-center">
                <p>مالکی وجود ندارد.</p>
            </div>
        @endif

    </div>
@endsection
