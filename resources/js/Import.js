import '../sass/Import.scss';

import {
  onInit as fileUpload
} from './modules/FileUpload';

import {
  onInit as submitButton
} from './modules/SubmitButton';

class Import {
  constructor() {
    console.log('Hello, world!');
    fileUpload();
    submitButton();
  }
}

window.onload = () => {
  if (document.querySelector('[data-import-plugin]')) {
    new Import();
  }
};