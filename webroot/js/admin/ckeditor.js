/**
 * @license Copyright (c) 2014-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */
import ClassicEditor from '@ckeditor/ckeditor5-editor-classic/src/classiceditor.js';
import Alignment from '@ckeditor/ckeditor5-alignment/src/alignment.js';
import AutoImage from '@ckeditor/ckeditor5-image/src/autoimage.js';
import Autoformat from '@ckeditor/ckeditor5-autoformat/src/autoformat.js';
import AutoLink from '@ckeditor/ckeditor5-link/src/autolink.js';
import Autosave from '@ckeditor/ckeditor5-autosave/src/autosave.js';
import BlockQuote from '@ckeditor/ckeditor5-block-quote/src/blockquote.js';
import Bold from '@ckeditor/ckeditor5-basic-styles/src/bold.js';
import CKBox from '@ckeditor/ckeditor5-ckbox/src/ckbox.js';
import CloudServices from '@ckeditor/ckeditor5-cloud-services/src/cloudservices.js';
import DataFilter from '@ckeditor/ckeditor5-html-support/src/datafilter.js';
import DataSchema from '@ckeditor/ckeditor5-html-support/src/dataschema.js';
import Essentials from '@ckeditor/ckeditor5-essentials/src/essentials.js';
import FindAndReplace from '@ckeditor/ckeditor5-find-and-replace/src/findandreplace.js';
import FontColor from '@ckeditor/ckeditor5-font/src/fontcolor.js';
import FontFamily from '@ckeditor/ckeditor5-font/src/fontfamily.js';
import FontSize from '@ckeditor/ckeditor5-font/src/fontsize.js';
import GeneralHtmlSupport from '@ckeditor/ckeditor5-html-support/src/generalhtmlsupport.js';
import Heading from '@ckeditor/ckeditor5-heading/src/heading.js';
import Highlight from '@ckeditor/ckeditor5-highlight/src/highlight.js';
import HorizontalLine from '@ckeditor/ckeditor5-horizontal-line/src/horizontalline.js';
import HtmlComment from '@ckeditor/ckeditor5-html-support/src/htmlcomment.js';
import Image from '@ckeditor/ckeditor5-image/src/image.js';
import ImageCaption from '@ckeditor/ckeditor5-image/src/imagecaption.js';
import ImageResize from '@ckeditor/ckeditor5-image/src/imageresize.js';
import ImageStyle from '@ckeditor/ckeditor5-image/src/imagestyle.js';
import ImageToolbar from '@ckeditor/ckeditor5-image/src/imagetoolbar.js';
import ImageUpload from '@ckeditor/ckeditor5-image/src/imageupload.js';
import InsertKeyPoints from './insert_key_points.js';
import Italic from '@ckeditor/ckeditor5-basic-styles/src/italic.js';
import Link from '@ckeditor/ckeditor5-link/src/link.js';
import LinkImage from '@ckeditor/ckeditor5-link/src/linkimage.js';
import List from '@ckeditor/ckeditor5-list/src/list.js';
import ListProperties from '@ckeditor/ckeditor5-list/src/listproperties.js';
import MediaEmbed from '@ckeditor/ckeditor5-media-embed/src/mediaembed.js';
import Paragraph from '@ckeditor/ckeditor5-paragraph/src/paragraph.js';
import PasteFromOffice from '@ckeditor/ckeditor5-paste-from-office/src/pastefromoffice.js';
import PictureEditing from '@ckeditor/ckeditor5-image/src/pictureediting.js';
import RemoveFormat from '@ckeditor/ckeditor5-remove-format/src/removeformat.js';
import SourceEditing from '@ckeditor/ckeditor5-source-editing/src/sourceediting.js';
import SpecialCharacters from '@ckeditor/ckeditor5-special-characters/src/specialcharacters.js';
import SpecialCharactersArrows from '@ckeditor/ckeditor5-special-characters/src/specialcharactersarrows.js';
import SpecialCharactersCurrency from '@ckeditor/ckeditor5-special-characters/src/specialcharacterscurrency.js';
import SpecialCharactersEssentials from '@ckeditor/ckeditor5-special-characters/src/specialcharactersessentials.js';
import Style from '@ckeditor/ckeditor5-style/src/style.js';
import Subscript from '@ckeditor/ckeditor5-basic-styles/src/subscript.js';
import Superscript from '@ckeditor/ckeditor5-basic-styles/src/superscript.js';
import Table from '@ckeditor/ckeditor5-table/src/table.js';
import TableCaption from '@ckeditor/ckeditor5-table/src/tablecaption.js';
import TableCellProperties from '@ckeditor/ckeditor5-table/src/tablecellproperties';
import TableColumnResize from '@ckeditor/ckeditor5-table/src/tablecolumnresize.js';
import TableProperties from '@ckeditor/ckeditor5-table/src/tableproperties';
import TableToolbar from '@ckeditor/ckeditor5-table/src/tabletoolbar.js';
import TextTransformation from '@ckeditor/ckeditor5-typing/src/texttransformation.js';
import Underline from '@ckeditor/ckeditor5-basic-styles/src/underline.js';
import WordCount from '@ckeditor/ckeditor5-word-count/src/wordcount.js';
import WProofreader from '@webspellchecker/wproofreader-ckeditor5/src/wproofreader';
import EditorWatchdog from '@ckeditor/ckeditor5-watchdog/src/editorwatchdog.js';

