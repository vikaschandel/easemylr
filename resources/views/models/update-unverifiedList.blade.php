<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Vehicle No.</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <form id="updt_vehicle" method="post">
                <input type="hidden" class="form-control" id="consignment_id" name="consignment_id" placeholder=""
                    value="">
                    <div class="form-group my-3">
                            <label for="location_name">Vehicle No.</label>
                            <select class="form-control" id="vehicle_no" name="vehicle_id" tabindex="-1">
                            <option value="">Select vehicle no</option>
                            @foreach($vehicles as $vehicle)
                            <option value="{{$vehicle->id}}">{{$vehicle->regn_no}}
                            </option>
                            @endforeach
                        </select>
                            
                        </div>
            </div>
           
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
            </form>
        </div>
    </div>
</div>