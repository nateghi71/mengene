<div id="czContainer2">
    <div id="first">
        <div class="recordset">
            <div class="row border p-3">
                <div class="row">
                    <input type="hidden" name="user_type" value="renter">
                    <div class="form-group col-md-3">
                        <label for="name_1_renter"> نام مستاجر:</label>
                        <input type="text" name="renter[name][]" class="form-control" id="name_1_renter" value="{{old('renter[name][]')}}" placeholder="نام">
                        @error('renter[name][]')
                        <div class="alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-3">
                        <label for="father_1_renter"> فرزند:</label>
                        <input type="text" name="renter[father][]" class="form-control" id="father_1_renter" value="{{old('renter[father][]')}}" placeholder="فرزند">
                        @error('renter[father][]')
                        <div class="alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-3">
                        <label for="certificateNumber_1_renter"> شماره شناسنامه:</label>
                        <input type="text" name="renter[certificateNumber][]" class="form-control" id="certificateNumber_1_renter" value="{{old('renter[certificateNumber][]')}}" placeholder="شماره شناسنامه">
                        @error('renter[certificateNumber][]')
                        <div class="alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-3">
                        <label for="certificateIssuedBy_1_renter"> شناسنامه صادره از:</label>
                        <input type="text" name="renter[certificateIssuedBy][]" class="form-control" id="certificateIssuedBy_1_renter" value="{{old('renter[certificateIssuedBy][]')}}" placeholder="شناسنامه صادره از">
                        @error('renter[certificateIssuedBy][]')
                        <div class="alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-3">
                        <label for="nationalCode_1_renter"> کد ملی:</label>
                        <input type="text" name="renter[nationalCode][]" class="form-control" id="nationalCode_1_renter" value="{{old('renter[nationalCode][]')}}" placeholder="کد ملی">
                        @error('renter[nationalCode][]')
                        <div class="alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-3">
                        <label for="bornAt_1_renter"> متولد:</label>
                        <input type="text" name="renter[bornAt][]" class="form-control" id="bornAt_1_renter" value="{{old('renter[bornAt][]')}}" placeholder="متولد">
                        @error('renter[bornAt][]')
                        <div class="alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-3">
                        <label for="residentAt_1_renter"> ساکن:</label>
                        <input type="text" name="renter[residentAt][]" class="form-control" id="residentAt_1_renter" value="{{old('renter[residentAt][]')}}" placeholder="ساکن">
                        @error('renter[residentAt][]')
                        <div class="alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-3">
                        <label for="phoneNumber_1_renter"> شماره تلفن:</label>
                        <input type="text" name="renter[phoneNumber][]" class="form-control" id="phoneNumber_1_renter" value="{{old('renter[phoneNumber][]')}}" placeholder="شماره تلفن">
                        @error('renter[phoneNumber][]')
                        <div class="alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-3">
                        <label for="other_1_renter">وکالت:</label>
                        <select class="form-control" name="renter[other][]" id="other_2">
                            <option value="noting" @selected(old('renter[other][]') == 'noting')>هیچ کدام</option>
                            <option value="advocacy" @selected(old('renter[other][]') == 'advocacy')>وکالت</option>
                            <option value="guardianship" @selected(old('renter[other][]') == 'guardianship')>قیومیت</option>
                            <option value="administration" @selected(old('renter[other][]') == 'administration')>وصایت</option>
                        </select>
                        @error('renter[other][]')
                        <div class="alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-3">
                        <label for="advocacyName_1_renter"> نام:</label>
                        <input type="text" name="renter[advocacyName][]]" class="form-control" id="advocacyName_1_renter" value="{{old('renter[advocacyName][]')}}" placeholder="نام">
                        @error('renter[advocacyName][]')
                        <div class="alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-3">
                        <label for="advocacyFather_1_renter"> فرزند:</label>
                        <input type="text" name="renter[advocacyFather][]" class="form-control" id="advocacyFather_1_renter" value="{{old('renter[advocacyFather][]')}}" placeholder="فرزند">
                        @error('renter[advocacyFather][]')
                        <div class="alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-3">
                        <label for="advocacyCertificateNumber_1_renter"> شماره شناسنامه:</label>
                        <input type="text" name="renter[advocacyCertificateNumber][]" class="form-control" id="advocacyCertificateNumber_1_renter" value="{{old('renter[advocacyCertificateNumber][]')}}" placeholder="شماره شناسنامه">
                        @error('renter[advocacyCertificateNumber][]')
                        <div class="alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-3">
                        <label for="advocacyBornAt_1_renter"> متولد:</label>
                        <input type="text" name="renter[advocacyBornAt][]" class="form-control" id="advocacyBornAt_1_renter" value="{{old('renter[advocacyBornAt][]')}}" placeholder="متولد">
                        @error('renter[advocacyBornA][]')
                        <div class="alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-3">
                        <label for="advocacyForReason_1_renter"> به موجب:</label>
                        <input type="text" name="renter[advocacyForReason][]" class="form-control" id="advocacyForReason_1_renter" value="{{old('renter[advocacyForReason][]')}}" placeholder="به موجب">
                        @error('renter[advocacyForReason][]')
                        <div class="alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

