jQuery(document).ready(function(){

	/*======== check box checked create/update user permission page  ========*/
    jQuery(document).on('click','#ckbCheckAll',function(){
        if(this.checked){
            jQuery('#dropdownMenuButton').prop('disabled', false);
            jQuery('.chkBoxClass').each(function(){
                this.checked = true;
            });
        }
        else{
            jQuery('.chkBoxClass').each(function(){
                this.checked = false;
            });
            jQuery('#dropdownMenuButton').prop('disabled', true);
        }
    });

    jQuery(document).on('click','.chkBoxClass',function(){
        if($('.chkBoxClass:checked').length == $('.chkBoxClass').length){
            $('#ckbCheckAll').prop('checked',true);
            jQuery('#dropdownMenuButton').prop('disabled', false);
        }else{
            var checklength = $('.chkBoxClass:checked').length;
            if(checklength < 1){
                jQuery('#dropdownMenuButton').prop('disabled', true);
            }else{
                 jQuery('#dropdownMenuButton').prop('disabled', false);
            }
            $('#ckbCheckAll').prop('checked',false);
        }
    });
 	/*===== End check box checked create/update user permission page =====*/

    /*===== For create/update consigner/consignee page  =====*/
    $(document).on('keyup', "#gst_number",function () {
        $gstno = $(this).val().toUpperCase();
        $gstno = $gstno.replace(/[^A-Z0-9]/g, '');
        $('#gst_number').val($gstno);
    });

    /*===== For create/update vehicle page =====*/
    $(document).on('keyup', "#regn_no",function () {
        $regn_no = $(this).val().toUpperCase();
        $regn_no = $regn_no.replace(/[^A-Z0-9]/g, '');
        $(this).val($regn_no);
    });

     /*===== Delete Branch =====*/
    jQuery(document).on('click', '.delete_branch', function(){
        jQuery('#deletebranch').modal('show');
        var branchid =  jQuery(this).attr('data-id');
        var url =  jQuery(this).attr('data-action');
        jQuery(document).off('click','.deletebranchconfirm').on('click', '.deletebranchconfirm', function(){
           
            jQuery.ajax({
                type      : 'post',
                url       : url,
                data      : {branchid:branchid},
                headers   : {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType : "JSON",
                success:function(response){
                    if(response.success){
                        jQuery("#branchtable").load(" #branchtable");
                        jQuery("#deletebranch").modal("hide");
                    }
                    else{
                        jQuery("#deletebranch").modal("hide");
                        jQuery('html,body').animate({ scrollTop: 0 }, 'slow');
                        jQuery('.branch_error').show();
                        setTimeout(function(){
                         jQuery('.branch_error').fadeOut();
                       },5000);
                    }
                }
            });
        });
    });
 	/*===== End delete Branch =====*/

    /*===== delete Consigner =====*/
    jQuery(document).on('click', '.delete_consigner', function(){
        jQuery('#deleteconsigner').modal('show');
        var consignerid =  jQuery(this).attr('data-id');
        var url =  jQuery(this).attr('data-action');
        jQuery(document).off('click','.deleteconsignerconfirm').on('click', '.deleteconsignerconfirm', function(){
           
            jQuery.ajax({
                type      : 'post',
                url       : url,
                data      : {consignerid:consignerid},
                headers   : {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType : "JSON",
                success:function(data){
                    if(data){
                        jQuery("#consignertable").load(" #consignertable");
                        jQuery("#deleteconsigner").modal("hide");
                    }
                }
            });
        });
    });
    /*===== End delete Consigner =====*/

    /*===== delete Consignee =====*/
    jQuery(document).on('click', '.delete_consignee', function(){
        jQuery('#deleteconsignee').modal('show');
        var consigneeid =  jQuery(this).attr('data-id');
        var url =  jQuery(this).attr('data-action');
        jQuery(document).off('click','.deleteconsigneeconfirm').on('click', '.deleteconsigneeconfirm', function(){
           
            jQuery.ajax({
                type      : 'post',
                url       : url,
                data      : {consigneeid:consigneeid},
                headers   : {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType : "JSON",
                success:function(data){
                    if(data){
                        jQuery("#consigneetable").load(" #consigneetable");
                        jQuery("#deleteconsignee").modal("hide");
                    }
                }
            });
        });
    });
    /*===== End delete Consignee =====*/

    /*===== delete Broker =====*/
    jQuery(document).on('click', '.delete_broker', function(){
        jQuery('#deletebroker').modal('show');
        var brokerid =  jQuery(this).attr('data-id');
        var url =  jQuery(this).attr('data-action');
        jQuery(document).off('click','.deletebrokerconfirm').on('click', '.deletebrokerconfirm', function(){
           
            jQuery.ajax({
                type      : 'post',
                url       : url,
                data      : {brokerid:brokerid},
                headers   : {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType : "JSON",
                success:function(data){
                    if(data){
                        jQuery("#brokertable").load(" #brokertable");
                        jQuery("#deletebroker").modal("hide");
                    }
                }
            });
        });
    });
    /*===== End delete Broker =====*/

    /*===== delete Driver =====*/
    jQuery(document).on('click', '.delete_driver', function(){
        jQuery('#deletedriver').modal('show');
        var driverid =  jQuery(this).attr('data-id');
        var url =  jQuery(this).attr('data-action');
        jQuery(document).off('click','.deletedriverconfirm').on('click', '.deletedriverconfirm', function(){
           
            jQuery.ajax({
                type      : 'post',
                url       : url,
                data      : {driverid:driverid},
                headers   : {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType : "JSON",
                success:function(data){
                    if(data){
                        jQuery("#drivertable").load(" #drivertable");
                        jQuery("#deletedriver").modal("hide");
                    }
                }
            });
        });
    });
    /*===== End delete Driver =====*/

    // branch image add more    
    $(".add_more_images").click(function(){
       
        var c = $('.images').length;
        c  = c + 1;
        var rows = '';
        if(x < max_fields){ //max input box allowed
            x++; //text box increment

            rows+='<div class="images mt-3 col-md-2"><div class="row">';
            rows+='<div class="col-md-2">';
            rows+='<input type="file" data-id="'+c+'" name="files[]" class="first"/>';
            rows+='<p style="display:none;color:red" class="gif-errormsg'+c+'">Invalid image format</p>';
            rows+='</div>';
            rows+='<a href="javascript:void(0)" class="btn-danger remove_field" style="margin: 5px 0 0 160px">';
            rows+='<i class="ml-2 fa fa-trash"></a>';
            rows+='</div></div>'; 
            
            $('.branch-image').append(rows);

        }
        else{
            $("#error-msg").css("display", "block");
            // $(".add_more_images").css("display", "none");
            $(".add_more_images").attr("disabled", true);
        }
        var html = $("#branch-upload").html();
        $(".after-add-more").after(html);
        $(".change").append("<label for=''>&nbsp;</label><br/><a class='btn btn-danger remove'>- Remove</a>");
    });

    $('input[type="file"]').change(function(event) {
        var _size = this.files[0].size;
        var exactSize = Math.round(_size/(1024*1024));
        //console.log('FILE SIZE = ',exactSize);
        if (exactSize >="5") {
           $("#size-error").show();
        }
        else {
           $("#size-error").hide();
        }
    });

    // Delete branch Image from updatebranch view //
    $(document).on('click', '.deletebranchimg', function () {
        let id = $(this).attr('data-id');
        $("#deletebranchimgpop").modal('show');
        jQuery('.deletebranchimgdata').attr('data-id',id);
    });

    ///// Delete branch Image Method /////
    $('body').on('click', '.deletebranchimgdata', function () {
        let id  = jQuery(this).attr('data-id');
        var url = jQuery(this).attr('data-action');

        jQuery.ajax({
            type     : "post",
            data     : {branchimgid:id},
            url      : url,
            dataType : "JSON",
            headers  : {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success : function (data) {
                if(data){
                    jQuery("#deletebranchimgpop").modal("hide");
                    location.reload();
                }
            }
        });
    });

  	/*===== delete User =====*/
    jQuery(document).on('click', '.delete_user', function(){
        jQuery('#deleteuser').modal('show');
        var userid =  jQuery(this).attr('data-id');
        var url =  jQuery(this).attr('data-action');
        jQuery(document).off('click','.deleteuserconfirm').on('click', '.deleteuserconfirm', function(){
           
            jQuery.ajax({
                type      : 'post',
                url       : url,
                data      : {userid:userid},
                headers   : {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType : "JSON",
                success:function(data){
                    if(data){
                        jQuery("#usertable").load(" #usertable");
                        jQuery("#deleteuser").modal("hide");
                    }
                }
            });
        });
    });
 	/*===== End delete User =====*/

     /*===== delete vehicle =====*/
    jQuery(document).on('click', '.delete_vehicle', function(){
        jQuery('#deletevehicle').modal('show');
        var vehicleid =  jQuery(this).attr('data-id');
        var url =  jQuery(this).attr('data-action');
        jQuery(document).off('click','.deletevehicleconfirm').on('click', '.deletevehicleconfirm', function(){
            jQuery.ajax({
                type      : 'post',
                url       : url,
                data      : {vehicleid:vehicleid},
                headers   : {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType : "JSON",
                success:function(data){
                    if(data){
                        jQuery("#usertable").load(" #usertable");
                        jQuery("#deletevehicle").modal("hide");
                    }
                }
            });
        });
    });
 	/*===== End delete vehicle =====*/

    /*===== get driver detail on create vehicle page =====*/
    // not use yet this function
    $('#vehicle_driver').change(function(e){
        $('#driver_dl_no').val('');
        $('#driver_mobile_no').val('');
        let driver_id = $(this).val();
        getDrivers(driver_id);
    });

    function getDrivers(driver_id){
        $.ajax({
            type      : 'get',
            url       : APP_URL+'/get_drivers',
            data      : {driver_id:driver_id},
            headers   : {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType  : 'json',
            success:function(res){
                if(res.data){
                // $.each(res.data,function(key,value){
                    $('#driver_dl_no').val(res.data.license_number);
                    $('#driver_mobile_no').val(res.data.phone);
                // });
                }
                
            }
        });
    }
    /*===== End get driver detail on create vehicle page =====*/

    /*===== get consigner address on create consignment page =====*/
    $('#select_consigner').change(function(e){
        let consigner_id = $(this).val();
        getConsigners(consigner_id);
    });

    function getConsigners(consigner_id){
        $.ajax({
            type      : 'get',
            url       : APP_URL+'/get_consigners',
            data      : {consigner_id:consigner_id},
            headers   : {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType  : 'json',
            success:function(res){
                if(res.data){
                    $('#consigner_address').append('<strong>'+res.data.address+' </strong><br/><strong>GST No. : </strong>'+res.data.gst_number+'<br/><strong>Phone No. : </strong>'+res.data.phone+'');
                    $("#dispatch").val(res.data.city);
                }
            }
        });
    }

    /*===== get consignee address on create consignment page =====*/
    $('#select_consignee').change(function(e){
        let consignee_id = $(this).val();
        getConsignees(consignee_id);
    });

    function getConsignees(consignee_id){
        $.ajax({
            type      : 'get',
            url       : APP_URL+'/get_consignees',
            data      : {consignee_id:consignee_id},
            headers   : {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType  : 'json',
            success:function(res){
                if(res.data){
                    $('#consignee_address').append('<strong>'+res.data.address_line1 +', </strong><br/>'+res.data.address_line2+', '+res.data.address_line3+'<br/><strong>GST No. : </strong>'+res.data.gst_number+'<br/><strong>Phone No. : </strong>'+res.data.phone+'');
                }
            }
        });
    }

    $('#select_ship_to').change(function(e){
        let consignee_id = $(this).val();
        getShipto(consignee_id);
    });

    function getShipto(consignee_id){
        $.ajax({
            type      : 'get',
            url       : APP_URL+'/get_consignees',
            data      : {consignee_id:consignee_id},
            headers   : {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType  : 'json',
            success:function(res){
                if(res.data){
                    $('#ship_to_address').append('<strong>'+res.data.address_line1 +' </strong><br/>'+res.data.address_line2+', '+res.data.address_line3+'<br/><strong>GST No. : </strong>'+res.data.gst_number+'<br/><strong>Phone No. : </strong>'+res.data.phone+'');
                }
            }
        });
    }

    $("#selwarehouse").on('change', function() {
        $('#consignment_no').val('');
        var con_no = $('#consignment_no').val();
        var current_series = $("#selwarehouse option:selected").val();
        $("#consignment_no").val(current_series+con_no);
    });

    // Add Another Row
    $(document).on('click', '.insert-more', function(){
        $("#items_table").each(function() {
            var tds = '<tr>';
            var item_no = $('tr', this).length;
            tds += '<td><div class="srno">'+item_no+'</div></td>';
            tds += '<td><div class="form-group"><input type="text" class="form-control sel1" id="description'+item_no+'" value="Pesticides" name="data['+item_no+'][description]" list="json-datalist" onkeyup="showResult(this.value)"><datalist id="json-datalist"></datalist></div></td>';
            tds += '<td><div class="form-group"><input type="text" class="form-control mode" id="mode'+item_no+'" value="Case/s" name="data['+item_no+'][packing_type]"></div></td>'
            tds += '<td> <input type="number" class="form-control qnt" name="data['+item_no+'][quantity]"></td>';
            tds += '<td> <input type="number" class="form-control net" name="data['+item_no+'][weight]"></td>';
            tds += '<td> <input type="number" class="form-control gross" name="data['+item_no+'][gross_weight]"></td>';
            tds += '<td> <input type="text" class="form-control frei" name="data['+item_no+'][freight]"></td>';
            tds += '<td><div class="form-group"><select class="form-control term" name="data['+item_no+'][payment_type]"><option value=""></option><option value="To be Billed">To be Billed</option><option value="To Pay">To Pay</option><option value="Paid">Paid</option></select></div></td>'
            tds += '<td><button type="button" class="btn btn-default btn-rounded insert-more"> + </button><button type="button" class="btn btn-default btn-rounded remove-row"> - </button></td>';
            tds += '</tr>';
            if ($('tbody', this).length > 0) {
                $('tbody', this).append(tds);
            } else {
                $(this).append(tds);
            }
        });
    });

    //Remove the current row
    $(document).on('click', '.remove-row', function(){
        var current_val = $(this).parent().siblings(":first").text();
        $(this).closest('tr').remove();
        reassign_ids();
        calculate_totals();
    });

    //Reassign the Ids of the row
    function reassign_ids(){
        var i = 0;
        var t = document.getElementById('items_table');
        $("#items_table tr").each(function() {
            var srno = $(t.rows[i].cells[0]).text();
            if ( (srno == '#') || (parseInt(srno) == 1) ){
                i++;
            }
            if (parseInt(srno) >= 2) {
                $(t.rows[i].cells[0]).html(i);
                $(t.rows[i]).closest('tr').find('.sel1').attr('name', 'data['+i+'][description]');
                $(t.rows[i]).closest('tr').find('.mode').attr('name', 'data['+i+'][packing_type]');
                $(t.rows[i]).closest('tr').find('.qnt').attr('name', 'data['+i+'][quantity]');
                $(t.rows[i]).closest('tr').find('.net').attr('name', 'data['+i+'][weight]');
                $(t.rows[i]).closest('tr').find('.gross').attr('name', 'data['+i+'][gross_weight]');
                $(t.rows[i]).closest('tr').find('.frei').attr('name', 'data['+i+'][freight]');
                $(t.rows[i]).closest('tr').find('.term').attr('name', 'data['+i+'][payment_type]');
                i++;
            }
        });
    }
    //Call the calculate total function
    $(document).on('keyup', '.qnt, .net, .gross, .frei', function(){
        calculate_totals();
    });

    // Calculate all totals
    function calculate_totals(){
        var rowCount = $('#items_table tr').length;
        var total_quantity = 0;
        var total_net_weight = 0;
        var total_gross_weight = 0;
        var total_freight = 0;

        for (var w=1; w<rowCount; w++) {
            var qty = (!$('[name="data['+w+'][quantity]"]').val()) ? 0 : parseInt($('[name="data['+w+'][quantity]"]').val());
            var ntweight = (!$('[name="data['+w+'][weight]"]').val()) ? 0 : parseInt($('[name="data['+w+'][weight]"]').val());
            var grweight = (!$('[name="data['+w+'][gross_weight]"]').val()) ? 0 : parseInt($('[name="data['+w+'][gross_weight]"]').val());
            var frt = (!$('[name="data['+w+'][freight]"]').val()) ? 0 : parseInt($('[name="data['+w+'][freight]"]').val());
            total_quantity += qty;
            total_net_weight += ntweight;
            total_gross_weight += grweight;
            total_freight += frt;
        }
        $('#tot_qty').html(total_quantity);
        $('#tot_nt_wt').html(total_net_weight);
        $('#tot_gt_wt').html(total_gross_weight);
        $('#tot_frt').html(total_freight);

        $('#total_quantity').val(total_quantity);
        $('#total_weight').val(total_net_weight);
        $('#total_gross_weight').val(total_gross_weight);
        $('#total_freight').val(total_freight);
    }

    /*===== get location on edit click =====*/
    jQuery(document).on('click','.editlocation',function(){
        var locationid = jQuery(this).attr('data-id');
        jQuery('.locationid').val(locationid);
        var action = jQuery(this).attr('data-action');
        jQuery.ajax({
            type      : 'post',
            url       : action,
            data      : {locationid:locationid},
            headers   : {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType  : 'json',
            success:function(response){
                jQuery('#nameup').val(response.newcata.name);
                jQuery('#nick_nameup').val(response.newcata.nick_name);
            }
        });
    });  
   






});
/*====== End document ready function =====*/ 
