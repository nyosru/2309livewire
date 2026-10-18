document.querySelectorAll('[data-image-manager]').forEach((manager) => {
    const currentImages = manager.querySelector('[data-current-images]');
    const input = manager.querySelector('[data-file-input]');
    const dropZone = manager.querySelector('[data-drop-zone]');
    const previews = manager.querySelector('[data-upload-previews]');
    let selectedFiles = [];
    let previewUrls = [];

    const updateCoverLabel = () => {
        currentImages.querySelectorAll('[data-current-image]').forEach((item, index) => {
            item.querySelector('[data-cover-label]').hidden = index !== 0;
        });
    };

    const syncInput = () => {
        const transfer = new DataTransfer();
        selectedFiles.forEach((file) => transfer.items.add(file));
        input.files = transfer.files;
    };

    const renderPreviews = () => {
        previewUrls.forEach((url) => URL.revokeObjectURL(url));
        previewUrls = [];
        previews.replaceChildren();

        selectedFiles.forEach((file, index) => {
            const item = document.createElement('div');
            const image = document.createElement('img');
            const name = document.createElement('span');
            const remove = document.createElement('button');
            const url = URL.createObjectURL(file);

            previewUrls.push(url);
            item.className = 'upload-preview-item';
            image.src = url;
            image.alt = file.name;
            name.className = 'upload-preview-name';
            name.textContent = file.name;
            remove.className = 'image-remove';
            remove.type = 'button';
            remove.setAttribute('aria-label', `Убрать ${file.name} из загрузки`);
            remove.textContent = '×';
            remove.addEventListener('click', () => {
                selectedFiles.splice(index, 1);
                syncInput();
                renderPreviews();
            });

            item.append(image, name, remove);
            previews.append(item);
        });
    };

    const setFiles = (files) => {
        selectedFiles = Array.from(files).filter((file) => [
            'image/jpeg',
            'image/png',
            'image/webp',
        ].includes(file.type));
        syncInput();
        renderPreviews();
    };

    currentImages.addEventListener('click', (event) => {
        const remove = event.target.closest('[data-remove-image]');

        if (! remove) {
            return;
        }

        remove.closest('[data-current-image]').remove();
        updateCoverLabel();
    });

    input.addEventListener('change', () => setFiles(input.files));

    ['dragenter', 'dragover'].forEach((eventName) => {
        dropZone.addEventListener(eventName, (event) => {
            event.preventDefault();
            dropZone.classList.add('is-dragover');
        });
    });

    ['dragleave', 'drop'].forEach((eventName) => {
        dropZone.addEventListener(eventName, (event) => {
            event.preventDefault();
            dropZone.classList.remove('is-dragover');
        });
    });

    dropZone.addEventListener('drop', (event) => setFiles(event.dataTransfer.files));
});
