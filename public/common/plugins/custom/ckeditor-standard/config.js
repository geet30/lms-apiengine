/**
 * @license Copyright (c) 2003-2017, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */
CKEDITOR.editorConfig = function( config ) {

	
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
	//config.allowedContent = true;
    //config.fullPage = true,
	config.extraPlugins = 'wordcount';
	config.wordcount = {
        
        // Whether or not you want to show the Paragraphs Count
        showParagraphs: false,
	    
	    // Whether or not you want to show the Word Count
	    showWordCount: false,

	    // Whether or not you want to show the Char Count
	    showCharCount: false,
		countSpacesAsChars: true,
		maxCharCount: 5000 //pending to get it from env
	    
	    // Maximum allowed Word Count
	   // maxWordCount: 4,

	    // Maximum allowed Char Count
	    //maxCharCount: 10
	};
};
