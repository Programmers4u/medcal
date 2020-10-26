/*global window: false, $:false, document:false, jQuery:false, XDomainRequest:false*/
/*!
 * gender.js v0.5
 * Copyright 2014 gender-api.com
 * https://github.com/markus-perl/gender-api/blob/master/LICENSE
 *
 *
 */
(function ($) {

    var GenderApi = function (element, config) {

        var TYPE_NAME = 'name';
        var TYPE_EMAIL = 'email';

        var $this = $(element);

        var block = false;  //only 1 request at a time
        var timeout = 500; // 500 ms
        var timer = null;
        var currentQuery = null;
        var attached = true; //enables or disables the detection
        var type = TYPE_NAME;

        /**
         * Can be called to disable detection
         * $(element).genderApi('detach');
         */
        $this.detachApi = function () {
            attached = false;
        };

        /**
         * Can be called to enable detection
         * $(element).genderApi('attach');
         */
        $this.attachApi = function () {
            attached = true;
        };

        var data = {
            ip: 'auto'
        };

        if (config.key) {
            data.key = config.key;
        }

        if (config.country) {
            data.country = config.country;
        }

        if (config.language) {
            data.language = config.language;
        }

        if (config.type) {
            type = config.type;
        }

        var protocol = 'https:' == document.location.protocol ? 'https://' : 'http://';
        var url = config.url ? config.url : protocol + 'gender-api.com/get';

        $this.query = function (value, callback) {

            value = $.trim(value);

            if ((type == TYPE_EMAIL && value.indexOf('@') > 0) || ( type == TYPE_NAME && value.length > 1)) {

                if (type == TYPE_EMAIL) {
                    data.email = value;
                } else {
                    data.name = value;
                }

                if (block == true) return;
                if (value == currentQuery) return;

                block = true;
                currentQuery = value;

                if (!$.support.cors && $.ajaxTransport && window.XDomainRequest) {

                    var xdr = new XDomainRequest();
                    if (xdr) {

                        if (window.location && window.location.href) {
                            data.ref = window.location.href;
                        }

                        xdr.onload = function () {
                            var result = $.parseJSON(xdr.responseText);
                            callback(result);
                            block = false;
                        };

                        var dataString = '';
                        $.each(data, function (key, value) {
                            dataString += '&' + key + '=' + encodeURIComponent(value);
                        });

                        xdr.open("get", url + '?' + dataString.substr(1));
                        xdr.send();
                    }

                } else {
                    $.ajax({
                        url: url,
                        data: data,
                        dataType: 'json'
                    }).done(function (result) {
                        callback(result);
                        block = false;
                    });
                }
            }
            else {
                callback({name: value, gender: null});
            }
        };

        if (config.hasOwnProperty('name') && config.callback) {
            $this.query(config.name, config.callback);
            return;
        }

        var startTimer = function () {
            if (timer) {
                clearTimeout(timer);
            }
            timer = setTimeout(parse, timeout);
        };

        var parse = function () {
            if (attached) {
                var value = $this.val();
                $this.query(value, function (result) {
                    if (result.gender) {
                        $this.trigger('gender-found', result);
                    }
                    block = false;
                });
            }
        };

        $this.on({
            'change': parse,
            'focusout': parse,
            'keyup': startTimer,
            'paste': function () {
                setTimeout(parse, 100)
            }
        });

        $this.data('genderapi', $this);
    };

    /** @namespace $.fn */
    $.fn.genderApi = function (config) {

        return this.each(function () {
            var api = $(this).data('genderapi');

            switch (config) {
                case 'detach':
                    if (api) {
                        api.detachApi();
                        return api;
                    }
                    return null;
                case 'attach':
                    if (api) {
                        api.attachApi();
                        return api;
                    }
                    return null;
            }

            return new GenderApi(this, config);
        });
    }
})(jQuery);