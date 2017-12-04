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
config.extraAllowedContent = 'span div table tr td th colgroup col style[*]{*}';
config.pasteFromWordRemoveFontStyles = false;
config.pasteFromWordRemoveStyles = false ;


//CKEDITOR.config.smiley_images = [
//	'regular_smile.png', 'sad_smile.png', 'wink_smile.png', 'teeth_smile.png', 'confused_smile.png', 'tongue_smile.png',
//	'embarrassed_smile.png', 'omg_smile.png', 'whatchutalkingabout_smile.png', 'angry_smile.png', 'angel_smile.png', 'shades_smile.png',
//	'devil_smile.png', 'cry_smile.png', 'lightbulb.png', 'thumbs_down.png', 'thumbs_up.png', 'heart.png',
//	'broken_heart.png', 'kiss.png', 'envelope.png'
//];
//config.toolbar = 'Full';

config.toolbar_Full =
[
 	
    ['Bold','Italic','Underline','Strike'],
    ['NumberedList','BulletedList'],
    ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
    ['Link','Unlink','Anchor'],
    ['Image','Youtube','Table','Blockquote','CreateDiv','Source']
];

config.extraPlugins = 'youtube';
//config.extraPlugins = 'imageuploader';//edited by rk 11august2016
config.protectedSource.push( /<ins[\s|\S]+?<\/ins>/g); // Protects <INS> tags 
config.allowedContent = true; //edited by rk 10august2016
config.allowedContent = {   /// //this code edited by rk 10august2016
        script: true,
        $1: {
            // This will set the default set of elements
            elements: CKEDITOR.dtd,
            attributes: true,
            styles: true,
            classes: true
        }
    };

	
};