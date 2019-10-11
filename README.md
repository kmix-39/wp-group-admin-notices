# WP Group Admin Notices

## About

A library for WordPress that displays group notices on the admin screen.

## Install
```
$ composer require kmix39/wp-group-admin-notices
```

## How to use

### Start

```
<?php
$notices = Kmix39\WP_Group_Admin_Notices\Bootstrap::instance();
```

### Add group notice

```
<?php
$notices->add_notice(
	'notice_group_slug',
	'notice_group_code',
	'notice_message'
);
```

### Remove group notice

```
<?php
$notices->remove_notice(
	'notice_group_slug',
	'notice_group_code'
);
```

### Display group notices

```
<?php
$notices->display_notices(
	'notice_group_slug',	// Notice group slug
	'notice-info'	// Notice class
);
```
