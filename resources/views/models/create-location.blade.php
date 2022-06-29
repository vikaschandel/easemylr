<div class="modal" id="location-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- <button type="button" class="close" data-dismiss="modal"><img src="{{asset('assets/images/close-bottle.png')}}" class="img-fluid"></button> -->
            <!-- Modal Header -->
            <form class="general_form" method="POST" action="{{url($prefix.'/locations')}}" id="createlocation">
                @csrf
                <input type="hidden" class="locationid" value="" name="id">
                <!-- <input type="hidden" value="locationpage" name="locationpage"> -->
                <div class="modal-header text-center">
                    <h4 class="modal-title">Location</h4>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                        <!-- <h5>Wine Style</h5> -->
                        <div class="form-group my-3">
                            <label for="location_name">Location Name</label>
                            <input class="form-control" id="name" name="name" placeholder="">
                        </div>
                        <div class="form-group my-3">
                            <label for="location_name">Location Nick Name</label>
                            <input class="form-control" id="nick_name" name="nick_name" placeholder="">
                        </div>
                        <div class="form-group my-3">
                            <label for="location_name">Team ID</label>
                            <input class="form-control" id="team_id" name="team_id" placeholder="">
                        </div>
                        <div class="form-group my-3">
                            <label for="location_name"> Consignment No.</label>
                            <input class="form-control" id="consignment_no" name="consignment_no" placeholder="" maxlength="4">
                        </div>
                </div>
            <!-- Modal footer -->
                <div class="modal-footer">
                    <div class="btn-section w-100 P-0">
                        <button type="submit" id="location_savebtn" class="btn-cstm btn-white btn btn-primary btn-modal">Add</button>
                        <a class="btn btn-primary btn-modal" data-dismiss="modal">Cancel</a>
                    </div>
                </div>
            </form> 
        </div>
    </div>
</div>