// Load an external CKEditor CSS file
const link = document.createElement('link');
link.rel = 'stylesheet';
link.href = 'https://cdn.ckeditor.com/ckeditor5/45.0.0/ckeditor5.css';
document.head.appendChild(link);

const ckTokenUrl = `${window.location.origin}/endpoints/ckeditor-endpoint`;

// add French characters
function AddFrenchCharacters(editor) {
    const specialCharacters = editor.plugins.get('SpecialCharacters');
    specialCharacters.addItems('French', [
        { title: 'Cedilla (ç)', character: 'ç' },
        { title: 'Capital Cedilla (Ç)', character: 'Ç' },
        { title: 'E Acute (é)', character: 'é' },
        { title: 'Capital E Acute (É)', character: 'É' },
        { title: 'E Grave (è)', character: 'è' },
        { title: 'Capital E Grave (È)', character: 'È' },
        { title: 'A Circumflex (â)', character: 'â' },
        { title: 'Capital A Circumflex (Â)', character: 'Â' },
        { title: 'E Circumflex (ê)', character: 'ê' },
        { title: 'Capital E Circumflex (Ê)', character: 'Ê' },
        { title: 'O Circumflex (ô)', character: 'ô' },
        { title: 'Capital O Circumflex (Ô)', character: 'Ô' }
    ]);
}

class Editor extends ClassicEditor { }

// Plugins to include in the build.
Editor.builtinPlugins = [
    Alignment,
    AutoImage,
    Autoformat,
    AutoLink,
    Autosave,
    BlockQuote,
    Bold,
    CKBox,
    CloudServices,
    DataFilter,
    DataSchema,
    Essentials,
    FindAndReplace,
    FontColor,
    FontFamily,
    FontSize,
    GeneralHtmlSupport,
    Heading,
    Highlight,
    HorizontalLine,
    HtmlComment,
    Image,
    ImageCaption,
    ImageResize,
    ImageStyle,
    ImageToolbar,
    ImageUpload,
    InsertKeyPoints,
    Italic,
    Link,
    LinkImage,
    List,
    ListProperties,
    MediaEmbed,
    Paragraph,
    PasteFromOffice,
    PictureEditing,
    RemoveFormat,
    SourceEditing,
    SpecialCharacters,
    SpecialCharactersArrows,
    SpecialCharactersCurrency,
    SpecialCharactersEssentials,
    AddFrenchCharacters,
    Style,
    Subscript,
    Superscript,
    Table,
    TableCaption,
    TableCellProperties,
    TableColumnResize,
    TableProperties,
    TableToolbar,
    TextTransformation,
    Underline,
    WordCount,
    WProofreader
];

