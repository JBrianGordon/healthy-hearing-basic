import { Plugin, SpecialCharacters } from 'ckeditor5';
import type { Editor } from 'ckeditor5';

export default class AddFrenchCharacters extends Plugin {
    static get requires() {
        return [SpecialCharacters] as const;
    }

    init(): void {
        const editor: Editor = this.editor;

        const specialCharacters = editor.plugins.get('SpecialCharacters') as SpecialCharacters;
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
}