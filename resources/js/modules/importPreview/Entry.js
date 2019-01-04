const camelCase = str => {
    return str.replace(/(?:^\w|[A-Z]|\b\w)/g, function (letter, index) {
        return index == 0 ? letter.toLowerCase() : letter.toUpperCase();
    }).replace(/\s+/g, '');
};

export default class ImportPreviewEntry {
    constructor(node) {
        this.node = node;
        this.sectionSelect = this.node.querySelector('[name*=section]');
        this.entryTypeSelect = this.node.querySelector('[name*=type]');
        this.preview = node.children[0];
        this.body = node.children[1];

        if (this.preview && this.body) {
            this.preview.addEventListener('click', this.toggleExpand.bind(this));
        }

        this.initDropdowns();
        this.initMultiSelects();
    }

    toggleExpand() {
        this.body.classList.toggle('active');
    }

    initDropdowns() {
        const dropdowns = document.querySelectorAll('select');
        if (dropdowns && dropdowns.length) {
            Array.prototype.forEach.call(dropdowns, dropdown => {
                const namePrefix = dropdown.name.replace(/\[[0-9]+\]/, '');
                switch (namePrefix) {
                    case 'section':
                        dropdown.addEventListener('change', this.updateType.bind(this));
                        break;
                    default:
                }
            });
        }
    }

    initMultiSelects() {
        const multiSelectOptions = document.querySelectorAll('select[multiple]>option');
        Array.prototype.forEach.call(multiSelectOptions, opt => {
            opt.selected = true;
        });
    }

    updateType(e) {
        const newValue = parseInt(e.target.value);
        fetch(`/admin/import/sections/types/${newValue}`)
            .then(resp => resp.json())
            .then(data => {
                const newTypes = data;
                if (newTypes) {
                    let options = '';
                    for (let i = 0; i < newTypes.length; i++) {
                        options += `<option value="${newTypes[i].id}">${newTypes[i].name}</option>`;
                    }
                    this.type.innerHTML = options;
                } else {
                    console.log('Error');
                    this.type.innerHTML = '';
                }
            });
    }

    toggleSites(e) {
        const options = document.querySelectorAll(`select[name="sites[${this.id}][]"]>option`);
        if (options && options.length) {
            // Look at the first checkbox to see if we are checking/unchecking the rest of them
            const selected = options[0].selected;
            Array.prototype.forEach.call(options, option => {
                option.selected = !selected;
            });
        }
    }
}