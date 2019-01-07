export default class ImportPreviewEntry {
    constructor(node) {
        this.node = node;
        this.sectionSelect = this.node.querySelector('[name*=section]');
        this.sectionPreview = this.node.querySelector('[data-section]')
        this.entryTypeSelect = this.node.querySelector('[name*=type]');
        this.entryTypePreview = this.node.querySelector('[data-entry-type]')
        this.preview = this.node.querySelector('.preview');
        this.body = this.node.querySelector('.content');

        this.updateSectionPreview = this.updateSectionPreview.bind(this);
        this.updateEntryTypePreview = this.updateEntryTypePreview.bind(this);

        if (this.preview && this.body) {
            this.preview.addEventListener('click', this.toggleExpand.bind(this));
        }

        this.initDropdowns();
        this.initMultiSelects();
        this.initPreview();
    }

    toggleExpand() {
        this.body.classList.toggle('active');
    }

    initDropdowns() {
        const dropdowns = this.node.querySelectorAll('select');
        if (dropdowns && dropdowns.length) {
            dropdowns.forEach(dropdown => {
                const namePrefix = dropdown.name.replace(/\[[0-9]+\]/, '');
                switch (namePrefix) {
                    case 'section':
                        dropdown.addEventListener('change', this.updateSectionPreview);
                        dropdown.addEventListener('change', this.updateType.bind(this));
                        break;
                    default:
                        dropdown.addEventListener('change', this.updateEntryTypePreview);
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

    initPreview() {
        this.updateSectionPreview();
        this.updateEntryTypePreview();
    }

    updateSectionPreview() {
        this.sectionPreview.innerText = this.sectionSelect.selectedOptions[0].innerText;
        this.updateEntryTypePreview();
    }

    updateEntryTypePreview() {
        this.entryTypePreview.innerText = this.entryTypeSelect.selectedOptions[0].innerText;
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
                    this.entryTypeSelect.innerHTML = options;
                } else {
                    console.log('Error');
                    this.entryTypeSelect.innerHTML = '';
                }
            })
            .then(() => this.updateEntryTypePreview());
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