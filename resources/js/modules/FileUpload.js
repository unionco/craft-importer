const removeDragData = e => {
    if (e.dataTransfer.items) {
        e.dataTransfer.items.clear();
    } else {
        e.dataTransfer.clearData();
    }
};

class FileUpload {
    constructor(node) {
        this.element = node;
        this.uploadUrl = '/admin/import/upload';
        this.label = 'Choose a file';
        this.files = [];

        // Drag/drop
        this.element.addEventListener('drop', this.dropHandler.bind(this));
        this.element.addEventListener('dragover', this.dragOverHandler.bind(this));

        // Input type="file"
        this.input = document.querySelector('input[type="file"].FileUpload-input');
        if (this.input) {
            this.input.addEventListener('change', this.fileSelectHandler.bind(this));
        }
    }

    upload() {
        const formData = new FormData();
        
        Array.prototype.forEach.call(this.files, f => {
            formData.append('files[]', f, f.name);
        });

        fetch(this.uploadUrl, {
                method: 'post',
                credentials: 'same-origin',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                },
                body: formData,
            })
            .then(resp => resp.text())
            .then(data => {
                const container = document.querySelector('[data-import-file-upload-result]');
                container.innerHTML = data;
            });
    }

    fileSelectHandler(e) {
        this.input.disabed = true;
        this.files = e.target.files;
        this.updateLabel();

        this.upload();
    }

    dropHandler(e) {
        console.log(e);
        e.preventDefault();

        if (e.dataTransfer.items) {
            Array.prototype.forEach.call(e.dataTransfer.items, item => {
                if (item.kind === 'file') {
                    const file = item.getAsFile();
                    this.files.push(file);
                }
            });
        } else {
            Array.prototype.forEach.call(e.dataTransfer.files, file => {
                this.files.push(file);
            })
        }

        this.updateLabel();
        removeDragData(e);
        this.upload();

        return;
    }

    dragOverHandler(e) {
        e.preventDefault();

        return;
    }

    updateLabel() {
        this.label = '';
        if (this.files && this.files.length) {
            console.log(this.files);
            Array.prototype.forEach.call(this.files, file => {
                if (this.label.length) {
                    this.label += ', ';
                }
                this.label += file.name;
            })
        } else {
            this.label = 'Choose a file';
        }
        document.querySelector('.FileUpload-input + label>span').innerText = this.label;
    }
}

export const onInit = () => {
    const fileUploads = document.querySelectorAll('[data-import-file-upload]');
    if (fileUploads && fileUploads.length) {
        Array.prototype.forEach.call(fileUploads, f => {
            new FileUpload(f);
        });
    }
}