var GET_METHOD = 'GET';
var POST_METHOD = 'POST';
var DELETE_METHOD = 'DELETE';
var PUT_METHOD = 'PUT';
var ADD_METHOD = 'ADD';
var DATA_TYPE_JSON = 'json';
var DATA_TYPE_HTML = 'html';
var CONTENT_TYPE_JSON = 'application/json';
var CONTENT_TYPE_HTML = 'application/html';

var RestClient = RestClient || {};

RestClient.Api = {
    Get: function(data, url, callback, contentType, dataType) {
        // var url = RssCleaner.getBasePath() + '/rsscleaner/entries/search/';
        contentType = typeof contentType !== 'undefined' ? contentType : CONTENT_TYPE_HTML;
        dataType = typeof dataType !== 'undefined' ? dataType : DATA_TYPE_HTML;
        var ajaxObject = RestClient.ajaxObject;
        ajaxObject.requestData.url = url;
        ajaxObject.requestData.method = PUT_METHOD;
        ajaxObject.requestData.dataType = dataType;
        ajaxObject.requestData.contentType = contentType;
        jQuery.ajax({
            type: GET_METHOD,
            url: url + encodeURIComponent(data),
            contentType: contentType + "; charset=utf-8",
            dataType: dataType,
            success: function (data, status, jqXHR) {
                ajaxObject.data = data;
                ajaxObject.status = status;
                callback(ajaxObject);
            },
            error: function (jqXHR, status) {
                ajaxObject.data = 'Error';
                ajaxObject.status = status;
                callback(ajaxObject);
            }
        });
    },
    POST: function(data, url, callback, contentType, dataType) {
        // var url = RssCleaner.getBasePath() + '/rsscleaner/entries/search/';
        contentType = typeof contentType !== 'undefined' ? contentType : CONTENT_TYPE_HTML;
        dataType = typeof dataType !== 'undefined' ? dataType : DATA_TYPE_HTML;
        var ajaxObject = RestClient.ajaxObject;
        ajaxObject.requestData.url = url;
        ajaxObject.requestData.method = PUT_METHOD;
        ajaxObject.requestData.dataType = dataType;
        ajaxObject.requestData.contentType = contentType;
        jQuery.ajax({
            type: POST_METHOD,
            url: url,
            contentType: contentType + "; charset=utf-8",
            dataType: dataType,
            success: function (data, status, jqXHR) {
                ajaxObject.data = data;
                ajaxObject.status = status;
                callback(ajaxObject);
            },
            error: function (jqXHR, status) {
                ajaxObject.data = 'Error';
                ajaxObject.status = status;
                callback(ajaxObject);
            }
        });
    },
    ADD: function(data, url, callback, contentType, dataType) {
        // var url = RssCleaner.getBasePath() + '/rsscleaner/entries/search/';
        contentType = typeof contentType !== 'undefined' ? contentType : CONTENT_TYPE_HTML;
        dataType = typeof dataType !== 'undefined' ? dataType : DATA_TYPE_HTML;
        var ajaxObject = RestClient.ajaxObject;
        ajaxObject.requestData.url = url;
        ajaxObject.requestData.method = PUT_METHOD;
        ajaxObject.requestData.dataType = dataType;
        ajaxObject.requestData.contentType = contentType;
        jQuery.ajax({
            type: ADD_METHOD,
            url: url,
            contentType: contentType + "; charset=utf-8",
            dataType: dataType,
            data: data,
            success: function (data, status, jqXHR) {
                ajaxObject.data = data;
                ajaxObject.status = status;
                callback(ajaxObject);
            },
            error: function (jqXHR, status) {
                ajaxObject.data = 'Error';
                ajaxObject.status = status;
                callback(ajaxObject);
            }
        });
    },
    DELETE: function(data, url, callback, contentType, dataType) {
        // var url = RssCleaner.getBasePath() + '/rsscleaner/entries/search/';
        contentType = typeof contentType !== 'undefined' ? contentType : CONTENT_TYPE_HTML;
        dataType = typeof dataType !== 'undefined' ? dataType : DATA_TYPE_HTML;
        var ajaxObject = RestClient.ajaxObject;
        ajaxObject.requestData.url = url;
        ajaxObject.requestData.method = PUT_METHOD;
        ajaxObject.requestData.dataType = dataType;
        ajaxObject.requestData.contentType = contentType;
        jQuery.ajax({
            type: DELETE_METHOD,
            url: url + encodeURIComponent(data),
            contentType: contentType + "; charset=utf-8",
            dataType: dataType,
            success: function (data, status, jqXHR) {
                ajaxObject.data = data;
                ajaxObject.status = status;
                callback(ajaxObject);
            },
            error: function (jqXHR, status) {
                ajaxObject.data = 'Error';
                ajaxObject.status = status;
                callback(ajaxObject);
            }
        });
    },
    PUT: function(data, url, callback, contentType, dataType) {
        // var url = RssCleaner.getBasePath() + '/rsscleaner/entries/search/';
        contentType = typeof contentType !== 'undefined' ? contentType : CONTENT_TYPE_HTML;
        dataType = typeof dataType !== 'undefined' ? dataType : DATA_TYPE_HTML;
        var ajaxObject = RestClient.ajaxObject;
        ajaxObject.requestData.url = url;
        ajaxObject.requestData.method = PUT_METHOD;
        ajaxObject.requestData.dataType = dataType;
        ajaxObject.requestData.contentType = contentType;
        jQuery.ajax({
            type: PUT_METHOD,
            url: url,
            contentType: contentType + "; charset=utf-8",
            dataType: dataType,
            data: data,
            success: function (data, status, jqXHR) {
                ajaxObject.data = data;
                ajaxObject.status = status;
                callback(ajaxObject);
            },
            error: function (jqXHR, status) {
                ajaxObject.data = 'Error';
                ajaxObject.status = status;
                callback(ajaxObject);
            }
        });
    }
};

RestClient.ajaxObject = {
    status: 0,
    data: '',
    requestData: {
        url: '',
        method: '',
        dataType: '',
        contentType: ''
    }
};