<html lang="ru">
<head>
    <title>Send message to vk</title>
    <!-- Put this script tag to the <head> of your page -->
    <script type="text/javascript" src="https://vk.com/js/api/openapi.js?168"></script>
</head>
<body>
<h2>Hello world</h2>
<!-- Put this div tag to the place, where the Allow messages from community block will be -->
<div id="vk_allow_messages_from_community"></div>
<script type="text/javascript">
    VK.Widgets.AllowMessagesFromCommunity("vk_allow_messages_from_community", {height: 30}, 226422275);

    VK.Observer.subscribe('widgets.allowMessagesFromCommunity.allowed', function f(userId) {
        console.log(userId);
        console.log('allowed');
        document.getElementById('vk_id').value=userId;
    });

    VK.Observer.subscribe('widgets.allowMessagesFromCommunity.denied', function f(userId) {
        console.log(userId);
        console.log('denied');
        document.getElementById('vk_id').value='';
    });
</script>
</body>
</html>
