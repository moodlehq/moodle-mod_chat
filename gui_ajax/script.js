(function() {
var Dom = YAHOO.util.Dom, Event = YAHOO.util.Event;
// window.onload
Event.onDOMReady(function() {
    // build layout
    var layout = new YAHOO.widget.Layout({
        units: [
        { position: 'top', height: 60, body: 'chat_header', header: chat_cfg.header_title, gutter: '5px', collapse: true, resize: false },
        { position: 'right', header: 'User List', width: 300, resize: true, gutter: '5px', footer: null, collapse: true, scroll: true, body: 'chat_user_list', animate: false },
        { position: 'bottom', header: 'Input Area', height: 60, resize: true, body: 'chat_input', gutter: '5px', collapse: false },
        //{ position: 'left', header: 'Options', width: 200, resize: true, body: 'chat_options', gutter: '5px', collapse: true, close: true, collapseSize: 50, scroll: true, animate: false },
        { position: 'center', body: 'chat_panel', gutter: '5px', scroll: true }
        ]
    });
    layout.on('render', function() {
        layout.getUnitByPosition('left').on('close', function() {
            closeLeft();
        });
    });
    layout.render();
    Event.on('btn_send', 'click', function(ev) {
        Event.stopEvent(ev);
        send_msg();
    });
    var key_send = new YAHOO.util.KeyListener(document, { keys:13 }, {fn:send_msg, correctScope:true });
    key_send.enable();
    document.getElementById('input_msgbox').focus();

    // done build layout
    var transaction = YAHOO.util.Connect.asyncRequest('POST', "update.php?chat_sid="+chat_cfg.sid+"&chat_init=1", init_cb, null);
    interval = setInterval(function(){
        update_info();
    }, chat_cfg.timer);
});
})();
function send_msg() {
    var msg = document.getElementById('input_msgbox').value;
    var el_send = document.getElementById('btn_send');
    if (!msg) {
        alert('null?');
        return;
    }
    var url = 'post.php?chat_sid='+chat_cfg.sid;
    el_send.value = chat_lang.sending;
    var a = YAHOO.util.Connect.asyncRequest('POST', url, send_cb, "chat_message="+msg);
}

// record msg IDs
var msgs = [];
var interval = null;

function update_users(users) {
    if(!users){
        return;
    }
    var list = document.getElementById('listing');
    list.innerHTML = '';
    for(i in users){
        var el = document.createElement('li');
        el.innerHTML = users[i].picture+' '+users[i].name;
        console.info(users[i]);
        list.appendChild(el);
    }
}
function update_info() {
    if(!chat_cfg.req_count){
        chat_cfg.req_count = 1;
    } else {
        chat_cfg.req_count++;
    }
    console.info(chat_cfg.req_count);
    var url = "update.php?chat_sid="+chat_cfg.sid+"&chat_lasttime="+chat_cfg.chat_lasttime;
    if(chat_cfg.chat_lastrow != null){
        url += "&chat_lastrow="+chat_cfg.chat_lastrow;
    }
    var a = YAHOO.util.Connect.asyncRequest('POST', url, update_cb, null);
}
function append_msg(msg) {
    var list = document.getElementById('msg_list');
    var el = document.createElement('li');
    el.innerHTML = msg;
    list.appendChild(el);
}

var send_cb = {
    success: function(o) {
        if(o.responseText == 200){
         document.getElementById('btn_send').value = chat_lang.send;
         document.getElementById('input_msgbox').value = '';
        }
        clearInterval(interval)
        update_info();
        interval = setInterval(function(){
            update_info();
        }, chat_cfg.timer);
        document.getElementById('input_msgbox').focus();
    }
}
var update_cb = {
success: function(o){
    try {
        if(o.responseText){
            var data = YAHOO.lang.JSON.parse(o.responseText);
        } else {
            return;
        }
    } catch(e) {
        alert('json invalid');
        alert(o.responseText);
        return;
    }
    if(!data)
         return false;
    chat_cfg.chat_lasttime = data['lasttime'];
    chat_cfg.chat_lastrow  = data['lastrow'];
    // update messages
    for (key in data['msgs']){
        if(!in_array(key, msgs)){
            msgs.push(key);
            append_msg(data['msgs'][key]);
            console.log(data['msgs'][key]);
        }
    }
    // update users
    update_users(data['users']);
    // scroll to the bottom of the message list
    //$('#msgpanel').scrollTop(20000);
}
}
var init_cb = {
    success: function(o){
        if(o.responseText){
            var data = YAHOO.lang.JSON.parse(o.responseText);
        } else {
            return;
        }
        if (data.users) {
            console.info(data);
            update_users(data.users);
        }
    }
}

function in_array(f, t){
    var a = false;
    for( var i = 0; i<t.length; i++){
        if(f==t[i]){
            a=true;
            break;
        }
    }
    return a;
}

// debug code
if(!console){
    var console = {
        info: function(){
        },
        log: function(){
        }
    }
}
