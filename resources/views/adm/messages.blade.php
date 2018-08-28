@if(session('message'))
    <input type="hidden" id="flash_text" value="{{ session('message') }}"/>
    <input type="hidden" id="flash_heading" value="{{ session('message-type') ? ucfirst(session('message-type')) : ''}}"/>
    <input type="hidden" id="flash_icon" value="{{ session('message-type') }}"/>
    <script type="text/javascript">
        $.toast({
            text: $('#flash_text').val(), // Text that is to be shown in the toast
            @if(session('message-type'))
                heading: $('#flash_heading').val(), // Optional heading to be shown on the toast
                icon: $('#flash_icon').val(), // Type of toast icon:  error, warning, info or success
            @endif
            showHideTransition: 'slide', // fade, slide or plain
            allowToastClose: false, // Boolean value true or false
            hideAfter: 3000, // false to make it sticky or number representing the miliseconds as time after which toast needs to be hidden
            stack: false, // false if there should be only one toast at a time or a number representing the maximum number of toasts to be shown at a time
            position: 'top-right', // bottom-left or bottom-right or bottom-center or top-left or top-right or top-center or mid-center or an object representing the left, right, top, bottom values
            textAlign: 'left',  // Text alignment i.e. left, right or center
            loader: false,  // Whether to show loader or not. True by default
        });
    </script>
@endif
@if(session('info'))
    <input type="hidden" id="flash_text_info" value="{{ session('info') }}"/>
    <script type="text/javascript">
        $.toast({
            text: $('#flash_text_info').val(), // Text that is to be shown in the toast
            heading: 'Info', // Optional heading to be shown on the toast
            icon: 'info', // Type of toast icon:  error, warning, info or success
            showHideTransition: 'slide', // fade, slide or plain
            allowToastClose: false, // Boolean value true or false
            hideAfter: 3000, // false to make it sticky or number representing the miliseconds as time after which toast needs to be hidden
            stack: false, // false if there should be only one toast at a time or a number representing the maximum number of toasts to be shown at a time
            position: 'top-right', // bottom-left or bottom-right or bottom-center or top-left or top-right or top-center or mid-center or an object representing the left, right, top, bottom values
            textAlign: 'left',  // Text alignment i.e. left, right or center
            loader: false,  // Whether to show loader or not. True by default
        });
    </script>
@endif