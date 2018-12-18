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
        
        const formData = this.serialize()

        fetch(this.submitUrl, {
                method: 'post',
                credentials: 'same-origin',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                },
                body: formData,
            })
            .then(resp => resp.json())
            .then(data => {
                console.log(data);
                if (window.importResults) {
                    window.importResults.parseResults(data);
                }
            })
            .finally(() => {
                if (window.ajaxSpinner) {
                    window.ajaxSpinner.hide();
                }
                this.hide();
            });

    }

    serialize() {
        const formData = new FormData();
        // Get the original import file name
        const file = document.querySelector('[name="importFile"]');
        if (file) {
            formData.append('importFile', file.value);
        }
        const allInputs = document.querySelectorAll('input,select');
        //'.ImportPreview-entry--field>.input>*');
        if (allInputs && allInputs.length) {
            Array.prototype.forEach.call(allInputs, input => {
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
            });
        }

        return formData;
    }
}

export const onInit = () => {
    const submitButton = document.querySelector('#submitButton');
    if (submitButton) {
        window.submitButton = new SubmitButton(submitButton);
    }
};