<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            background-color: #000;
            color: #0F0;
            font-family: monospace;
            padding: 10px;
        }
        #chatbox {
            height: 300px;
            width: 100%;
            overflow-y: scroll;
            border: 1px solid #0F0;
            padding: 10px;
            box-sizing: border-box;
            white-space: pre-wrap;
            margin-bottom: 10px;
        }
        #message {
            width: 100%;
            box-sizing: border-box;
            background-color: #000;
            color: #0F0;
            border: none;
            outline: none;
            font-family: monospace;
            padding: 10px;
        }
        #message:focus {
            border: none;
            outline: none;
        }
        #message::placeholder {
            color: #0F0;
            opacity: 0.5;
        }
        #message::-webkit-input-placeholder {
            color: #0F0;
            opacity: 0.5;
        }
        #message::-moz-placeholder {
            color: #0F0;
            opacity: 0.5;
        }
        #message:-ms-input-placeholder {
            color: #0F0;
            opacity: 0.5;
        }
        #submit-btn {
            background-color: #0F0;
            color: #000;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
        }
    </style>
    <script>
        function updateMessages() {
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    var messages = JSON.parse(xhr.responseText);
                    var chatbox = document.getElementById('chatbox');
                    chatbox.innerHTML = '';
                    messages.forEach(function(message) {
                        var p = document.createElement('p');
                        p.textContent = message;
                        chatbox.appendChild(p);
                    });
                }
            };
            xhr.open('GET', 'messages.json', true);
            xhr.send();
        }

        function submitMessage(event) {
            event.preventDefault();
            var messageInput = document.getElementById('message');
            var message = messageInput.value;
            if (message.trim() !== '') {
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        updateMessages();
                        messageInput.value = '';
                    }
                };
                xhr.open('POST', 'submit.php', true);
                xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                xhr.send('message=' + encodeURIComponent(message));
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            updateMessages();
            setInterval(updateMessages, 5000);
        });
    </script>
</head>
<body>
    <div id="chatbox"></div>
    <form method="post" onsubmit="submitMessage(event)">
        <input type="text" id="message" name="message" placeholder="Enter your command...">
        <input type="submit" id="submit-btn" value="Execute">
    </form>
</body>
</html>
