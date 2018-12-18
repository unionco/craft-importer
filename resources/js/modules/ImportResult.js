export default class ImportResult {
    constructor(node) {
        this.node = node;
        this.preview = node.children[0];
        this.body = node.children[1];
        if (this.preview && this.body) {
            this.preview.addEventListener('click', this.toggleExpand.bind(this));
        }
    }

    toggleExpand() {
        this.body.classList.toggle('active');
    }
}