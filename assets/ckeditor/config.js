/**
 * @license Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';

	config.toolbar = [
		{ name: 'basicstyles', 	items: ['Bold','Italic','Underline','Strike','Subscript','Superscript'] },
		{ name: 'clipboard', 	items: ['Cut','Copy','Paste','-','Undo','Redo'] },
		{ name: 'colors', 		items: [ 'TextColor','BGColor' ] },
		{ name: 'paragraph', 	items: ['NumberedList','BulletedList','-','Outdent','Indent','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'] },
		{ name: 'insert', 		items: ['Image','Table','HorizontalRule','PageBreak'] },
		{ name: 'links',		items: [ 'Link', 'Unlink', 'Anchor' ]},
		{ name: 'styles',		items: [ 'Format','Font','FontSize' ] }
	];
};
