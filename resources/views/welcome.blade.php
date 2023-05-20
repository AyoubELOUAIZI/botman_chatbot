<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel project</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
</head>

<body class="antialiased">
   <div>
    <h1>Example of page </h1>
    <h2>any page that should show the widget. should containe the script<br/> exist in the code of this example page</h2>
   </div>
    <!-- botman scripts this script should be added for each page where the widjet will apeare in  -->
    <script>
    var botmanWidget = {
        frameEndpoint: "/botmanWidget",
        title: "New Chat",
        aboutText: 'AJICOD⚡',
        aboutLink: "https://ajicod.com",
        introMessage:  `✅ say Hi🖐 to start the conversation!`,
        placeholderText: "",
        mainColor: "#8C56CF",
        headerTextColor: '#fff',
        bubbleAvatarUrl:"https://ajicod.com/media/img/favicon.png",
        bubbleBackground: "#8C56CF00",
    };
    </script>
    <script src='https://cdn.jsdelivr.net/npm/botman-web-widget@0/build/js/widget.js'></script>
    <!-- botman scripts end -->
</body>

</html>
