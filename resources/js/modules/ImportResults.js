import ImportResult from './ImportResult';

class ImportResults
{
    constructor(node) {
        this.node = node;
        console.log(node);
        this.resultsContainer = document.createElement('div');
        this.resultsContainer.classList.add('ImportResult');
        
        const title = document.createElement('h1');
        title.innerText = 'Results';
        this.resultsContainer.appendChild(title);

        this.node.appendChild(this.resultsContainer);
    }

    parseResults(data, index) {
        console.log('parseResults', index);
        data.forEach(result => {
            console.log(result);
            const container = document.createElement('div');
            container.id = `result-${index}`;
            container.classList.add('ImportResult-entry');
            container.id = `result-${result.original.id}`;

            const preview = document.createElement('div');
            preview.classList.add('preview');
            if (result.success) {
                preview.classList.add('success');
            } else {
                preview.classList.add('fail');
            }

            const id = document.createElement('span');
            id.innerText = `ID: ${result.original.id}`;
            preview.appendChild(id);

            const body = document.createElement('div');
            body.classList.add('content');

            const pre = document.createElement('pre');
            pre.innerHTML = this.parseLog(result);

            body.appendChild(pre);
            container.appendChild(preview);
            container.appendChild(body);
            this.resultsContainer.appendChild(container);

            new ImportResult(container);
        });
    }

    parseLog(result) {
        let markup = '';

        result.log.forEach(line => {
            let classes = line.indexOf('error') >= 0 ? 'log-error' : 'log-info';
            markup += `<span class="${classes}">${line}</span><br>`;
        });

        return markup;
    }
}

export const onInit = () => {
    const resultsContainer = document.querySelector('.ImportResults');
    if (resultsContainer) {
        window.importResults = new ImportResults(resultsContainer);
    }
};