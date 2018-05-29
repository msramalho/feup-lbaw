    <div class="modal fade hide" id="facModal" tabindex="-1" role="dialog" aria-labelledby="facModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="facModalLabel">New Faculty</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">
                <form id="newFacForm">
                <fieldset>
                    {{csrf_field()}}
                    <input type="hidden" value="{{$university->id}}" name="university_id"/>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="name">Name <span class="text-danger">*</span></label>
                            <input id="name" type="text" class="form-control form-control-lg" name="name" placeholder="Faculty official name" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="facDescription">Faculty public description <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="description" id="facDescription"></textarea>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6 col-sm-12">
                            <label for="city">City <span class="text-danger">*</span></label>
                            <select id="city" class="custom-select" name="city_id" required>
                                <option selected>Select a city</option>
                                @foreach ($cities as $city)
                                    <option value="{{$city->id}}">{{$city->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-lg-3 col-md-12"></div>
                        <div class="form-group col-lg-3 col-md-6 col-sm-12">
                            <label for="save">Save it</label>
                            <input id="save" type="submit" class="btn btn-primary form-control" value="Save" />
                        </div>
                    </div>
                </fieldset>
                </form>
            </div>
            <div class="modal-footer"></div>
        </div>
    </div>
</div>