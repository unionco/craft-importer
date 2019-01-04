import ImportPreviewEntry from './importPreview/Entry';

export default class ImportPreview {
    constructor(node) {
        this.node = node;
        this.entries = [];
        this.start = this.start.bind(this);
        this.submitButton = null;
        this.setSubmitHidden = this.setSubmitHidden.bind(this);
    }

    start(data) {
        this.node.innerHTML = data;
        this.submitButton = this.node.querySelector('#ImportPreview-NextButton');
        this.submitButton.addEventListener('click', this.submit.bind(this));
        this.initEntries();
    }

    initEntries() {
        this.entries = [];
        this.node.querySelectorAll('.ImportPreview-entry').forEach(entry => {
            this.entries.push(new ImportPreviewEntry(entry));
        });
    }

    setSubmitHidden(hidden = false) {
        if (hidden) {
            this.submitButton.classList.add('hidden');
        } else {
            this.submitButton.classList.remove('hidden');
        }
    }
    submit() {
        const sectionMapping = this.node.querySelector('#ImportPreview-sectionMapping').value;
        const entries = this.node.querySelector('#ImportPreview-entries').value;
        const requests = [];
        window.Import.ajaxSpinner.show('Processing entries...');
        this.entries.forEach(entry => {
            // Check if import is checked
            if (!entry.node.querySelector('[type="checkbox"][name*=enabled]').checked) {
                return;
            }

            const formData = new FormData();
            formData.append('sectionMapping', sectionMapping);
            formData.append('entries', entries);

            // Foreach input in this entry
            const inputs = entry.node.querySelectorAll('input, select');
            if (inputs && inputs.length) {
                for (let i = 0; i < inputs.length; i++) {
                    let input = inputs[i];
                    if (input.disabled) {
                        return;
                    } else if (input.options !== undefined) {
                        // Select
                        let value = '';
                        Array.prototype.forEach.call(input.selectedOptions, opt => {
                            if (value.length) {
                                value += ',';
                            }
                            value += opt.value;
                        });
                        formData.append(input.name, value);
                    } else {
                        // Normal text input
                        formData.append(input.name, input.value);
                    }
                }
            }

            requests.push(formData);
        });

        window.Import.apiClient.importRequest(requests);
    }
}