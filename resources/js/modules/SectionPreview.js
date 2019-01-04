export default class SectionPreview {
    constructor(node) {
        this.node = node;
        this.start = this.start.bind(this);
        this.checkStatus = this.checkStatus.bind(this);
        this.setNextStatus = this.setNextHidden.bind(this);
        this.nextButton = null;
        this.sectionMapping = {};
    }

    start(data) {
        this.node.innerHTML = data;
        this.nextButton = this.node.querySelector('#SectionPreview-NextButton');
        this.nextButton.addEventListener('click', this.submit.bind(this));
        this.checkStatus();
        this.mapSections();
    }

    mapSections() {
        this.node.querySelectorAll('select').forEach(element => {
            console.log(element);
            element.addEventListener('change', e => {
                const handle = this.node.querySelector('[name*=sectionHandle]').value;
                this.sectionMapping[handle] = e.target.value;
                
                // Check if all sections are mapped
                this.checkStatus();
            });
        })
    }

    checkStatus() {
        this.node.querySelectorAll('select')
            .forEach(element => {
                const value = element.value;
                if (!value || parseInt(value) == 0) {
                    this.setNextHidden(true);
                } else {
                    this.setNextHidden(false);
                }
            });
    }


    setNextHidden(hidden = false) {
        if (hidden) {
            this.nextButton.classList.add('hidden');
        } else {
            this.nextButton.classList.remove('hidden');
        }
    }

    submit() {
        const formData = new FormData();
        const serialized = document.querySelector('#SectionPreview-serialized').value;
        formData.append('serialized', serialized);
        for (const handle in this.sectionMapping) {
            formData.append('sectionMapping[' + handle + ']', this.sectionMapping[handle]);
        }
        window.Import.apiClient.submitSections(formData, (data) => {
            this.setNextHidden(true); // Hide the next button
            window.Import.importPreview.start(data);
        });
    }
}