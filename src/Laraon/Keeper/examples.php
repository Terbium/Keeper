<?php

use Laraon\Keeper\Facades\Keeper;

// Basic example
// Set rule, that grants ability to comment something
Keeper::register('comment', null, 'Ability to comment');
// Use:
Keeper::check('comment');



// Custom rule example
// Rule, that determine, that user can edit a post, if he is the post's author
Keeper::register(
	'edit_my_post',
	// The $user var is appended to arguments list by Keeper
	// In this case check would be like this:
	// Keeper::check('edit_my_post', array($post));
	// And current auth user will be passed in closure
	// To check other user, write:
	// Keeper::check('edit_my_post', array($post), $otherUser);
	function ($check, $user) {
		if ( empty($check['post']) || !is_object($check['post']) ) {
			throw new InvalidArgumentException('Expecting post object to check');
		}
		return $check['post']->author_id == $user->id;
	},
	'Ability to edit my post'
);
// Use:
Keeper::check('edit_my_post', array('post' => $postToCheck));
Keeper::check('edit_my_post', array('post' => $postToCheck), $otherUser);



// Nested rules
Keeper::group(
	'admin_panel', // This also will be a rule "admin_panel"
	function () {
		// Grant access to admin's dashboard
		// The same as to write Keeper::register('admin_panel.dashboard')
		Keeper::register('dashboard', null, 'Access to admin dashboard');

		// Custom rule
		Keeper::register(
			'edit_post',
			function ($check, $user) {
				if ( empty($check['post']) || !is_object($check['post']) ) {
					throw new InvalidArgumentException('Expecting post object to check');
				}
				return $check['post']->created_by == $user->id;
			},
			'Ability to edit post'
		);

		// We need to deeper
		Keeper::group(
			'shops', // The same as to write Keeper::register('admin_panel.shops')
			function () {
				// The same as to write Keeper::register('admin_panel.shops.add')
				Keeper::register('add', null, 'Adding shops');

				// Let's make dynamic rules
				// Assume, that we have many shops
				// And we want to manually set,
				// what groups will have access to specific shops
				foreach ( Shop::all() as $shop ) {
					// This will add rules for each shop
					// And then you can set something like that:
					// | Group: autoshop_moderators
					// | Rule: edit_autoshop
					Keeper::register("edit_{$shop->alias}", null, "Edit shop {$shop->title}");
				}
			},
			null,
			'Access to shops management'
		);
	},
	null, // Here might be a custom rule for group
	'Access to admin panel'
);
// Use:
// Check only access to admin_panel
Keeper::check('admin_panel');
// Check access to admin_panel AND dashboard
Keeper::check('admin_panel.dashboard');
// Check access to admin_panel AND dashboard
Keeper::check('admin_panel.edit_post', array('post' => $postToCheck));
// Check access to admin_panel AND shops
Keeper::check('admin_panel.shops');
// Check access to admin_panel AND shops AND add
Keeper::check('admin_panel.shops.add');
// Check access to admin_panel AND shops AND edit_autoshop
Keeper::check('admin_panel.shops.edit_autoshop');