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

// Load an external CKEditor CSS file
const link = document.createElement('link');
link.rel = 'stylesheet';
link.href = 'https://cdn.ckeditor.com/ckeditor5/45.0.0/ckeditor5.css';
document.head.appendChild(link);

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
        licenseKey: 'eyJhbGciOiJFUzI1NiJ9.eyJleHAiOjE3NDM4MTExOTksImp0aSI6IjMwYjVhODM5LTU5NGItNGEzMi1iMmMxLWIxMzQwZmY4ZTg0ZiIsImRpc3RyaWJ1dGlvbkNoYW5uZWwiOlsic2giLCJkcnVwYWwiXSwid2hpdGVMYWJlbCI6dHJ1ZSwiZmVhdHVyZXMiOlsiRFJVUCJdLCJ2YyI6IjRkNmFmNWM2In0.aa_FL8BYu4Thvv-61GQHK_Aptt8AIVN29WYVk4ljIUB_MKHWh13ERC7eV1XwkkAyX9NmM5_tSw5jXH2gUfwNWQ',
        toolbar: {
            items: [
                'undo',
                'redo',
                'bold',
                'italic',
                'underline',
                'bulletedList',
                'numberedList',
                '|',
                'alignment',
                'findAndReplace',
                //'wproofreader'
            ],
            shouldNotGroupWhenFull: true
        },
        language: 'en',
        link: {
            defaultProtocol: 'https://',
            decorators: {
                openInNewTab: {
                    mode: 'manual',
                    label: 'Open in a new tab',
                    attributes: {
                        target: '_blank',
                        rel: 'noopener noreferrer'
                    }
                },        
                addClass: {
                    mode: 'manual',
                    label: 'Add orange button classes',
                    attributes: {
                        class: 'text-link btn btn-secondary'
                    }
                }
            }
        },
        heading: {
            options: [
                { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' },
                { model: 'heading4', view: 'h4', title: 'Heading 4', class: 'ck-heading_heading4' },
                { model: 'heading5', view: 'h5', title: 'Heading 5', class: 'ck-heading_heading5' },
                { model: 'heading6', view: 'h6', title: 'Heading 6', class: 'ck-heading_heading6' }
            ]
        },
        CloudServices: {
            tokenUrl: ckTokenUrl
        }
    	}).then(editor => {
            const editorElements = document.querySelectorAll(".editor");
          
            editorElements.forEach(element => {
              element.style.display = "block";
              element.style.position = "absolute";
              element.style.zIndex = "-1";
            });
        }).catch( error => {
    	    console.error( error );
    });
});
