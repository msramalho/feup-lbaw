    <div class="modal fade hide" id="uniModalEdit" tabindex="-1" role="dialog" aria-labelledby="uniModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit University</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">
                <form id="editUniForm">
                    {{csrf_field()}}
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label>Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-lg" name="name" placeholder="University official name" value="{{$university->name}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>University public description <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="description" id="editUniDescription">{!! $university->description !!}</textarea>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6 col-sm-12">
                            <label for="uniCountry">Country <span class="text-danger">*</span></label>
                            <select class="custom-select" name="country_id" required>
                                <option selected>Select a country</option>
                                @foreach ($countries as $country)
                                    <option value="{{$country->id}}" {{$university->country_id == $country->id?"selected":""}}>{{$country->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-lg-3 col-md-12"></div>
                        <div class="form-group col-lg-3 col-md-6 col-sm-12">
                            <label for="uniSubmit">Save it</label>
                            <input type="submit" class="btn btn-primary form-control" value="Save" />
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer"></div>
        </div>
    </div>
</div>