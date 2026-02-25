import './admin_common';

// Make Priority column editable
document.addEventListener('DOMContentLoaded', () => {
      document.querySelectorAll<HTMLElement>('.inline_ajax').forEach(el => {
            const originalText = el.textContent?.trim() || '';
            const endpoint = '/admin/utils/inlineajax';

            // Add tooltip/cursor hint via title or CSS
            el.title = 'Click to edit...';
            el.style.cursor = 'pointer';

            el.addEventListener('click', () => {
                  if (el.isContentEditable) return; // Prevent double-activation

                  // Save original for cancel
                  el.dataset.original = originalText;

                  // Show loading indicator style
                  el.classList.add('editing');
                  el.contentEditable = 'true';
                  el.focus();

                  // Select all text for easy overwrite
                  const range = document.createRange();
                  range.selectNodeContents(el);
                  const sel = window.getSelection();

                  if (sel) {
                        sel.removeAllRanges();
                        sel.addRange(range);
                  }
            });

            el.addEventListener('blur', async () => {
                  if (!el.isContentEditable) return;

                  const newValue = el.textContent?.trim() || '';

                  if (newValue === el.dataset.original) {
                        // No change → revert UI
                        finishEditing(el);
                        return;
                  }

                  // Show loading (replace text with indicator)
                  const originalHTML = el.innerHTML;
                  el.innerHTML = '<img src="/img/ajax-loader.gif" alt="Saving...">';

                  // Get CSRF token
                  const csrfTokenInput = document.querySelector<HTMLInputElement>('input[name="_csrfToken"]');
                  const csrfToken = csrfTokenInput?.value;

                  try {
                        const response = await fetch(endpoint, {
                              method: 'POST',
                              headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-Token': csrfToken || '',
                                    'X-Requested-With': 'XMLHttpRequest'
                              },
                              body: JSON.stringify({
                                    value: newValue,
                                    id: el.id
                              })
                        });

                        if (!response.ok) {
                              const errorText = await response.text();
                              console.error('Server response:', errorText);
                              throw new Error('Save failed');
                        }

                        // Try to parse as JSON, if it fails just use the text response
                        const contentType = response.headers.get('content-type');
                        let data;

                        if (contentType && contentType.includes('application/json')) {
                              data = await response.json();

                              // Check if backend returned an error
                              if (data.error) {
                                    throw new Error(data.error);
                              }
                        } else {
                              // Backend returned plain text
                              await response.text();
                        }

                        // Success: Update element with new value
                        el.textContent = newValue;
                        finishEditing(el);
                  } catch (err) {
                        alert("Error saving. Reverting...");
                        el.innerHTML = originalHTML;
                        finishEditing(el);
                        console.error('Error saving inline edit:', err);
                  }
            });

            // Enter to save, Esc to cancel
            el.addEventListener('keydown', (e: KeyboardEvent) => {
                  if (e.key === 'Enter') {
                        e.preventDefault();
                        el.blur(); // Triggers save
                  } else if (e.key === 'Escape') {
                        el.textContent = el.dataset.original || '';
                        finishEditing(el);
                  }
            });
      });

      function finishEditing(el: HTMLElement): void {
            el.contentEditable = 'false';
            el.classList.remove('editing');
            delete el.dataset.original;
      }
});