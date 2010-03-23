<?php

define('NO_MOODLE_COOKIES', true); // session not used here

require_once('../../../config.php');
require_once($CFG->dirroot.'/mod/chat/lib.php');

$chat_sid = required_param('chat_sid', PARAM_ALPHANUM);
$chatid   = required_param('chat_id', PARAM_INT);

if (!$chatuser = $DB->get_record('chat_users', array('sid'=>$chat_sid))) {
    print_error('notlogged', 'chat');
}
if (!$chat = $DB->get_record('chat', array('id'=>$chatid))) {
    print_error('invalidid', 'chat');
}

if (!$course = $DB->get_record('course', array('id'=>$chat->course))) {
    print_error('invalidcourseid');
}

if (!$cm = get_coursemodule_from_instance('chat', $chat->id, $course->id)) {
    print_error('invalidcoursemodule');
}

$PAGE->set_url('/mod/chat/gui_header_js/chatinput.php', array('chat_sid'=>$chat_sid, 'chat_id'=>$chatid));

$context = get_context_instance(CONTEXT_MODULE, $cm->id);

//Get the user theme
$USER = $DB->get_record('user', array('id'=>$chatuser->userid));


$module = array(
    'name'      => 'mod_chat_header',
    'fullpath'  => '/mod/chat/gui_header_js/module.js',
    'requires'  => array('node')
);
$PAGE->requires->js_init_call('M.mod_chat_header.init_input', array(false), false, $module);

//Setup course, lang and theme
$PAGE->set_course($course);
$PAGE->set_pagelayout('embedded');
$PAGE->set_focuscontrol('input_chat_message');
$PAGE->set_cacheable(false);
echo $OUTPUT->header();

echo html_writer::start_tag('form', array('action'=>'../empty.php', 'method'=>'post', 'target'=>'empty', 'id'=>'inputForm', 'style'=>'margin:0'));
echo html_writer::empty_tag('input', array('type'=>'text', 'id'=>'input_chat_message', 'name'=>'chat_message', 'size'=>'50', 'value'=>''));
echo html_writer::empty_tag('input', array('type'=>'checkbox', 'id'=>'auto', 'checked'=>'checked', 'value'=>''));
echo html_writer::tag('label', get_string('autoscroll', 'chat'), array('for'=>'auto'));
echo $OUTPUT->help_icon('chatting', get_string('helpchatting', 'chat'), 'chat', true);
echo html_writer::end_tag('form');

echo html_writer::start_tag('form', array('action'=>'insert.php', 'method'=>'post', 'target'=>'empty', 'id'=>'sendForm'));
echo html_writer::empty_tag('input', array('type'=>'hidden', 'name'=>'chat_sid', 'value'=>$chat_sid));
echo html_writer::empty_tag('input', array('type'=>'hidden', 'name'=>'chat_message', 'id'=>'insert_chat_message'));
echo html_writer::end_tag('form');

echo $OUTPUT->footer();