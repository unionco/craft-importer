export class ApiClient {
    constructor() {
        this.uploadUrl = '/admin/import/upload';
        this.sectionsUrl = '/admin/import/preview-entries';
        this.entryImportUrl = '/admin/import/submit';
        this.requests = null;
        this.index = 0;
        //window.resultsHandler = new ResultsHandler();
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
        this.req(this.sectionsUrl, formData)
            .then(resp => resp.text())
            .then(data => callback(data))
            .finally(() => {
                window.Import.ajaxSpinner.hide();
            });
    }

    entryRequest(requests) {
        this.requests = requests;
        this.index = 0;

        this.req(this.entryImportUrl, this.requests[this.index])
            .then(resp => resp.text())
            .then(data => this.entryRequestCallback(data))
            .catch(err => console.log(err))
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

    entryRequestCallback(data) {
        window.Import.importResults.parse(data);
        this.index++;

        const count = this.requests.length;
        window.Import.ajaxSpinner.show(`Processing ${this.index}/${count} entries...`);

        if (this.index >= this.requests.length) {
            return Promise.resolve(true);
        }
        return this.req(this.entryImportUrl, this.requests[this.index])
            .then(resp => resp.text())
            .then(data => this.entryRequestCallback(data));
    }
}