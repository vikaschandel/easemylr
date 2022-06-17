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
                            <input class="form-control" id="name" name="name" placeholder="Enter location name">
                        </div>
                        <div class="form-group my-3">
                            <input class="form-control" id="nick_name" name="nick_name" placeholder="Enter nick name">
                        </div>
                        <div class="form-group my-3">
                            <input class="form-control" id="team_id" name="team_id" placeholder="Enter team id">
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