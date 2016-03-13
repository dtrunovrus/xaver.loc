$(document).ready(function () {
    
    function showResponse(response) {
        $('#sessionListRows>tbody').append(response.adInfo);

        if (response.status == 'success') {
            $('#container').removeClass('alert-danger').addClass('alert-succes');
            $('#container_info').html(response.message);
            $('#container').fadeIn('slow');
        } else if (response.status == 'error') {
            $('#container').removeClass('alert-succes').addClass('alert-danger');
            $('#container_info').html(response.message);
            $('#container').fadeIn('slow');
        }
    }
    
    var options = { 
        target:        '#container_info',   // target element(s) to be updated with server response 
        //beforeSubmit:  showRequest,  // pre-submit callback 
        success:       showResponse,  // post-submit callback 
 
        // other available options: 
        url:       'ajaxController.php?action=insert',         // override for form's 'action' attribute 
        dataType:  'json',        // 'xml', 'script', or 'json' (expected server response type) 
        clearForm: true,     // clear all form fields after successful submit 
        resetForm: true      // reset the form after successful submit 
    }; 
 
    // bind form using 'ajaxForm' 
    $('#ajax-form').ajaxForm(options);     
    
    //$('a.delete').on('click', function () {
    $(document).on('click','a.delete',function(){    
        var id = $(this).next().val();
        var tr = $(this).closest('tr');                
        var parm = {"id": id};

        $.getJSON('ajaxController.php?action=delete',
                parm,
                function (response) {
                    tr.fadeOut('slow', function () {
                        if (response.status == 'success') {
                            $('#container').removeClass('alert-danger').addClass('alert-succes');                                                        
                            $('#container_info').html(response.message);                            
                            $('#container').fadeIn('slow');
                        }
                        else if (response.status == 'error') {
                            $('#container').removeClass('alert-succes').addClass('alert-danger');
                            $('#container_info').html(response.message);
                            $('#container').fadeIn('slow');
                        }
                        $(this).remove();
                        
                        if ($('#sessionListRows tbody tr').length==0) {
                            $('#container_info').append('<br> The database has no more ads.');
                            $('#sessionList').remove();
                        }
                    })
                }
        );
    }
    )
    
    $(document).on('click', 'a.edit', function () {
        var id = $(this).next().val();
        var tr = $(this).closest('tr');
        var parm = {"id": id};

        $.getJSON('ajaxController.php?action=edit',
                parm,
                function (data) {
                    
                    $("#fld_seller_name").val(data.seller_name);
                    if(data.physical==1){
                        $("#fld_radio1").prop('checked', 'checked');
                        $("#fld_radio2").prop('checked', false);
                    }else {
                        $("#fld_radio2").prop('checked', 'checked');
                        $("#fld_radio1").prop('checked', false);                        
                    }
                    $("#fld_seller_name").val(data.seller_name);
                    $("#fld_email").val(data.email);
                    if(data.allow_mail==1){
                        $("#fld_allow_mails").prop('checked', 'checked');
                    }else {
                        $("#fld_allow_mails").prop('checked', false);
                    }
                    $("#fld_phone").val(data.phone);
                    $("#fld_city [value='"+data.city+"']").prop("selected", "selected");
                    $("#fld_category [value='"+data.category+"']").prop("selected", "selected");
                    $("#fld_title").val(data.title);
                    $("#fld_description").val(data.description);
                    $("#fld_price").val(data.price);                                       
                    $("#ad_hidden_info").val(data.id);               
                }
        );
    }
    
    )
    
    

})