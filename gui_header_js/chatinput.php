<?php  // $Id$

    $nomoodlecookie = true;     // Session not needed!

    require('../../../config.php');
    require('../lib.php');

    $chat_sid = required_param('chat_sid', PARAM_ALPHANUM);

    if (!$chatuser = get_record('chat_users', 'sid', $chat_sid)) {
        error('Not logged in!');
    }

    chat_force_language($chatuser->lang);

    ob_start();
    ?>
    <script type="text/javascript">
    <!--
    function empty_field_and_submit() {
        document.sendForm.chat_message.value = document.inputForm.chat_message.value;
        document.inputForm.chat_message.value = '';
        document.sendForm.submit();
        document.inputForm.chat_message.focus();
        return false;
    }
    // -->
    </script>
    <?php

    $meta = ob_get_clean();
    print_header('', '', '', 'inputForm.chat_message', $meta, false);

?>
    <form action="../empty.php" method="GET" target="empty" name="inputForm"
          OnSubmit="return empty_field_and_submit()">
        &gt;&gt;<input type="text" name="chat_message" size="60" value="" />
        <?php helpbutton('chatting', get_string('helpchatting', 'chat'), 'chat', true, false); ?>
    </form>

    <form action="insert.php" method="GET" target="empty" name="sendForm">
        <input type="hidden" name="chat_sid" value="<?php echo $chat_sid ?>" />
        <input type="hidden" name="chat_message" />
    </form>
</body>
</html>