document.addEventListener('DOMContentLoaded', function () {
    // Get all elements with the "editor" class
    const editorElements = document.querySelectorAll(".editor");

    //Set serviceId and site language depending on site
    let servId, siteLang;

    if (document.documentElement.lang === 'en-CA') {
        servId = 'fu3PtF9xYtAkFgt';
        siteLang = 'en_CA';
    } else {
        servId = 'S4GVljxeHzqGrTO';
        siteLang = 'en_US';
    }

    // Iterate over each element and create the editor
    editorElements.forEach((element) => {

        Editor.create(element, {
            licenseKey: 'eyJhbGciOiJFUzI1NiJ9.eyJleHAiOjE3NDM4MTExOTksImp0aSI6IjMwYjVhODM5LTU5NGItNGEzMi1iMmMxLWIxMzQwZmY4ZTg0ZiIsImRpc3RyaWJ1dGlvbkNoYW5uZWwiOlsic2giLCJkcnVwYWwiXSwid2hpdGVMYWJlbCI6dHJ1ZSwiZmVhdHVyZXMiOlsiRFJVUCJdLCJ2YyI6IjRkNmFmNWM2In0.aa_FL8BYu4Thvv-61GQHK_Aptt8AIVN29WYVk4ljIUB_MKHWh13ERC7eV1XwkkAyX9NmM5_tSw5jXH2gUfwNWQ',
            toolbar: {
                items: [
                    'sourceEditing',
                    '|',
                    'heading',
                    '|',
                    'undo',
                    'redo',
                    'bold',
                    'italic',
                    'underline',
                    'link',
                    'bulletedList',
                    'numberedList',
                    'subscript',
                    'superscript',
                    '|',
                    'ckbox',
                    'blockQuote',
                    'insertKeyPoints',
                    'insertTable',
                    'mediaEmbed',
                    'alignment',
                    'findAndReplace',
                    '|',
                    'removeFormat',
                    'specialCharacters',
                    '|',
                    'fontColor',
                    'fontSize',
                    'fontFamily',
                    '|',
                    'horizontalLine',
                    'highlight',
                    'wproofreader'
                ],
                shouldNotGroupWhenFull: true
            },
            htmlSupport: {
                allow: [
                    {
                        name: 'div',
                        attributes: true,
                        classes: true,
                        styles: true
                    },
                    {
                        name: 'span',
                        attributes: true,
                        classes: true,
                        styles: true
                    },
                    {
                        name: 'a',
                        attributes: true,
                        classes: true
                    },
                    {
                        name: 'script',
                        attributes: {
                            type: 'application/ld+json'
                        }
                    },
                    {
                        name: 'img',
                        attributes: true,
                        classes: true
                    },
                    {
                        name: 'figure',
                        attributes: true,
                        classes: true
                    },
                    {
                        name: 'input',
                        attributes: true,
                        classes: true
                    },
                    {
                        name: 'h1',
                        attributes: true,
                        classes: true
                    },
                    {
                        name: 'h2',
                        attributes: true,
                        classes: true
                    },
                    {
                        name: 'h3',
                        attributes: true,
                        classes: true
                    },
                    {
                        name: 'h4',
                        attributes: true,
                        classes: true
                    },
                    {
                        name: 'h5',
                        attributes: true,
                        classes: true
                    },
                    {
                        name: 'h6',
                        attributes: true,
                        classes: true
                    },
                    {
                        name: 'li',
                        attributes: true,
                        classes: true
                    }
                ]
            },
            language: 'en',
            link: {
                defaultProtocol: 'https://',
                decorators: {
                    openInNewTab: {
                        mode: 'automatic',
                        callback: url => url && !(/healthyhearing|hearingdirectory|hhcake/.test(url)) && !url.startsWith('#') && !url.startsWith('/'),
                        attributes: {
                            target: '_blank',
                            rel: 'noopener noreferrer'
                        }
                    }
                }
            },
            image: {
                toolbar: [
                    'imageTextAlternative',
                    'toggleImageCaption',
                    'imageStyle:inline',
                    'imageStyle:block',
                    'imageStyle:side',
                    'linkImage'
                ],
                styles: [
                    'alignLeft',
                    'alignCenter',
                    'alignRight',
                ]
            },
            table: {
                contentToolbar: [
                    'tableColumn',
                    'tableRow',
                    'mergeTableCells',
                    'tableCellProperties',
                    'tableProperties'
                ]
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
            },
            ckbox: {
                tokenUrl: ckTokenUrl
            },
            wproofreader: {
                lang: siteLang,
                serviceId: servId,
                srcUrl: 'https://svc.webspellchecker.net/spellcheck31/wscbundle/wscbundle.js'
            }
        }).catch(error => {
            console.error(error);
        });
    });
});