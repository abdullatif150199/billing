import { useState } from "./state";

const TARGET_ATTRIBUTE = 'data-reveal-target';
const STATE_ATTRIBUTE = 'data-reveal-state';

const ON = '1';
const OFF = '0';

/**
 * @param {Element} element
 */
export function toggleRevealHandler(element) {
    const targetElementIdent = element.getAttribute(TARGET_ATTRIBUTE);
    const targetElement = document.querySelector(targetElementIdent);
    const state = useState(targetElement, STATE_ATTRIBUTE, OFF);

    if (state.value == OFF) {
        targetElement.classList.add('hidden');
        state.value = ON;
        return;
    }

    targetElement.classList.remove('hidden');
    state.value = OFF;
}
