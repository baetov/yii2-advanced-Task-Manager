var webSocketPort = wsPort ? wsPort : 8080,
    conn = new WebSocket ('ws://localhost:' + webSocketPort),
    idMessages = 'chatMessages';


conn.onopen = function(e) {
    console.log("Connection established!");
};
conn.onerror = function(e) {
    console.log("Connection fail!");
};

conn.onmessage = function(e) {
    console.log(e.data);
    document.getElementById(idMessages).value =
        e.data + '\n' + document.getElementById(idMessages).value;

    var $el = $('li.messages-menu ul.menu li:first').clone();
    $el.find('p').text(e.data);
    $el.find('h4').text('Websocket user');
    $el.prependTo('li.messages-menu ul.menu');

    var cnt = $('li.messages-menu ul.menu li').length;
    $('li.messages-menu span.label-success').text(cnt);
    $('li.messages-menu li.header').text('You have ' + cnt + ' messages');
};
conn.sendMessage = function(e){
    var str = document.getElementById("sendMessage").value;
    conn.send(str);
}
