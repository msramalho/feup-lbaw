    <div class="modal fade hide" id="facModalEdit" tabindex="-1" role="dialog" aria-labelledby="facModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="facModalLabel">Edit Faculty</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">
                <form id="editFacForm">
                    {{csrf_field()}}
                    <input type="hidden" value="{{$faculty->university->id}}" name="university_id"/>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label>Name<span style="color : rgb(255,0,0);"> *</span></label>
                            <input type="text" class="form-control form-control-lg" name="name" placeholder="Faculty official name"  value="{{$faculty->name}}" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Faculty public description<span style="color : rgb(255,0,0);"> *</span></label>
                        <textarea class="form-control" name="description" id="editFacDescription" required>{!! $faculty->description !!}</textarea>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6 col-sm-12">
                            <label>City<span style="color : rgb(255,0,0);"> *</span></label>
                            <select class="custom-select" name="city_id" required>
                                <option selected>Select a city</option>
                                @foreach ($cities as $city)
                                    <option value="{{$city->id}}" {{$faculty->city_id == $city->id?"selected":""}}>{{$city->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-lg-3 col-md-12"></div>
                        <div class="form-group col-lg-3 col-md-6 col-sm-12">
                            <label>Save it</label>
                            <input type="submit" class="btn btn-primary form-control" value="Save" />
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer"></div>
        </div>
    </div>
</div>