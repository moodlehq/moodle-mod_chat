
# Chat Plugin Documentation for Moodle 5.0

> **This plugin has been archived and is no longer actively maintained.**  
> We encourage interested community members to take part in the [Moodle Plugin Adoption Program Forum](https://moodle.org/mod/forum/discuss.php?d=260354) or [Moodle Plugin Adoption Program](https://moodle.org/plugins/adoption)  if they wish to continue developing or maintaining this plugin.

---

**Why is this plugin archived?**

- This repository is archived because it is no longer actively maintained.
- Starting with **Moodle 5.0**, the functionality provided by this plugin is no longer part of Moodle’s core distribution.

## About the Chat plugin

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
