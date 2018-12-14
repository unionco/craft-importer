import '../sass/Import.scss';
//import Garnish from 'garnishjs';

import {
  onInit as fileUpload
} from './modules/FileUpload';

import {
  onInit as submitButton
} from './modules/SubmitButton';

import craftExtension from './modules/CraftExtension';



class Import {
  constructor() {
    console.log('Hello, world!');
    fileUpload();
    submitButton();
  }
}

window.onload = () => {
  if (document.querySelector('[data-import-plugin]')) {
    window.Import = new Import();
  }

  $.extend(Craft, craftExtension);
  //Garnish
};

    // (function ($, Craft) {
    //   $.extend(Craft, {
    //     SectionSelectInput: SectionSelectInput,
    //     createSectionSelectorModal: function(elementType, settings) => {
    //       var func;

    //       if (typeof this._elementSelectorModalClasses[elementType] !== 'undefined') {
    //         func = this._elementSelectorModalClasses[elementType];
    //       } else {
    //         func = Craft.BaseElementSelectorModal;
    //       }

    //       return new func(elementType, settings);
    //     },
    //   });
    // })(jQuery, Craft);