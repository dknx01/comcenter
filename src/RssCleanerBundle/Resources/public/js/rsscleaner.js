var RssCleaner = RssCleaner || {};
RssCleaner.getBasePath = function () {
    if (window.location.pathname.indexOf('app_dev.php') >= 0) {
        return '/cc/app_dev.php';
    } else  {
        return '/cc';
    }
};

RssCleaner.search = {
    isRunning: false,

    init: function () {
        $('#rss_cleaner_bundle_expression_type_expression').on('keyup', function() {
            RssCleaner.search.getSearchText();
        });
    },
    getSearchText: function () {
        var text = $('#rss_cleaner_bundle_expression_type_expression').val();
        if (text.length >= 3 && this.isRunning !== true) {
            RssCleaner.search.isRunning = true;
            RssCleaner.rest.apiGet(text, RssCleaner.search.showResult);
        }
    },
    showResult: function (ajaxObject) {
        $('#searchResult').html(ajaxObject.data);
       RssCleaner.search.isRunning = false;
    }
};

RssCleaner.rest = {
    apiGet: function(data, callback) {
        var url = RssCleaner.getBasePath() + '/rsscleaner/entries/search/';
        jQuery.ajax({
            type: "GET",
            url: url + encodeURIComponent(data),
            contentType: "application/json; charset=utf-8",
            dataType: "html",
            success: function (data, status, jqXHR) {
                var obj = RssCleaner.ajaxObject;
                obj.data = data;
                obj.status = status;
                callback(obj);
            },
            error: function (jqXHR, status) {
                var obj = RssCleaner.ajaxObject;
                obj.data = 'Error';
                obj.status = status;
                callback(obj);
            }
        });
    }
};

RssCleaner.ajaxObject = {
    status: 0,
    data: ''
};