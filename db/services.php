<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Chat external functions and service definitions.
 *
 * @package    mod_chat
 * @category   external
 * @copyright  2015 Juan Leyva <juan@moodle.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @since      Moodle 3.0
 */

defined('MOODLE_INTERNAL') || die;

$functions = array(

    'mod_chat_login_user' => array(
        'classname'     => 'mod_chat_external',
        'methodname'    => 'login_user',
        'description'   => 'Log a user into a chat room in the given chat.',
        'type'          => 'write',
        'capabilities'  => 'mod/chat:chat'
    ),

    'mod_chat_get_chat_users' => array(
        'classname'     => 'mod_chat_external',
        'methodname'    => 'get_chat_users',
        'description'   => 'Get the list of users in the given chat session.',
        'type'          => 'read',
        'capabilities'  => 'mod/chat:chat'
    ),

);
