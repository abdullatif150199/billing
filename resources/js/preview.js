const TARGET_ATTRIBUTE = 'data-preview';
const CLOSE_ATTRIBUTE = '[data-close]';

/**
 * @param {Element} element
 */
export function previewInit(element) {
    const targetAttribute = element.getAttribute(TARGET_ATTRIBUTE);
    const targetElement = document.querySelector(targetAttribute);

    const closeButton = element.querySelector(CLOSE_ATTRIBUTE);

    closeButton.addEventListener('click', () => {
        element.classList.add('hidden');
    });

    targetElement.addEventListener('click', () => {
        element.classList.remove('hidden');
    });
}

