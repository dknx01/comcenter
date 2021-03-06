function getBasePath()
{
    if (window.location.pathname.match('/^\/app_dev\.php*/')) {
        return '/cc/app_dev.php';
    } else  {
        return '/cc';
    }
}
function deleteEntry (id, noDeleting) {
    var twitterId = $('#'+id).data('twitter');
    var deleteAction = $.get(getBasePath()+'/twitter/delete/'+twitterId);
    noDeleting = (typeof noDeleting) !== 'undefined' ? noDeleting : 1;

    deleteAction.done(function (data) {
            if (data == 1) {
                if (noDeleting == 0) {
                    $('#'+id).hide();
                } else {
                    $('#'+id+'Delete').addClass('redText');
                    $('#'+id).find('div.tweet_text').addClass('strikethrough');
                }
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
    var pinAction = $.get(getBasePath()+'/twitter/pin/'+twitterId);

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