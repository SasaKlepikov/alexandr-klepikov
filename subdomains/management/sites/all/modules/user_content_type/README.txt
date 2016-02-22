
-- SUMMARY --

This module creates a content type for users to be able to get their field-data
or list them wherever only "node"-entities are available or allowed to use.
User nodes get inserted, updated and deleted the same second users get inserted,
updated or deleted. Blocking a user unpublishes its node, the connection to the
node's original user can be found in the author of the user node.

-- REQUIREMENTS --

None.

-- INSTALLATION --

- Sandbox-State:
Install as usual, see https://drupal.org/node/1294804 for further information.

- Project-State:
Install as usual, see
https://drupal.org/documentation/install/modules-themes/modules-7 for further
information.

-- USAGE --

- Activate this module
- Configure the user node content type at
admin/config/content/user_content_type or by visiting
Configuration -> Content authoring -> User Content Type.
- If there already are users to create nodes for, click on "Rebuild user content
manually" once to create nodes for them
- Enjoy the new possibilities.
