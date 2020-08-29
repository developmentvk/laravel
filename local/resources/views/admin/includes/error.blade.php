<script type="text/javascript">
const tryParseJSON = (jsonString) => {
    try {
        var o = JSON.parse(jsonString);
        // Handle non-exception-throwing cases:
        // Neither JSON.parse(false) or JSON.parse(1234) throw errors, hence the type-checking,
        // but... JSON.parse(null) returns null, and typeof null === "object", 
        // so we must check for that, too. Thankfully, null is falsey, so this suffices:
        if (o && typeof o === "object") {
            return o;
        }
    }
    catch (e) { }
    return {};
};

const formatErrorMessage = (jqXHR, exception) => {
    var message = '';
    if (jqXHR.status === 0) {
       message += `<p>Not connected.\nPlease verify your network connection.</p>`;
    } else if (jqXHR.status == 404) {
        message += `<p>The requested page not found.</p>`;
    }  else if (jqXHR.status == 401) {
        message += `<p>Sorry!! You session has expired. Please login to continue access.</p>`;
    } else if (jqXHR.status == 500) {
        message += `<p>Internal Server Error.</p>`;
    } else if (exception === 'parsererror') {
        message += `<p>Requested JSON parse failed.</p>`;
    } else if (exception === 'timeout') {
        message += `<p>Time out error.</p>`;
    } else if (exception === 'abort') {
        message += `<p>Ajax request aborted.</p>`;
    } else {
        try {
            var r = tryParseJSON(jqXHR.responseText);
            if (jQuery.isEmptyObject(r) == false) {
                if(r.hasOwnProperty('errors')) {
                    $.each( r.errors, function( key, value) {
                        if(jQuery.isEmptyObject(r) == false) {
                            $.each( value, function( key, row) { message += `<p>${row}</p>`; });
                        } else { message += `<p>${value}</p>`; }
                    });
                } else if(r.hasOwnProperty('message')) { message += `<p>${r.message}</p>`; } else {
                   message += `Uncaught Error.\n${jqXHR.responseText}`;
                }
            } else {
                if(r.hasOwnProperty('message')) { message += `<p>${r.message}</p>`; } else {
                   message += `Uncaught Error.\n${jqXHR.responseText}`;
                }
            }
        } catch (e) {
            message += `Uncaught Error.\n${jqXHR.responseText}`;
        }
    }
    return message;
}
</script>
