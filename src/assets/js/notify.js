;(function(){
    var defaultElementId = 'notifier',
        defaultWaitTime = 5000;
    var timer;

    function setStatus(element, status) {
        element.classList.remove('alert-success');
        element.classList.remove('alert-primary');
        element.classList.remove('alert-info');
        element.classList.remove('alert-danger');

        element.classList.add('alert-' + (status ? status : 'success'));
    }

    document.addEventListener('notification-open', function(e) {
        clearTimeout(timer);

        var element = e.detail.element ? e.detail.element : document.getElementById(defaultElementId);

        if (e.detail.content)
            element.querySelector('p').innerHTML = e.detail.content;

        element.classList.add('opened');
        element.classList.remove('closed');
        element.classList.remove('hide');

        setStatus(element, e.detail.status);

        element.querySelector('.close').onclick = function() {
            document.dispatchEvent(new CustomEvent('notification-close', { "detail" : { "element": element }}));
        }

        element.classList[e.detail.autoclose == undefined || e.detail.autoclose ? 'add' : 'remove']('autoclose');

        if (element.classList.contains('autoclose')) {
            document.dispatchEvent(
                new CustomEvent('notification-close', { "detail" : {
                    "element": element,
                    "wait" : e.detail.wait === true ? defaultWaitTime : (e.detail.wait ? e.detail.wait : defaultWaitTime)
                }})
            );
        }
    });

    document.addEventListener('notification-close', function(e) {
        var element = e.detail.element ? e.detail.element : document.getElementById(defaultElementId);

        timer = setTimeout(function(){
            element.classList.add('closed');
            element.classList.remove('opened');
        }, e.detail.wait === true ? defaultWaitTime : (e.detail.wait ? e.detail.wait : 0));
    });
})();

;(function(){
    var notifier = document.getElementById('notifier');
    notifier.classList.add('javascript');
    notifier.querySelector('button.close').classList.remove('hide');

    // We need to delay this, otherwise the css transition won't run.
    setTimeout(function(){
        notifier.classList.add('opened');
    }, 10);

    var alerts = document.querySelectorAll('.alert.alert-dismissable > .close, .alert.alert-dismissible > .close');
    for (var i = 0; i < alerts.length; ++i) {
        var parent = alerts[i].parentElement;
        var event = new CustomEvent('notification-close', { "detail" : { "element": parent }});

        alerts[i].onclick = function() {
            document.dispatchEvent(event);
        }

        // Auto-close after 5 seconds if class autoclose is available on parent.
        if (parent.classList.contains('autoclose')) {
            event.detail.wait = true;
            document.dispatchEvent(event);
        }
    }
})();
