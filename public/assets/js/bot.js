let accessToken = "f35794bf6a0a480e935698a71e3f8966";
let baseUrl = "https://api.api.ai/v1/";
let getDefinitionUrl = "http://localhost:8080/getrandworddefinition?word=#WORD#";
let recognition, responses, resElement;

$(document).ready(function () {
    $("#input").keypress(function (event) {
        if (event.which == 13) {
            if (this.value) {
                event.preventDefault();
                send();
                printUserMessage(this.value);
                this.value = '';
            }
        }
    });
    $('body').on('click', '.dicti-send', function () {
        if ($("#input").val()) {
            send();
            console.log($("#input"));
            printUserMessage($("#input").val());
            $("#input").val('');
        }
    });
    // $("#rec").click(function(event) {
    //     switchRecognition();
    // });
});

function startRecognition() {
    recognition = new webkitSpeechRecognition();
    recognition.onstart = function (event) {
        updateRec();
    };
    recognition.onresult = function (event) {
        let text = "";
        for (let i = event.resultIndex; i < event.results.length; ++i) {
            text += event.results[i][0].transcript;
        }
        setInput(text);
        stopRecognition();
    };
    recognition.onend = function () {
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
        data: JSON.stringify({query: text, lang: "en", sessionId: "somerandomthing"}),
        success: function (data) {
            let wordParameter = typeof data['result']['parameters']['any'] !== 'undefined' ? data['result']['parameters']['any'][0] : data['result']['fulfillment']['messages'][0]['speech'];
            if (wordParameter) {
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
        error: function () {
            setResponses("Internal Server Error");
        }
    });
}

function setResponses(botResponses, meaning) {
    let response = [];
    // console.log(botResponses);
    // response = botResponses;

    if (typeof botResponses == 'object') {
        responses = typeof botResponses['result']['fulfillment']['messages'] != 'undefined' ? botResponses['result']['fulfillment']['messages'] : 'Autodestruction dans 5, 4, 3, 2, 1 ... Non je plaisante ! Ca ira mieux la prochaine fois !';
        if (responses.length !== 0) {
            response.push(responses[0]['speech']);
            if (typeof meaning !== 'undefined' && meaning.length > 0) {
                response.push(meaning);
            }
            if (typeof responses[1] !== 'undefined')
                response.push(responses[1]['speech']);
        }
    }
    print(response);
}

function print(response) {
    resElement = '';
console.log(response);
    let interval = null;
    let incr = 0;
    let length = response.length;
    let heigth;

    // response.forEach(function (index) {
    interval = setInterval(function () {
        if(incr < length){
            resElement += '<div class="row dicti-bot-speech-bubble animated fadeInUp">';
            resElement += '<div class="col s1"></div>';
            resElement += '<div class="col s7 bubble-container">';
            resElement += '<div class="bubble-text-wrapper"><span>' + response[incr] + '</span></div>';
            resElement += '</div>';
            resElement += '<div class="col s3"></div>';
            resElement += '<div class="col s1"></div>';
            resElement += '</div>';

            $("#response").append(resElement);
            resElement = '';
            incr++;
        } else {
            clearInterval(interval)
        }
        }, 1500);
    // });
}

function printUserMessage(userMessage) {
    resElement = '';

    resElement += '<div class="row dicti-user-speech-bubble animated fadeInUp">';
    resElement += '<div class="col s1"></div>';
    resElement += '<div class="col s3"></div>';
    resElement += '<div class="col s7 bubble-container">';
    resElement += '<div class="bubble-text-wrapper"><span>' + userMessage + '</span></div>';
    resElement += '</div>';
    resElement += '<div class="col s1"></div>';
    resElement += '</div>';

    $("#response").append(resElement);
}

function sleep(milliseconds) {
    let start = new Date().getTime();
    for (let i = 0; i < 1e7; i++) {
        if ((new Date().getTime() - start) > milliseconds) {
            break;
        }
    }
}