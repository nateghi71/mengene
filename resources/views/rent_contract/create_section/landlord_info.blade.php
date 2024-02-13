<div id="czContainer">
    <div id="first">
        <div class="recordset">
            <div class="row border p-3">
                <div class="row">
                    <input type="hidden" name="user_type" value="landlord">
                    <div class="form-group col-md-3">
                        <label for="name_1_landlord"> نام موجر:</label>
                        <input type="text" name="landlord[name][]" class="form-control" id="name_1_landlord" value="{{old('landlord[name][]')}}" placeholder="نام">
                        @error('landlord[name][]')
                        <div class="alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-3">
                        <label for="father_1_landlord"> فرزند:</label>
                        <input type="text" name="landlord[father][]" class="form-control" id="father_1_landlord" value="{{old('landlord[father][]')}}" placeholder="فرزند">
                        @error('landlord[father][]')
                        <div class="alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-3">
                        <label for="certificateNumber_1_landlord"> شماره شناسنامه:</label>
                        <input type="text" name="landlord[certificateNumber][]" class="form-control" id="certificateNumber_1_landlord" value="{{old('landlord[certificateNumber][]')}}" placeholder="شماره شناسنامه">
                        @error('landlord[certificateNumber][]')
                        <div class="alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-3">
                        <label for="certificateIssuedBy_1_landlord"> شناسنامه صادره از:</label>
                        <input type="text" name="landlord[certificateIssuedBy][]" class="form-control" id="certificateIssuedBy_1_landlord" value="{{old('landlord[certificateIssuedBy][]')}}" placeholder="شناسنامه صادره از">
                        @error('landlord[certificateIssuedBy][]')
                        <div class="alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-3">
                        <label for="nationalCode_1_landlord"> کد ملی:</label>
                        <input type="text" name="landlord[nationalCode][]" class="form-control" id="nationalCode_1_landlord" value="{{old('landlord[nationalCode][]')}}" placeholder="کد ملی">
                        @error('landlord[certificateIssuedBy][]')
                        <div class="alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-3">
                        <label for="bornAt_1_landlord"> متولد:</label>
                        <input type="text" name="landlord[bornAt][]" class="form-control" id="bornAt_1_landlord" value="{{old('landlord[bornAt][]')}}" placeholder="متولد">
                        @error('landlord[bornAt][]')
                        <div class="alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-3">
                        <label for="residentAt_1_landlord"> ساکن:</label>
                        <input type="text" name="landlord[residentAt][]" class="form-control" id="residentAt_1_landlord" value="{{old('landlord[residentAt][]')}}" placeholder="ساکن">
                        @error('landlord[residentAt][]')
                        <div class="alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-3">
                        <label for="phoneNumber_1_landlord"> شماره تلفن:</label>
                        <input type="text" name="landlord[phoneNumber][]" class="form-control" id="phoneNumber_1_landlord" value="{{old('landlord[phoneNumber][]')}}" placeholder="شماره تلفن">
                        @error('landlord[phoneNumber][]')
                        <div class="alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-3">
                        <label for="other_1_landlord">وکالت:</label>
                        <select class="form-control" name="landlord[other][]" id="other_1_landlord">
                            <option value="noting" @selected(old('landlord[other][]') == 'noting')>هیچ کدام</option>
                            <option value="advocacy" @selected(old('landlord[other][]') == 'advocacy')>وکالت</option>
                            <option value="guardianship" @selected(old('landlord[other][]') == 'guardianship')>قیومیت</option>
                            <option value="administration" @selected(old('landlord[other][]') == 'administration')>وصایت</option>
                        </select>
                        @error('landlord[other][]')
                        <div class="alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-3">
                        <label for="advocacyName_1_landlord"> نام:</label>
                        <input type="text" name="landlord[advocacyName][]" class="form-control" id="advocacyName_1_landlord" value="{{old('landlord[advocacyName][]')}}" placeholder="نام">
                        @error('landlord[advocacyName][]')
                        <div class="alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-3">
                        <label for="advocacyFather_1_landlord"> فرزند:</label>
                        <input type="text" name="landlord[advocacyFather][]" class="form-control" id="advocacyFather_1_landlord" value="{{old('landlord[advocacyFather][]')}}" placeholder="فرزند">
                        @error('landlord[advocacyFather][]')
                        <div class="alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-3">
                        <label for="advocacyCertificateNumber_1_landlord"> شماره شناسنامه:</label>
                        <input type="text" name="landlord[advocacyCertificateNumber][]" class="form-control" id="advocacyCertificateNumber_1_landlord" value="{{old('landlord[advocacyCertificateNumber][]')}}" placeholder="شماره شناسنامه">
                        @error('landlord[advocacyCertificateNumber][]')
                        <div class="alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-3">
                        <label for="advocacyBornAt_1_landlord"> متولد:</label>
                        <input type="text" name="landlord[advocacyBornAt][]" class="form-control" id="advocacyBornAt_1_landlord" value="{{old('landlord[advocacyBornAt][]')}}" placeholder="متولد">
                        @error('landlord[advocacyBornAt][]')
                        <div class="alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-3">
                        <label for="advocacyForReason"> به موجب:</label>
                        <input type="text" name="landlord[advocacyForReason][]" class="form-control" id="advocacyForReason_1_landlord" value="{{old('landlord[advocacyForReason][]')}}" placeholder="به موجب">
                        @error('landlord[advocacyForReason][]')
                        <div class="alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
