import '../sass/Import.scss';

import FileUpload from './modules/FileUpload';
import SectionPreview from './modules/SectionPreview';
import {
  onInit as submitButton
} from './modules/SubmitButton';
import AjaxSpinner from './modules/AjaxSpinner';
import {
  onInit as importResults
} from './modules/ImportResults';
import {
  ApiClient
} from './modules/ApiClient';
import EntryPreview from './modules/EntryPreview';

class Import {
  constructor() {
    this.apiClient = new ApiClient();

    const fileUpload = document.querySelector('#FileUpload')
    this.fileUpload = new FileUpload(fileUpload);

    const sectionPreview = document.querySelector('#SectionPreview');
    this.sectionPreview = new SectionPreview(sectionPreview);

    const entryPreview = document.querySelector('#EntryPreview');
    this.entryPreview = new EntryPreview(entryPreview);

    const body = document.querySelector('body');
    this.ajaxSpinner = new AjaxSpinner(body);
    importResults();
  }
}

window.onload = () => {
  window.Import = new Import();
};