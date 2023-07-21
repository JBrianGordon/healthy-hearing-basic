/**
 * @license Copyright (c) 2014-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */
import ClassicEditor from '../../../node_modules/@ckeditor/ckeditor5-editor-classic/src/classiceditor.js';
import Alignment from '../../../node_modules/@ckeditor/ckeditor5-alignment/src/alignment.js';
import AutoImage from '../../../node_modules/@ckeditor/ckeditor5-image/src/autoimage.js';
import Autoformat from '../../../node_modules/@ckeditor/ckeditor5-autoformat/src/autoformat.js';
import AutoLink from '../../../node_modules/@ckeditor/ckeditor5-link/src/autolink.js';
import Autosave from '../../../node_modules/@ckeditor/ckeditor5-autosave/src/autosave.js';
import BlockQuote from '../../../node_modules/@ckeditor/ckeditor5-block-quote/src/blockquote.js';
import Bold from '../../../node_modules/@ckeditor/ckeditor5-basic-styles/src/bold.js';
import CloudServices from '../../../node_modules/@ckeditor/ckeditor5-cloud-services/src/cloudservices.js';
import Code from '../../../node_modules/@ckeditor/ckeditor5-basic-styles/src/code.js';
import DataFilter from '../../../node_modules/@ckeditor/ckeditor5-html-support/src/datafilter.js';
import DataSchema from '../../../node_modules/@ckeditor/ckeditor5-html-support/src/dataschema.js';
import Essentials from '../../../node_modules/@ckeditor/ckeditor5-essentials/src/essentials.js';
import FindAndReplace from '../../../node_modules/@ckeditor/ckeditor5-find-and-replace/src/findandreplace.js';
import FontColor from '../../../node_modules/@ckeditor/ckeditor5-font/src/fontcolor.js';
import FontFamily from '../../../node_modules/@ckeditor/ckeditor5-font/src/fontfamily.js';
import FontSize from '../../../node_modules/@ckeditor/ckeditor5-font/src/fontsize.js';
import GeneralHtmlSupport from '../../../node_modules/@ckeditor/ckeditor5-html-support/src/generalhtmlsupport.js';
import Heading from '../../../node_modules/@ckeditor/ckeditor5-heading/src/heading.js';
import Highlight from '../../../node_modules/@ckeditor/ckeditor5-highlight/src/highlight.js';
import HorizontalLine from '../../../node_modules/@ckeditor/ckeditor5-horizontal-line/src/horizontalline.js';
import HtmlComment from '../../../node_modules/@ckeditor/ckeditor5-html-support/src/htmlcomment.js';
import HtmlEmbed from '../../../node_modules/@ckeditor/ckeditor5-html-embed/src/htmlembed.js';
import Image from '../../../node_modules/@ckeditor/ckeditor5-image/src/image.js';
import ImageCaption from '../../../node_modules/@ckeditor/ckeditor5-image/src/imagecaption.js';
import ImageInsert from '../../../node_modules/@ckeditor/ckeditor5-image/src/imageinsert.js';
import ImageResize from '../../../node_modules/@ckeditor/ckeditor5-image/src/imageresize.js';
import ImageStyle from '../../../node_modules/@ckeditor/ckeditor5-image/src/imagestyle.js';
import ImageToolbar from '../../../node_modules/@ckeditor/ckeditor5-image/src/imagetoolbar.js';
import ImageUpload from '../../../node_modules/@ckeditor/ckeditor5-image/src/imageupload.js';
import Indent from '../../../node_modules/@ckeditor/ckeditor5-indent/src/indent.js';
import IndentBlock from '../../../node_modules/@ckeditor/ckeditor5-indent/src/indentblock.js';
import Italic from '../../../node_modules/@ckeditor/ckeditor5-basic-styles/src/italic.js';
import Link from '../../../node_modules/@ckeditor/ckeditor5-link/src/link.js';
import LinkImage from '../../../node_modules/@ckeditor/ckeditor5-link/src/linkimage.js';
import List from '../../../node_modules/@ckeditor/ckeditor5-list/src/list.js';
import ListProperties from '../../../node_modules/@ckeditor/ckeditor5-list/src/listproperties.js';
import MediaEmbed from '../../../node_modules/@ckeditor/ckeditor5-media-embed/src/mediaembed.js';
import MediaEmbedToolbar from '../../../node_modules/@ckeditor/ckeditor5-media-embed/src/mediaembedtoolbar.js';
import PageBreak from '../../../node_modules/@ckeditor/ckeditor5-page-break/src/pagebreak.js';
import Paragraph from '../../../node_modules/@ckeditor/ckeditor5-paragraph/src/paragraph.js';
import PasteFromOffice from '../../../node_modules/@ckeditor/ckeditor5-paste-from-office/src/pastefromoffice.js';
import RemoveFormat from '../../../node_modules/@ckeditor/ckeditor5-remove-format/src/removeformat.js';
import SelectAll from '../../../node_modules/@ckeditor/ckeditor5-select-all/src/selectall.js';
import SourceEditing from '../../../node_modules/@ckeditor/ckeditor5-source-editing/src/sourceediting.js';
import SpecialCharacters from '../../../node_modules/@ckeditor/ckeditor5-special-characters/src/specialcharacters.js';
import SpecialCharactersArrows from '../../../node_modules/@ckeditor/ckeditor5-special-characters/src/specialcharactersarrows.js';
import SpecialCharactersCurrency from '../../../node_modules/@ckeditor/ckeditor5-special-characters/src/specialcharacterscurrency.js';
import SpecialCharactersEssentials from '../../../node_modules/@ckeditor/ckeditor5-special-characters/src/specialcharactersessentials.js';
import StandardEditingMode from '../../../node_modules/@ckeditor/ckeditor5-restricted-editing/src/standardeditingmode.js';
import Strikethrough from '../../../node_modules/@ckeditor/ckeditor5-basic-styles/src/strikethrough.js';
import Style from '../../../node_modules/@ckeditor/ckeditor5-style/src/style.js';
import Subscript from '../../../node_modules/@ckeditor/ckeditor5-basic-styles/src/subscript.js';
import Superscript from '../../../node_modules/@ckeditor/ckeditor5-basic-styles/src/superscript.js';
import Table from '../../../node_modules/@ckeditor/ckeditor5-table/src/table.js';
import TableCaption from '../../../node_modules/@ckeditor/ckeditor5-table/src/tablecaption.js';
import TableCellProperties from '../../../node_modules/@ckeditor/ckeditor5-table/src/tablecellproperties';
import TableColumnResize from '../../../node_modules/@ckeditor/ckeditor5-table/src/tablecolumnresize.js';
import TableProperties from '../../../node_modules/@ckeditor/ckeditor5-table/src/tableproperties';
import TableToolbar from '../../../node_modules/@ckeditor/ckeditor5-table/src/tabletoolbar.js';
import TextTransformation from '../../../node_modules/@ckeditor/ckeditor5-typing/src/texttransformation.js';
import Underline from '../../../node_modules/@ckeditor/ckeditor5-basic-styles/src/underline.js';
import WordCount from '../../../node_modules/@ckeditor/ckeditor5-word-count/src/wordcount.js';
import EditorWatchdog from '../../../node_modules/@ckeditor/ckeditor5-watchdog/src/editorwatchdog.js';

