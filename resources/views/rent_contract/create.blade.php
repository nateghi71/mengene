@extends('layouts.dashboard' , ['sectionName' => 'ایجاد قرارداد'])

@section('title' , 'ایجاد قرارداد')

@section('head')
@endsection

@section('scripts')
    <script src="{{asset('Admin/assets/js/jquery.validate.min.js')}}"></script>
    <script src="{{asset('Admin/assets/js/jquery.czMore-latest.js')}}"></script>
    <script>
        let current = 0;
        let tabs = $(".tab");
        let tabs_pill = $(".tab-pills");

        loadFormData(current);

        function loadFormData(n) {
            $(tabs_pill[n]).addClass("active");
            $(tabs[n]).removeClass("d-none");
            $("#back_button").attr("disabled", n == 0 ? true : false);
            n == tabs.length - 1
                ? $("#next_button").text("ایجاد قرارداد")
                : $("#next_button").text("بعدی")
        }

        $('#next_button').on('click', next)
        $('#back_button').on('click', back)

        function next(e) {
            e.preventDefault()

            if (current === (tabs.length - 1)) {
                this.form.submit()
            } else {
                $(tabs[current]).addClass("d-none");
                $(tabs_pill[current]).removeClass("active");

                current++;
                loadFormData(current);
            }
        }

        function back(e) {
            e.preventDefault()
            $(tabs[current]).addClass("d-none");
            $(tabs_pill[current]).removeClass("active");

            current--;
            loadFormData(current);
        }
        $("#czContainer").czMore({
            max: 4,
            min: 1,
        });
        $("#czContainer2").czMore();
        $("#czContainer3").czMore();
    </script>
@endsection

@section('content')
    <div class="card row">
        <div class="card-header">
            <nav class="nav nav-pills nav-fill">
                <span id="info_owner" class="nav-link tab-pills border-0">
                    اطلاعات موجر
                </span>
                <span id="info_cus" class="nav-link tab-pills border-0">
                    اطلاعات مستاجر
                </span>
                <span class="nav-link tab-pills border-0">
                    اطلاعات ملک
                </span>
                <span class="nav-link tab-pills border-0">
                    زمان و مبلغ قرارداد
                </span>
                <span class="nav-link tab-pills border-0">
                    تعهدات
                </span>
            </nav>
        </div>

        <div class="card-body px-5 py-4">
            <form action="{{route('rent_contracts.store')}}" method="post">
                @csrf
                <div class="tab d-none">
                    @include('rent_contract.create_section.landlord_info')
                </div>
                <div class="tab d-none">
                    @include('rent_contract.create_section.renter_info')
                </div>
                <div class="tab d-none">
                    @include('rent_contract.create_section.specs_estate')
                </div>
                <div class="tab d-none">
                    @include('rent_contract.create_section.time_vs_price')
                </div>
                <div class="tab d-none">
                    @include('rent_contract.create_section.obligations')
                </div>
                <div class="d-flex mt-4">
                    <button type="button" id="back_button" class="btn btn-primary">قبلی</button>
                    <button type="submit" id="next_button" class="btn btn-primary me-auto">بعدی</button>
                </div>

            </form>
        </div>
    </div>
@endsection
