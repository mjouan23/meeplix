import './bootstrap';

import jQuery from 'jquery';
window.$ = jQuery;
window.jQuery = jQuery;

import Modal from 'bootstrap/js/dist/modal';
window.bootstrap = { Modal };

import initBoardgameFileUploader from './dashboard/upload_files';
import { registerSW } from 'virtual:pwa-register';

// Initialise l'uploader si les éléments sont présents sur la page
if (document.getElementById('upload_pdf_btn')) {
    const uploadUrl = document.getElementById('upload_pdf_btn').dataset.uploadUrl;
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    initBoardgameFileUploader({ uploadUrl, csrfToken });
}

// PWA: enregistrement du Service Worker (vite-plugin-pwa)
registerSW({
  immediate: true,
  onNeedRefresh() {
    console.info('Nouvelle version disponible. Rechargez la page.');
  },
  onOfflineReady() {
    console.info('PWA prête à fonctionner hors-ligne.');
  },
});