//Importing custom CSS
import '../../css/ckeditor.css';

class Editor extends ClassicEditor {}

// Plugins to include in the build.
Editor.builtinPlugins = [
    Alignment,
    AutoImage,
    Autoformat,
    AutoLink,
    Autosave,
    BlockQuote,
    Bold,
    CloudServices,
    Code,
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
    HtmlEmbed,
    Image,
    ImageCaption,
    ImageInsert,
    ImageResize,
    ImageStyle,
    ImageToolbar,
    ImageUpload,
    Indent,
    IndentBlock,
    Italic,
    Link,
    LinkImage,
    List,
    ListProperties,
    MediaEmbed,
    MediaEmbedToolbar,
    PageBreak,
    Paragraph,
    PasteFromOffice,
    RemoveFormat,
    SelectAll,
    SourceEditing,
    SpecialCharacters,
    SpecialCharactersArrows,
    SpecialCharactersCurrency,
    SpecialCharactersEssentials,
    StandardEditingMode,
    Strikethrough,
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
    WordCount
];

// Editor configuration.
Editor.defaultConfig = {
    toolbar: {
        items: [
            'heading',
            '|',
            'bold',
            'italic',
            'link',
            'bulletedList',
            'numberedList',
            '|',
            'outdent',
            'indent',
            '|',
            'imageUpload',
            'blockQuote',
            'insertTable',
            'mediaEmbed',
            'undo',
            'redo',
            'alignment',
            'code',
            'findAndReplace',
            'fontColor',
            'fontSize',
            'fontFamily',
            'highlight',
            'horizontalLine',
            'htmlEmbed',
            'imageInsert',
            'pageBreak',
            'removeFormat',
            'selectAll',
            'sourceEditing',
            'specialCharacters',
            'strikethrough',
            'restrictedEditingException',
            'style',
            'subscript',
            'superscript',
            'underline'
        ],
        shouldNotGroupWhenFull: true
    },
    language: 'en',
    image: {
        toolbar: [
            'imageTextAlternative',
            'toggleImageCaption',
            'imageStyle:inline',
            'imageStyle:block',
            'imageStyle:side',
            'linkImage'
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
    }
};

export { Editor, EditorWatchdog };
