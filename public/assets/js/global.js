$( document ).ready(function() {
    $('body').on('click', '.dicti-modal .button-container button', function(){
        console.log('button clicked');
        $('.dicti-modal').hide();
    })
});

