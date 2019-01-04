import '../sass/Import.scss';

import FileUpload from './modules/FileUpload';
import SectionPreview from './modules/SectionPreview';
import AjaxSpinner from './modules/AjaxSpinner';
import ImportResults from './modules/ImportResults';
import {
  ApiClient
} from './modules/ApiClient';
import ImportPreview from './modules/ImportPreview';

class Import {
  constructor() {
    this.apiClient = new ApiClient();

    const fileUpload = document.querySelector('#FileUpload')
    this.fileUpload = new FileUpload(fileUpload);

    const sectionPreview = document.querySelector('#SectionPreview');
    this.sectionPreview = new SectionPreview(sectionPreview);

    const importPreview = document.querySelector('#ImportPreview');
    this.importPreview = new ImportPreview(importPreview);

    const importResults = document.querySelector('#ImportResults');
    this.importResults = new ImportResults(importResults);

    const body = document.querySelector('body');
    this.ajaxSpinner = new AjaxSpinner(body);
  }
}

window.onload = () => {
  window.Import = new Import();
};