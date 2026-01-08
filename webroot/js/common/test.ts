// webroot/js/common/test.ts
// Simple test file to verify Vite works

console.log('Vite is truly working!');

// If this file imports jQuery, do it like this:
import $ from 'jquery';

// Make jQuery global (temporary, until you migrate away from global jQuery)
(window as any).$ = $;
(window as any).jQuery = $;

export default {};