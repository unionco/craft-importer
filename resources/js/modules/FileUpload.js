class FileUpload {
    constructor(node) {
        this.element = node;
        this.uploadUrl = '/admin/import/upload';
        console.log('FileUpload');
        this.input = document.querySelector('[data-import-file-upload] > input[type="file"]');
        if (this.input) {
            this.input.addEventListener('change', this.upload.bind(this));
        }
    }

    upload(e) {
        this.input.disabed = true;

        const formData = new FormData();

        // some data check
        const files = e.target.files;
        Array.prototype.forEach.call(files, f => {
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
}

export const onInit = () => {
    const fileUploads = document.querySelectorAll('[data-import-file-upload]');
    if (fileUploads && fileUploads.length) {
        Array.prototype.forEach.call(fileUploads, f => {
            new FileUpload(f);
        });
    }
}