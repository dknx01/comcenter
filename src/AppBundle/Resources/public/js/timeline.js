function deleteEntry (id) {
    var twitterId = $('#'+id).data('twitter');
    var deleteAction = $.get('delete/'+twitterId);

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
    var pinAction = $.get('pin/'+twitterId);

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