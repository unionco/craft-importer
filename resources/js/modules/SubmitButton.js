class SubmitButton {
    constructor(node) {
        this.button = node;
        this.submitUrl = this.button.dataset.submitButton;
        this.button.addEventListener('click', this.submit.bind(this));
    }

    submit(e) {
        e.preventDefault();
        if (!parseInt(this.button.dataset.valid)) {
            console.log('Disabled');
            return;
        }

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
            });

    }

    serialize() {
        const formData = new FormData();
        const allInputs = document.querySelectorAll('.ImportPreview-entry--field>.input>*');
        if (allInputs && allInputs.length) {
            Array.prototype.forEach.call(allInputs, input => {
                formData.append(input.name, input.value);
            });
        }

        return formData;
    }
}

export const onInit = () => {
    const submitButtons = document.querySelectorAll('[data-submit-button]');
    if (submitButtons && submitButtons.length) {
        Array.prototype.forEach.call(submitButtons, button => {
            new SubmitButton(button);
        });
    }
};