export default class ImportResult {
    constructor(node) {
        this.node = node;
        this.preview = node.querySelector('.preview');
        this.body = node.querySelector('.content');
        if (this.preview && this.body) {
            this.preview.addEventListener('click', this.toggleExpand.bind(this));
        }
    }

    toggleExpand() {
        this.body.classList.toggle('active');
    }
}