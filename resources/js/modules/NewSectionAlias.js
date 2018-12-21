export default class NewSectionAlias {
    constructor(node) {
        this.node = node;
        this.id = node.id.split('-').reverse()[0];
        this.handle = document.querySelector(`#handle-${this.id}`).value;
        this.node.addEventListener('change', this.handleChange.bind(this));
        this.node.dataset.handle = 'Abry';
        console.log(this.handle);
    }

    handleChange(e) {
        const entriesWithSameHandle = document.querySelectorAll('[id*=section-handle]');
        if (entriesWithSameHandle && entriesWithSameHandle.length) {
            Array.prototype.forEach.call(entriesWithSameHandle, entry => {
                const id = entry.id.split('-').reverse()[0];
                const sectionSelect = document.querySelectorAll(`#section-${id}`);
                if (sectionSelect) {
                    sectionSelect.value = e.target.value;
                }
            })
        }
    }
}