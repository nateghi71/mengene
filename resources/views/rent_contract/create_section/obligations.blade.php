<div id="czContainer3">
    <div id="first">
        <div class="recordset">
            <div class="row border p-3">
                <div class="form-group">
                    <textarea name="description" class="form-control" id="description" placeholder="توضیحات" rows="3">{{old('description')}}</textarea>
                    @error('description')
                    <div class="alert-danger">{{$message}}</div>
                    @enderror
                </div>
            </div>
        </div>
    </div>
</div>

