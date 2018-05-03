    <div class="modal fade hide" id="uniModal" tabindex="-1" role="dialog" aria-labelledby="uniModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uniModalLabel">New University</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">
                <form id="newUniForm">
                    {{csrf_field()}}
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label>Name</label>
                            <input type="text" class="form-control form-control-lg" name="name" placeholder="University official name" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>University public description</label>
                        <textarea class="form-control" name="description" id="uniDescription" required></textarea>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6 col-sm-12">
                            <label for="uniCountry">Country</label>
                            <select class="custom-select" name="country_id" required>
                                <option selected>Select a country</option>
                                @foreach ($countries as $country)
                                    <option value="{{$country->id}}">{{$country->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-lg-3 col-md-12"></div>
                        <div class="form-group col-lg-3 col-md-6 col-sm-12">
                            <label for="uniSubmit">Save it</label>
                            <input type="submit" class="btn btn-primary form-control" id="uniSubmit" value="Save" />
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer"></div>
        </div>
    </div>
</div>