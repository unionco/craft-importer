export class ApiClient {
    constructor() {
        this.importRequestCallback = this.importRequestCallback.bind(this);
        this.uploadUrl = '/admin/import/upload';
        this.sectionsUrl = '/admin/import/preview-entries';
        this.importUrl = '/admin/import/submit';
        this.requests = null;
        this.index = 0;
    }

    fileUploadRequest(formData, callback) {
        window.Import.ajaxSpinner.show('Uploading file...');
        this.req(this.uploadUrl, formData)
            .then(resp => resp.text())
            .then(data => callback(data))
            .finally(() => {
                window.Import.ajaxSpinner.hide();
            });
    }

    submitSections(formData, callback) {
        window.Import.ajaxSpinner.show('Processing sections...');
        this.req(this.sectionsUrl, formData)
            .then(resp => resp.text())
            .then(data => callback(data))
            .finally(() => {
                window.Import.ajaxSpinner.hide();
            });
    }

    importRequest(requests) {
        this.requests = requests;
        this.index = 0;
        window.Import.importPreview.setSubmitHidden(true);
        this.req(this.importUrl, this.requests[this.index])
            .then(resp => resp.text())
            .then(data => this.importRequestCallback(data))
            .catch(err => {
                console.log(err);
                window.Import.importPreview.setSubmitHidden(false);
            })
            .finally(() => {
                window.Import.ajaxSpinner.hide();
            });
    }

    req(url, body) {
        return fetch(url, {
            method: 'post',
            credentials: 'same-origin',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
            },
            body: body,
        })
    }

    importRequestCallback(data) {
        window.Import.importResults.parse(data);
        this.index++;

        const count = this.requests.length;
        window.Import.ajaxSpinner.show(`Processing ${this.index}/${count} entries...`);

        if (this.index >= this.requests.length) {
            return Promise.resolve(true);
        }

        return this.req(this.importUrl, this.requests[this.index])
            .then(resp => resp.text())
            .then(data => this.importRequestCallback(data));
    }
}