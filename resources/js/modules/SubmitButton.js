import { ApiClient } from './ApiClient';
class SubmitButton {
    constructor(node) {
        this.container = node;
        this.button = node.children[0];
        this.action = node.children[1];
        this.submitUrl = this.action.value;
        this.button.addEventListener('click', this.submit.bind(this));
    }

    show() {
        this.container.classList.add('active');
    }

    hide() {
        this.container.classList.remove('active');
    }

    submit(e) {
        if (window.ajaxSpinner) {
            window.ajaxSpinner.show();
        }

        e.preventDefault();
        
        const requests = this.serialize()

        if (requests && requests.length) {
            if (window.ajaxSpinner) {
                const count = requests.length;
                window.ajaxSpinner.show(`Processing 1/${count} entries...`);
            }

            const apiClient = new ApiClient();
            apiClient.makeRequest(requests, 0);
        }
    }

    serialize() {
        const requests = [];

        // Get the original import file name
        const file = document.querySelector('[name="importFile"]');
        
        const entries = document.querySelectorAll('.ImportPreview-entry');
        Array.prototype.forEach.call(entries, entry => {
            const formData = new FormData();
            if (file) {
                formData.append('importFile', file.value);
            }
            // Foreach input in this entry
            const inputs = entry.querySelectorAll('input, select');
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

            requests.push({
                url: this.submitUrl,
                body: formData
            });
        });

        return requests;
    }
}

export const onInit = () => {
    const submitButton = document.querySelector('#submitButton');
    if (submitButton) {
        window.submitButton = new SubmitButton(submitButton);
    }
};