import { Plugin } from '@ckeditor/ckeditor5-core';
import { ButtonView } from '@ckeditor/ckeditor5-ui';
import Command from '@ckeditor/ckeditor5-core/src/command';

class InsertKeyPointsCommand extends Command {
    execute() {
        const editor = this.editor;

        const html = `
          <div class="key-points mb50">
            <h3><strong>Key points:</strong></h3>
            <ul>
              <li class="mb50"><p>TEXT HERE</p></li>
              <li class="mb50"><p>TEXT HERE</p></li>
              <li><p>TEXT HERE</p></li>
            </ul>
          </div>
          <br>
        `;

        // Convert the HTML string to a view fragment for the model
        const viewFragment = editor.data.processor.toView(html);
        const modelFragment = editor.data.toModel(viewFragment);

        // Insert the content at the current selection position
        editor.model.insertContent(modelFragment, editor.model.document.selection);
    }
}

export default class InsertKeyPoints extends Plugin {
    init() {
        const editor = this.editor;

        // Register the command
        editor.commands.add('insertKeyPoints', new InsertKeyPointsCommand(editor));

        // Register the button in the UI component factory
        editor.ui.componentFactory.add('insertKeyPoints', locale => {
            const view = new ButtonView(locale);

            view.set({
                label: 'Key Points',
                tooltip: true,
                withText: true
            });

            // Execute the command when the button is clicked
            view.on('execute', () => {
                editor.execute('insertKeyPoints');
            });

            return view;
        });
    }
}