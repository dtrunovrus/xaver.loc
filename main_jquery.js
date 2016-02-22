$(document).ready(function () {

    $('a.delete').on('click', function () {
        var id = $(this).next().val();
        var tr = $(this).closest('tr');        
        
        var parm = {"id": id};


        $.getJSON('delete_row.php?action=delete',
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

})