import ImportResult from './ImportResult';

export default class ImportResults
{
    constructor(node) {
        this.node = node;
        this.results = [];

        this.resultsContainer = this.node.querySelector('.ImportResult');
        this.title = this.resultsContainer.querySelector('h1');
    }

    parse(data) {
        this.title.innerText = 'Results';
        const split = data.split(/\<\/div\>\s+\<div class="ImportResult-entry"/);
        if (split.length > 1) {
            split.forEach((result, index) => {
                result = result + "</div>";
                if (index > 0) {
                    result = '<div class="ImportResult-entry" ' + result;
                }
                const template = document.createElement('template');
                template.innerHTML = result.trim();

                this.resultsContainer.appendChild(template.content.firstChild);
                this.results.push(new ImportResult(template.content.firstChild));
            })
        } else {
            const template = document.createElement('template');
            template.innerHTML = data.trim();
            const html = template.content.firstChild;
            const node = this.resultsContainer.appendChild(html);
            this.results.push(new ImportResult(node));
        }
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