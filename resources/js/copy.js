const ATTRIBUTE_TARGET = 'data-copy-from';

/**
 * @param {HTMLInputElement} element
 */
export function copyToHandler(element) {
    const targetAttribute = element.getAttribute(ATTRIBUTE_TARGET);
    const tooltip = element.parentElement.querySelector('[data-tooltip]');
    const target = document.querySelector(targetAttribute);

    tooltip.classList.add('opacity-100');
    setTimeout(() => {
        tooltip.classList.remove('opacity-100');
    }, 1000);

    navigator.clipboard.writeText(target.textContent);
}
