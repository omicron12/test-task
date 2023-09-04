import ApplicationController from "./application_controller";

export default class extends ApplicationController {

    connect() {
        this.targets.forEach(name => {
            document.querySelectorAll(`[name="${name}"]`)
                .forEach((field) =>
                    field.addEventListener('change', (event) => this.asyncLoadData(event))
                );
        });

        if (!document.querySelector('.loading-modal')) {
            const loadingModal = document.createElement('div');
            loadingModal.innerHTML = '<div class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></div><div>Загрузка...</div>'
            loadingModal.className = 'loading-modal';
            document.body.appendChild(loadingModal);
            document.body.addEventListener('begin loading', this.handleBeginLoading);
            document.body.addEventListener('end loading', this.handleEndLoading);
        }
    }

    asyncLoadData(event) {
        let data = new FormData();

        if (event.target.dataset.single) {
            data.append('id', event.target.dataset.id);
            data.append('method', event.target.dataset.method);
            data.append('value', event.target.value);

            let params = new URLSearchParams(window.location.search);

            for (let [key, value] of params) {
                data.append(key, value);
            }

        } else {
            data = new FormData(this.element.closest('form'));
        }

        this.loadStream(this.data.get('async-route'), data);
    }

    handleBeginLoading(event) {
        document.body.classList.add('loading');
    }

    handleEndLoading(event) {
        document.body.classList.remove('loading');
    }

    get targets() {
        return JSON.parse(this.data.get('targets'));
    }
}
