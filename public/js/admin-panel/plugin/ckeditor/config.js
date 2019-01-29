/**
 * @license Copyright (c) 2003-2016, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

var baseUrl = base_url + '/js/admin-panel/plugin/';

// var base_url =  'http://localhost/conpherence/js/admin-panel/plugin/';



CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
    //

    // console.log(base_url);

        config.extraAllowedContent = 'span;ul;li;table;td;style;*[id];*(*);*{*}';

        config.allowedContent = true;
        config.toolbar = 'MyToolbar';

        config.toolbar_MyToolbar =
        [
            ['Source','Templates','Maximize'],
            ['Cut','Copy','Paste','SpellChecker','-','Scayt'],
            ['Undo','Redo','-','Find','Replace'],
            ['Image','Table','HorizontalRule','SpecialChar','PageBreak'],
            '/',
            ['Bold','Italic','Underline','Strike','-','Subscript','Superscript'],      
            ['NumberedList','BulletedList','-','Outdent','Indent','Blockquote','SelectAll','RemoveFormat'],
            ['Link','Unlink','Anchor'],
            ['Styles','Format','Font','FontSize'],
            ['TextColor','BGColor']
        ];
        
        config.filebrowserBrowseUrl = baseUrl+'ckfinder/filebrowser.php';
        config.filebrowserImageBrowseUrl = baseUrl+'ckfinder/filebrowser.php?type=Images';
        config.filebrowserFlashBrowseUrl = 'ckfinder/filebrowser.php?type=Flash';
        config.filebrowserUploadUrl = baseUrl+'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files';
        config.filebrowserImageUploadUrl = baseUrl+'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images';
        config.filebrowserFlashUploadUrl = baseUrl+'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash';
        
};
