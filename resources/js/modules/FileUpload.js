import ImportPreview from './ImportPreview';
import NewSectionAlias from './NewSectionAlias';

const removeDragData = e => {
    if (e.dataTransfer.items) {
        e.dataTransfer.items.clear();
    } else {
        e.dataTransfer.clearData();
    }
};

export default class FileUpload {
    constructor(node) {
        this.element = node;
        this.uploadUrl = '/admin/import/upload';
        this.label = 'Choose a file';
        this.files = [];
        this.results = document.querySelector('[data-import-file-upload-result]');

        // Drag/drop
        this.element.addEventListener('drop', this.dropHandler.bind(this));
        this.element.addEventListener('dragover', this.dragOverHandler.bind(this));

        // Clear
        document.querySelector('[data-import-file-clear]').addEventListener('click', this.clearFiles.bind(this));
        // Input type="file"
        this.input = document.querySelector('input[type="file"].FileUpload-input');
        if (this.input) {
            this.input.addEventListener('change', this.fileSelectHandler.bind(this));
        }
    }

    upload() {
        if (window.ajaxSpinner) {
            window.ajaxSpinner.show();
            console.log('Ajax Spinner activated');
        }

        const formData = new FormData();

        Array.prototype.forEach.call(this.files, f => {
            formData.append('files[]', f, f.name);
        });
        window.Import.apiClient.fileUploadRequest(formData, window.Import.sectionPreview.start);
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

    clearFiles() {
        this.files = [];
        this.updateLabel();
        this.results.innerHTML = '';
    }

    updateLabel() {
        this.label = '';
        const labelSpan = document.querySelector('.FileUpload-input + label>span');
        const instructionSpan = document.querySelector('[data-import-file-instructions]');
        const clearSpan = document.querySelector('[data-import-file-clear]');

        if (this.files && this.files.length) {
            console.log(this.files);
            Array.prototype.forEach.call(this.files, file => {
                if (this.label.length) {
                    this.label += ', ';
                }
                this.label += file.name;
            })
            instructionSpan.classList.add('hidden');
            clearSpan.classList.remove('hidden');
        } else {
            this.label = 'Choose a file';
            instructionSpan.classList.remove('hidden');
            clearSpan.classList.add('hidden');
        }
        labelSpan.innerText = this.label;
    }
}

// export const onInit = () => {
//     const fileUploads = document.querySelectorAll('[data-import-file-upload]');
//     if (fileUploads && fileUploads.length) {
//         Array.prototype.forEach.call(fileUploads, f => {
//             new FileUpload(f);
//         });
//     }
// }