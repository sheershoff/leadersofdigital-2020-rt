<?php

/* @var $this yii\web\View */

$this->title = 'Языковая среда';
?>
<script>
    var recognition = null;
    var synth = null;
    var final_transcript = '';
    var final_span, interim_span;

    function capitalize(str) {
        return str.charAt(0).toUpperCase() + str.slice(1);
    }

    function linebreak(str) {
        return str + '\n';
    }

    function startTalk(event) {
        recognition.lang = 'en-US';
        recognition.start();
    }

    function endTalk(event) {
        console.debug('end talk');
        recognition.stop();
    }

    $(document).ready(function () {

        if (!('webkitSpeechRecognition' in window)) {
            $('#speech_welcome').html('<div class="warning">Вам нужен браузер с поддержкой Speech Recognition. Например, последний Chromium.</div>');
        } else {
            final_span = document.getElementById('final_span');
            interim_span = document.getElementById('interim_span');

            recognition = new webkitSpeechRecognition();
            synth = window.speechSynthesis;
            recognition.continuous = true;
            recognition.interimResults = true;

            recognition.onstart = function () {
            }
            recognition.onresult = function (event) {
            }
            recognition.onerror = function (event) {
            }
            recognition.onend = function () {
            }

            recognition.onresult = function (event) {
                var interim_transcript = '';
                for (var i = event.resultIndex; i < event.results.length; ++i) {
                    if (event.results[i].isFinal) {
                        final_transcript += capitalize(event.results[i][0].transcript + '.\n');
                        var utterThis = new SpeechSynthesisUtterance(event.results[i][0].transcript);
                        var voices = synth.getVoices();
                        for(i = 0; i < voices.length ; i++) {
                            if(voices[i].lang === 'en-US') {
                                utterThis.voice = voices[i];
                                utterThis.lang = 'en-US';
                                utterThis.rate = 0.8;
                                break;
                            }
                        }
                        synth.cancel();
                        synth.speak(utterThis);
                    } else {
                        interim_transcript += event.results[i][0].transcript;
                    }
                }
                final_span.innerHTML = linebreak(final_transcript);
                interim_span.innerHTML = linebreak(interim_transcript);
            };
        }
    });
</script>
<div class="site-index">

    <div class="jumbotron">
        <h1>Погрузись в языковую среду!</h1>

        <p class="lead">Читай книги по ролям с роботом, слушай, говори, в любое время.</p>
    </div>

    <div class="body-content" id="speech_welcome">
        <div class="row" style="margin-bottom: 30px;">
            <button class="btn btn-success" id="start_talk"
                    onmousedown="startTalk();"
                    onmouseout="endTalk();"
                    onmouseup="endTalk();">Нажми и говори
            </button>
        </div>
        <div class="row" id="row_results">
            <pre id="interim_span"></pre>
            <hr/>
            <pre id="final_span"></pre>
        </div>
    </div>
</div>
