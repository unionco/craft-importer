export class ApiClient {
    constructor() {
        this.requests = null;
        this.index = 0;
        //window.resultsHandler = new ResultsHandler();
    }

    makeRequest(requests, index = 0) {
        this.requests = requests;
        this.index = 0;

        this.req(this.requests[this.index])
            .then(resp => resp.json())
            .then(data => this.reqCallback(data))
            .catch(err => console.log(err))
            .finally(() => {
                if (window.ajaxSpinner) {
                    window.ajaxSpinner.hide();
                }
            });

    }

    req(request) {
        return fetch(request.url, {
            method: 'post',
            credentials: 'same-origin',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
            },
            body: request.body,
        })
    }

    reqCallback(data) {
        if (window.importResults) {
            window.importResults.parseResults(data, this.index);
        }

        this.index++;
         
        if (window.ajaxSpinner) {
            const count = this.requests.length;
            window.ajaxSpinner.show(`Processing ${this.index+1}/${count} entries...`);
        }
        console.log(data);
        if (this.index >= this.requests.length) {
            return Promise.resolve(true);
        }
        return this.req(this.requests[this.index])
            .then(resp => resp.json())
            .then(data => this.reqCallback(data));
    }
}