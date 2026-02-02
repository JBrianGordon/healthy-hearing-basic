/**
 * @license Copyright (c) 2014-2025, CKSource Holding sp. z o.o. All rights reserved.
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
    WordCount,
} from 'ckeditor5';

// Import the official CSS (replaces your theme/theme.css import)
import 'ckeditor5/ckeditor5.css';

// No more manual theme/theme.css — the unified package bundles it correctly

const ckTokenUrl = `${window.location.origin}/endpoints/ckeditor-endpoint`;

// Editor configuration
const editorConfig = {
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
        Italic,
        Link,
        List,
        ListProperties,
        Paragraph,
        PasteFromOffice,
        StandardEditingMode,
        Underline,
        WordCount,
        // WProofreader, // uncomment if you add it back
    ],
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
            // 'wproofreader',
        ],
        shouldNotGroupWhenFull: true,
    },
    language: 'en',
    link: {
        defaultProtocol: 'https://',
        decorators: {
            openInNewTab: {
                mode: 'manual' as const,
                label: 'Open in a new tab',
                attributes: {
                    target: '_blank',
                    rel: 'noopener noreferrer',
                },
            },
            addClass: {
                mode: 'manual' as const,
                label: 'Add orange button classes',
                attributes: {
                    class: 'text-link btn btn-secondary',
                },
            },
        },
    },
    heading: {
        options: [
            { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
            { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
            { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' },
            { model: 'heading4', view: 'h4', title: 'Heading 4', class: 'ck-heading_heading4' },
            { model: 'heading5', view: 'h5', title: 'Heading 5', class: 'ck-heading_heading5' },
            { model: 'heading6', view: 'h6', title: 'Heading 6', class: 'ck-heading_heading6' },
        ],
    },
    cloudServices: {
        tokenUrl: ckTokenUrl,
    },
};

document.addEventListener('DOMContentLoaded', () => {
    const editorElements = document.querySelectorAll<HTMLElement>('.editor');

    editorElements.forEach((element: HTMLElement, idx) => {

        if (element && element.offsetParent !== null) {
            ClassicEditor.create(element, {
                ...editorConfig,
                heading: {
                    options: [
                        { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                        { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                        { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' },
                        { model: 'heading4', view: 'h4', title: 'Heading 4', class: 'ck-heading_heading4' },
                        { model: 'heading5', view: 'h5', title: 'Heading 5', class: 'ck-heading_heading5' },
                        { model: 'heading6', view: 'h6', title: 'Heading 6', class: 'ck-heading_heading6' },
                    ],
                },
            })
                .then((editor) => {
                    editorElements.forEach((el) => {
                        el.style.display = 'block';
                        el.style.position = 'absolute';
                        el.style.zIndex = '-1';
                    });
                })
                .catch((error: Error) => {
                    console.error('Editor initialization error:', error);
                });
        } else {
            console.warn('Editor element not found or not visible:', element);
        }
    });
});