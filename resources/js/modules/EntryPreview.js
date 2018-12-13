const camelCase = str => {
    return str.replace(/(?:^\w|[A-Z]|\b\w)/g, function (letter, index) {
        return index == 0 ? letter.toLowerCase() : letter.toUpperCase();
    }).replace(/\s+/g, '');
};

export default class EntryPreview {
    constructor(node) {
        this.node = node;
        this.id = node.id;
        this.section = document.querySelector(`#section-${this.id}`);
        this.type = document.querySelector(`#type-${this.id}`);

        this.section.addEventListener('change', this.updateType.bind(this));
        this.toggleSitesButton = document.querySelector(`[data-select-all-sites="sites[${this.id}][]"]`);
        if (this.toggleSitesButton) {
            this.toggleSitesButton.addEventListener('click', this.toggleSites.bind(this));
        }
        this.initDropdowns();
    }

    initDropdowns() {
        const dropdowns = document.querySelectorAll('[data-value]');
        if (dropdowns && dropdowns.length) {
            Array.prototype.forEach.call(dropdowns, dropdown => {
                let value = JSON.parse(dropdown.dataset.value);
                const name = dropdown.dataset.name;
                const camelName = camelCase(`select ${name}`);
                const options = JSON.parse(dropdown.dataset[camelName]);

                let matches;
                switch (name) {
                    case 'author':
                        value = value.email;
                        // Try to match based on email
                        matches = Array.prototype.filter.call(options, option => {
                            //console.log(option.email);
                            if (option.email == value) {
                                return true;
                            }
                        });
                        console.log(options);

                        //console.log('possible matches: ', matches);
                        break;
                    case 'type':
                        break;
                    case 'section':
                        //const matches = Ar
                        break;
                }

                let optionsMarkup = '';
                if (!matches || !matches.length) {
                    optionsMarkup += `<option default value="new-${value}">${value} (New)</option>`;
                }
                Array.prototype.forEach.call(options, option => {
                    let name = option.name;
                    if (!name) {
                        name = option.email;
                    }
                    optionsMarkup += `<option value="${option.id}">${name}</option>`;
                });
                dropdown.innerHTML = optionsMarkup;
            });
        }
    }

    updateType(e) {
        const newValue = parseInt(e.target.value);
        const allTypes = JSON.parse(this.type.dataset.selectType);
        // console.log(allTypes[newValue]);
        const newTypes = allTypes[newValue];
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
    }

    toggleSites(e) {
        const checkboxes = document.querySelectorAll(`input[name="sites[${this.id}][]`);
        if (checkboxes && checkboxes.length) {
            // Look at the first checkbox to see if we are checking/unchecking the rest of them
            const checked = checkboxes[0].checked;
            Array.prototype.forEach.call(checkboxes, checkbox => {
                checkbox.checked = !checked;
            });
        }
    }
}