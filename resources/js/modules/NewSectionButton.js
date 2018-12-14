class NewSectionButton {
    constructor(node) {
        this.node = node;
        this.node.addEventListener('click', this.addNewSection);
    }

    addNewSection() {
        const opts = {};
        Craft.postActionRequest(opts)
    }
}

export const onInit = () => {
    const newSectionButtons = document.querySelectorAll('[data-new-section-btn]');
    if (newSectionButtons) {
        Array.prototype.forEach.call(newSectionButtons, button => {
            new NewSectionButton(button);
        })
    }
};