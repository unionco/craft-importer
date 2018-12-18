import '../sass/Import.scss';

import { onInit as fileUpload } from './modules/FileUpload';
import { onInit as submitButton } from './modules/SubmitButton';
import { onInit as ajaxSpinner } from './modules/AjaxSpinner';
import { onInit as importResults } from './modules/ImportResults';

class Import {
  constructor() {
    fileUpload();
    submitButton();
    ajaxSpinner();
    importResults();
  }
}

window.onload = () => {
  if (document.querySelector('[data-import-plugin]')) {
    window.Import = new Import();
  }
};