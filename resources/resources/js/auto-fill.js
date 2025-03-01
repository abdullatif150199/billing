const ATTRIBUTE_TARGET = 'data-auto-fill-target'

/**
 * Otomatis mengisi target element dipisah dengan koma
 * @param {HTMLInputElement} element
 */
export default function autoFillHandler(element) {
    const targetValue = element.value;
    const targets = element.getAttribute(ATTRIBUTE_TARGET).split(',');
    targets.forEach((target) => {
        /**
        * @var {HTMLInputElement}
        */
        const element = document.querySelector(target);
        element.value = targetValue;
    })
}
