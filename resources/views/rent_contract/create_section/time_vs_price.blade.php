<div class="row">
    <div id="rahnDiv" class="form-group col-md-3">
        <label for="rahn_amount">رهن(تومان):</label>
        <input type="text" name="rahn_amount" class="form-control" value="{{old('rahn_amount')}}" id="rahn_amount" placeholder="رهن"
               onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))">
        @error('rahn_amount')
        <div class="alert-danger">{{$message}}</div>
        @enderror
    </div>
    <div id="rentDiv" class="form-group col-md-3">
        <label for="rent_amount">اجاره(تومان):</label>
        <input type="text" name="rent_amount" class="form-control" value="{{old('rent_amount')}}" id="rent_amount" placeholder="اجاره"
               onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))">
        @error('rent_amount')
        <div class="alert-danger">{{$message}}</div>
        @enderror
    </div>
    <div class="form-group col-md-3">
        <label for="contract_date">تاریخ عقد قرارداد:</label>
        <input type="text" name="contract_date" class="form-control" value="{{old('contract_date')}}" id="contract_date" placeholder="تاریخ عقد قرارداد"
               onkeypress="return false">
        @error('contract_date')
        <div class="alert-danger">{{$message}}</div>
        @enderror
    </div>
    <div class="form-group col-md-3">
        <label for="delivery_date">تاریخ تحویل ملک:</label>
        <input type="text" name="delivery_date" class="form-control" value="{{old('delivery_date')}}" id="delivery_date" placeholder="تاریخ تحویل ملک"
               onkeypress="return false">
        @error('delivery_date')
        <div class="alert-danger">{{$message}}</div>
        @enderror
    </div>
    <div class="form-group col-md-3">
        <label for="rent_date_from">تاریخ شروع قرارداد:</label>
        <input type="text" name="rent_date_from" class="form-control" value="{{old('rent_date_from')}}" id="rent_date_from" placeholder="تاریخ شروع قرارداد"
               onkeypress="return false">
        @error('rent_date_from')
        <div class="alert-danger">{{$message}}</div>
        @enderror
    </div>
    <div class="form-group col-md-3">
        <label for="rent_date_to">تاریخ پایان قرارداد:</label>
        <input type="text" name="rent_date_to" class="form-control" value="{{old('rent_date_to')}}" id="rent_date_to" placeholder="تاریخ پایان قرارداد"
               onkeypress="return false">
        @error('rent_date_to')
        <div class="alert-danger">{{$message}}</div>
        @enderror
    </div>
</div>
