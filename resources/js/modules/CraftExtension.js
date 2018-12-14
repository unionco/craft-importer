import SectionSelectInput from './SectionSelectInput';
import SectionSelectorModal from './SectionSelectorModal';
import SectionIndex from './SectionIndex';

export default {
    SectionSelectInput: SectionSelectInput,
    SectionSelectorModal: SectionSelectorModal,
    SectionIndex: SectionIndex,
    createSectionSelectorModal: function (elementType, settings) {
        var func;

        if (typeof this._elementSelectorModalClasses[elementType] !== 'undefined') {
            func = this._elementSelectorModalClasses[elementType];
        } else {
            func = Craft.SectionSelectorModal;
        }

        return new func(elementType, settings);
    },
    createSectionIndex: function(_elementType, $container, settings) {
        const elementType = 'craft\\models\\Section';
        var func;

        if (typeof this._elementIndexClasses[elementType] !== 'undefined') {
            func = this._elementIndexClasses[elementType];
        }
        else {
            func = Craft.SectionIndex;
        }

        return new func(elementType, $container, settings);
    },
};