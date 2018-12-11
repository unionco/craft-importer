import '../sass/Import.scss';

import {
  onInit as fileUpload
} from './modules/FileUpload';

class Import {
  constructor() {
    console.log('Hello, world!');
    fileUpload();
  }
}

window.onload = () => {
  if (document.querySelector('[data-import-plugin]')) {
    new Import();
  }
};