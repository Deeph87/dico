let accessToken = "f35794bf6a0a480e935698a71e3f8966";
let baseUrl = "https://api.api.ai/v1/";
let getDefinitionUrl = "http://localhost:8080/getrandworddefinition?word=#WORD#";
let recognition, responses, resElement;

$(document).ready(function() {
    $("#input").keypress(function(event) {
        if (event.which == 13) {
            event.preventDefault();
            send();
            this.value = '';
        }
    });
    // $("#rec").click(function(event) {
    //     switchRecognition();
    // });
});

function startRecognition() {
    recognition = new webkitSpeechRecognition();
    recognition.onstart = function(event) {
        updateRec();
    };
    recognition.onresult = function(event) {
        let text = "";
        for (let i = event.resultIndex; i < event.results.length; ++i) {
            text += event.results[i][0].transcript;
        }
        setInput(text);
        stopRecognition();
    };
    recognition.onend = function() {
        stopRecognition();
    };
    recognition.lang = "en-US";
    recognition.start();
}

function stopRecognition() {
    if (recognition) {
        recognition.stop();
        recognition = null;
    }
    updateRec();
}

function switchRecognition() {
    if (recognition) {
        stopRecognition();
    } else {
        startRecognition();
    }
}

function setInput(text) {
    $("#input").val(text);
    send();
}

function updateRec() {
    $("#rec").text(recognition ? "Stop" : "Speak");
}

function send() {
    let text = $("#input").val();
    let wordParameter, definition;
    $.ajax({
        type: "POST",
        url: baseUrl + "query?v=20150910",
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        headers: {
            "Authorization": "Bearer " + accessToken
        },
        data: JSON.stringify({ query: text, lang: "en", sessionId: "somerandomthing" }),
        success: function(data) {
            let wordParameter = data['result']['parameters']['any'][0] != 'undefined' ? data['result']['parameters']['any'][0] : false;
            if(wordParameter) {
                $.ajax({
                    type: "GET",
                    url: getDefinitionUrl.replace('#WORD#', wordParameter),
                    contentType: "application/json; charset=utf-8",
                    dataType: "json",
                    async: false,
                    success: function (definition) {
                        setResponses(data, definition);
                    },
                    error: function () {
                        console.log("Internal Server Error");
                    }
                });
            }
        },
        error: function() {
            setResponses("Internal Server Error");
        }
    });
}

function setResponses(botResponses, meaning)
{
    let response = [];
    // console.log(botResponses);
    // response = botResponses;

    if(typeof botResponses == 'object'){
        responses = typeof botResponses['result']['fulfillment']['messages'] != 'undefined' ? botResponses['result']['fulfillment']['messages'] : {};

        if(responses.length !== 0){
            response.push(responses[0]['speech']);
            if(meaning !== null){
                // console.log(meaning);
                response.push(meaning);
            }
            response.push(responses[1]['speech']);
        }
    }

    if(meaning !== null){
        response['definition'] = meaning;
    }

    print(response);
}

function print(response){
    resElement = '';
    response.forEach(function( index ) {
        resElement += '<div>' + index + '</div>';
    });
    $("#response").append(resElement);
}
