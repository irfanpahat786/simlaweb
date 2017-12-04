/**
 * @license Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

/*  ORIGNAL CODE 

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
};
*/
CKEDITOR.editorConfig = function( config )
{

config.toolbar = 'Full';

config.toolbar_Full =
[
    ['Bold','Italic','Underline','Strike'],
    ['NumberedList','BulletedList'],
    ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
    ['Link','Unlink','Anchor'],
    ['Image','Youtube','Table','Blockquote','CreateDiv','Source']
];

config.extraPlugins = 'youtube';
};