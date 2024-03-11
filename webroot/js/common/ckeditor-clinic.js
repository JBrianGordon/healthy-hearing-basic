/**
 * @license Copyright (c) 2014-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */
import ClassicEditor from '@ckeditor/ckeditor5-editor-classic/src/classiceditor.js';
import Alignment from '@ckeditor/ckeditor5-alignment/src/alignment.js';
import Autoformat from '@ckeditor/ckeditor5-autoformat/src/autoformat.js';
import Autosave from '@ckeditor/ckeditor5-autosave/src/autosave.js';
import Bold from '@ckeditor/ckeditor5-basic-styles/src/bold.js';
import CloudServices from '@ckeditor/ckeditor5-cloud-services/src/cloudservices.js';
import Essentials from '@ckeditor/ckeditor5-essentials/src/essentials.js';
import FindAndReplace from '@ckeditor/ckeditor5-find-and-replace/src/findandreplace.js';
import GeneralHtmlSupport from '@ckeditor/ckeditor5-html-support/src/generalhtmlsupport.js';
import Italic from '@ckeditor/ckeditor5-basic-styles/src/italic.js';
import List from '@ckeditor/ckeditor5-list/src/list.js';
import ListProperties from '@ckeditor/ckeditor5-list/src/listproperties.js';
import Paragraph from '@ckeditor/ckeditor5-paragraph/src/paragraph.js';
import PasteFromOffice from '@ckeditor/ckeditor5-paste-from-office/src/pastefromoffice.js';
import StandardEditingMode from '@ckeditor/ckeditor5-restricted-editing/src/standardeditingmode.js';
import Underline from '@ckeditor/ckeditor5-basic-styles/src/underline.js';
import WordCount from '@ckeditor/ckeditor5-word-count/src/wordcount.js';
import WProofreader from '@webspellchecker/wproofreader-ckeditor5/src/wproofreader';
import EditorWatchdog from '@ckeditor/ckeditor5-watchdog/src/editorwatchdog.js';

//Importing custom CSS
import '../../css/ckeditor/ckeditor.css';

const ckTokenUrl = `${window.location.origin}/endpoints/ckeditor_endpoint`;

class Editor extends ClassicEditor {}

// Plugins to include in the build.
Editor.builtinPlugins = [
    Alignment,
    Autoformat,
    Autosave,
    Bold,
    CloudServices,
    Essentials,
    FindAndReplace,
    GeneralHtmlSupport,
    Italic,
    List,
    ListProperties,
    Paragraph,
    PasteFromOffice,
    StandardEditingMode,
    Underline,
    WordCount,
    //WProofreader
];

// Get all elements with the "editor" class
const editorElements = document.querySelectorAll(".editor");

// Iterate over each element and create the editor
editorElements.forEach((element) => {

    Editor.create(element, {
        toolbar: {
            items: [
                'bold',
                'italic',
                'bulletedList',
                'numberedList',
                'underline',
                '|',
                'alignment',
                'findAndReplace',
                //'wproofreader'
            ],
            shouldNotGroupWhenFull: true
        },
        language: 'en',
        CloudServices: {
            tokenUrl: ckTokenUrl
        }
    	}).catch( error => {
    	    console.error( error );
    });
});
