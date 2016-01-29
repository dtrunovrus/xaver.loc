$(document).ready(function () {

    $('a.delete').on('click', function () {
        var id = $(this).next().val();
        var tr = $(this).closest('tr');

        $('#container').load('delete_row.php?action=delete&id=' + id,
                tr.fadeOut('slow', function () {
                    $(this).remove();
                })
                );
    })

})