$( document ).ready(function() {
    let submitButton = $('#submitButton');
    let textearea = $('#message');
    let talkboard = $('#talkboard .container');
    let userMessage, bubble;

    $('body').on('click', '#submitButton', function(){
        userMessage = getMessageFromTextareaInput();

        if(userMessage !== null){

            bubble = '<div class="row">';
            bubble += '<div class="col-9 userBubble">' + userMessage + '</div>';
            bubble += '</div>';
            talkboard.append(bubble);
            deleteTextareaValue();

            let request = $.ajax({
                url: "http://localhost:8080/ajaxbottest",
                type: "GET",
                dataType: "json"
            });

            request.done(function(msg) {
                console.log(msg);
            });
        }
    });

    function getMessageFromTextareaInput(){
        return textearea.val();
    }

    function deleteTextareaValue(){
        textearea.val('');
    }
});

