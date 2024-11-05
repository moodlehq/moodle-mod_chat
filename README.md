
# Chat Plugin Documentation for Moodle 5.0

The Chat plugin allows real-time, text-based discussions among users within a Moodle course. This feature can facilitate synchronous communication, providing a space for virtual class discussions, group work, and instant messaging.

> **Note**: For enhanced functionality and integration, consider alternative solutions such as Moodle’s Matrix integration.

---

### Installation & Configuration

To set up the Chat plugin:

1. Go to **Site administration -> Plugins -> Activity modules -> Chat -> Settings**.

2. Set the method to "sockets" and configure the ports and other settings as needed.

3. Start the chat server using the following command in your Unix terminal:

   ```bash
   cd moodle/mod/chat
   php chatd.php --start &
   ```

4. Open a chat room within a course to verify the setup.

---

### Known Issues

- **User List**: Display issues may occur.
- **Browser Compatibility**: Some browsers (e.g., Safari) may show duplicated lines.
- **Error Messages**: "Document was empty" messages may occasionally appear.

Contributions to improve these issues are appreciated!

---

### License

Licensed under the [GNU GPL License](http://www.gnu.org/copyleft/gpl.html).