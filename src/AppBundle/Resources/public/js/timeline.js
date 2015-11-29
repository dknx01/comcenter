function getBasepath()
{
    if (window.location.pathname.match('/^\/app_dev\.php*/')) {
        return '/app_dev.php';
    } else  {
        return '';
    }
}
function deleteEntry (id) {
    var twitterId = $('#'+id).data('twitter');
    var deleteAction = $.get(getBasepath()+'/twitter/delete/'+twitterId);

    deleteAction.done(function (data) {
            if (data == 1) {
                $('#'+id).hide();
            }
    }).fail(function() {
        alert( "error" );
    }).always(function() {
        fromValue = $('#'+id).data('from');
        $.notify('Entry from '+ fromValue + ' deleted', 'error', {globalPosition: 'top center'});
    });
}

function pinEntry (id) {
    var twitterId = $('#'+id).data('twitter');
    var pinAction = $.get(getBasepath()+'/twitter/pin/'+twitterId);

    pinAction.done(function (data) {
        if (data == 'unpinned') {
            $('#'+id+'Pin').removeClass('pinned');
        } else {
            $('#'+id+'Pin').addClass('pinned');
        }
    } ).fail(function(data) {
        alert( data);
    }).always(function(data) {
        text = data == 'unpinned' ? 'unpinned' : 'pinned';
        $.notify('Entry ' + text, 'info', {globalPosition: 'top center'});
    });
}