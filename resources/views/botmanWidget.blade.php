<!doctype html>
<html>

<head>
    <title>BotMan Widget</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css"
        href="https://cdn.jsdelivr.net/npm/botman-web-widget@0/build/assets/css/chat.min.css">

    <style>
        html, body {
    background-color: #f9f9f9;
    background-image: url("https://upload.wikimedia.org/wikipedia/commons/1/12/White_background.png");
    /* we can also put tis white image */
    /* https://upload.wikimedia.org/wikipedia/commons/1/12/White_background.png */
        }
    #botmanChatRoot {
        background-color: white;
    }

    #messageArea {
        background-color: white;
        /* background-image: url("https://i.pinimg.com/originals/3d/08/e0/3d08e03cb40252526fee2036a67f07f1.gif"); */
    }

    #userText.textarea {
        /* background-color: #394867; */
        background-color: white;
        /* color: black; */
        font-size: 18px;

    }

    .chat {
    background: white;
    }

.visitor .msg {
    -webkit-box-ordinal-group: 2;
    -webkit-order: 1;
    -ms-flex-order: 1;
    order: 1;
    border-top-right-radius: 2px;
    /* background: #C9EEFF; */
    background: #3a1f4733;
}

.chatbot .msg {
    -webkit-box-ordinal-group: 2;
    -webkit-order: 1;
    -ms-flex-order: 1;
    order: 1;
    border-top-left-radius: 2px;
}


.msg {
    position: relative;
    word-wrap: break-word;
    min-width: 50px;
    max-width: 80%;
    padding: 10px;
    border-radius: 10px;
    background: #8800c94d;
    margin-left: 13%;
    margin-bottom: 0;
    text-align: center;
    font-size:14px;
}

    .msg div div {
    max-height: 280px;
    overflow-y: auto;
    }

    .chatbot .msg::before {
        content: "";
        position: absolute;
        top: 50%;
        left: -50px;
        transform: translateY(-50%);
        width: 40px;
        height: 40px;
        /* background-image: url("https://static.vecteezy.com/system/resources/thumbnails/007/225/199/small/robot-chat-bot-concept-illustration-vector.jpg"); */
        background-image: url("https://ajicod.com/media/img/favicon.png");
        background-size: cover;
        border-radius: 50%;
    }

    .chatbot .msg.received::before {
        right: -40px;
        left: auto;
    }



    a.banner {
    position: fixed;
    bottom: 5px;
    right: 10px;
    height: 12px;
    z-index: 99;
    outline: none;
    color: #764ee8;
    font-size: 12px;
    text-align: right;
    font-weight: 200;
    text-decoration: none
}

      div.loading-dots .dot {
      display: inline-block;
      width: 14px;
      height: 14px;
      margin-right: 10px;
      border-radius: 50%;
      background: blue;
      animation: blink 1.4s ease-out infinite;
      animation-fill-mode: both;
  }


  .btn {
      display: block;
      padding: 10px;
      border-radius: 5px;
      margin: 5px;
      min-width: 100px;
      background-color: #B0DAFF;
      cursor: pointer;
      color: blue;
      text-align: center;
  }
    </style>
</head>

<body>
    <script id="botmanWidget" src='https://cdn.jsdelivr.net/npm/botman-web-widget@0/build/js/chat.js'></script>
<script>
//this script is lisning for the body of the widjet if it change the function observer will work
//then only if there are more than one button the input will be disabled
const observer = new MutationObserver((mutationsList) => {
     if(!document.getElementById("userText")){
            // console.log('userText element not loaded yet')
            return;
        }
    const chatOptionsElements = document.querySelectorAll('.chat .chatbot .msg div div .btn');
    if (chatOptionsElements.length > 1) {
        disableInputField();
    } else {
        enableInputField();
    }
});

const targetNode = document.querySelector('body');
observer.observe(targetNode, { childList: true, subtree: true });
</script>

<script>
   // Disable the input field
    function disableInputField() {
        const inputField = document.getElementById("userText");
        inputField.disabled = true;
        inputField.placeholder="You can not type now";
        inputField.style.textAlign = 'center';
    }

    // Enable the input field
    function enableInputField() {
        const inputField = document.getElementById("userText");
        inputField.disabled = false;
        inputField.placeholder="Type here ...";
        inputField.style.textAlign = '';
    }
</script>

<script>
    window.addEventListener('load', function () {
        const inputField = document.getElementById("userText");
        inputField.setAttribute("autocomplete", "off");
    });
</script>
</body>




</html>
