import { Plugin } from '@ckeditor/ckeditor5-core';
import { ButtonView } from '@ckeditor/ckeditor5-ui';
import Command from '@ckeditor/ckeditor5-core/src/command';

class InsertKeyPointsCommand extends Command {
    execute() {
        const editor = this.editor;

        const html = `
          <div style="background-color:#fff;border:1px solid black;padding:10px 20px;filter:drop-shadow(4px 4px lightgrey);">
            <h3><strong>Key points:</strong></h3>
            <ul>
              <li><p>TEXT HERE</p></li>
              <li><p>TEXT HERE</p></li>
              <li><p>TEXT HERE</p></li>
            </ul>
          </div>
          <p></p>
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