/**
 * @license Copyright (c) 2014-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */
import { ClassicEditor } from 'ckeditor5';
import {
  Alignment,
  Autoformat,
  Autosave,
  Bold,
  CloudServices,
  Essentials,
  FindAndReplace,
  GeneralHtmlSupport,
  Italic,
  Link,
  List,
  ListProperties,
  Paragraph,
  PasteFromOffice,
  StandardEditingMode,
  Underline,
  WordCount
} from 'ckeditor5';
import InsertKeyPoints from './insert_key_points.js';
import WProofreader from '@webspellchecker/wproofreader-ckeditor5/src/wproofreader';

import 'ckeditor5/ckeditor5.css';

interface WordCountStats {
  words: number;
  characters: number;
}

const ckTokenUrl = `${window.location.origin}/endpoints/ckeditor-endpoint`;

// Add French characters plugin
function AddFrenchCharacters(editor: any): void {
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

document.addEventListener('DOMContentLoaded', function () {
  // Get all elements with the "editor" class
  const editorElements = document.querySelectorAll<HTMLElement>(".editor");

  // Set serviceId and site language depending on site
  let servId: string;
  let siteLang: string;

  if (document.documentElement.lang === 'en-CA') {
    servId = 'fu3PtF9xYtAkFgt';
    siteLang = 'en_CA';
  } else {
    servId = 'S4GVljxeHzqGrTO';
    siteLang = 'en_US';
  }

  // Iterate over each element and create the editor
  editorElements.forEach((element: HTMLElement) => {
    ClassicEditor.create(element, {
      licenseKey: 'eyJhbGciOiJFUzI1NiJ9.eyJleHAiOjE3NDM4MTExOTksImp0aSI6IjMwYjVhODM5LTU5NGItNGEzMi1iMmMxLWIxMzQwZmY4ZTg0ZiIsImRpc3RyaWJ1dGlvbkNoYW5uZWwiOlsic2giLCJkcnVwYWwiXSwid2hpdGVMYWJlbCI6dHJ1ZSwiZmVhdHVyZXMiOlsiRFJVUCJdLCJ2YyI6IjRkNmFmNWM2In0.aa_FL8BYu4Thvv-61GQHK_Aptt8AIVN29WYVk4ljIUB_MKHWh13ERC7eV1XwkkAyX9NmM5_tSw5jXH2gUfwNWQ',
      plugins: [
        Alignment,
        Autoformat,
        Autosave,
        Bold,
        CloudServices,
        Essentials,
        FindAndReplace,
        GeneralHtmlSupport,
        Highlight,
        Image,
        InsertKeyPoints,
        Italic,
        Link,
        List,
        ListProperties,
        Paragraph,
        PasteFromOffice,
        AddFrenchCharacters,
        Underline,
        WordCount,
        WProofreader
      ],
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
            callback: (url: string | undefined) => url && !(/healthyhearing|hearingdirectory|hhcake/.test(url)) && !url.startsWith('#') && !url.startsWith('/'),
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
      cloudServices: {
        tokenUrl: ckTokenUrl
      },
      ckbox: {
        tokenUrl: ckTokenUrl
      },
      wproofreader: {
        lang: siteLang,
        serviceId: servId,
        srcUrl: 'https://svc.webspellchecker.net/spellcheck31/wscbundle/wscbundle.js'
      },
      wordCount: {
        onUpdate: (stats: WordCountStats) => {
          const wordCountElement = document.querySelector<HTMLElement>('.ck-word-count');
          if (wordCountElement) {
            wordCountElement.textContent = `Word count: ${stats.words}`;
          }
        }
      }
    } as any).catch((error: Error) => {
      console.error(error);
    });
  });
});