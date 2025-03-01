import { useState } from "./state";

const STATE_ATTRIBUTE = 'data-dropdown-state';
const TARGET_ATTRIBUTE = 'data-dropdown-target';

const ON = '1';
const OFF = '0';

export function toggleDropdown(targetElement) {
    const state = useState(targetElement, STATE_ATTRIBUTE, OFF);
    const dropdownContainerTarget = targetElement.getAttribute(TARGET_ATTRIBUTE);
    const dropdownContainerElement = document.querySelector(dropdownContainerTarget);
    const iconElement = targetElement.querySelector('[data-dropdown-icon]');

    if (state.value == ON) {
        state.value = OFF;

        if (iconElement != null)
            iconElement.classList.remove('rotate-90');

        dropdownContainerElement.classList.remove('absolute', 'opacity-0', 'pointer-events-none');

        return;
    }

    if (iconElement != null)
        iconElement.classList.add('rotate-90');

    dropdownContainerElement.classList.add('absolute', 'opacity-0', 'pointer-events-none');

    state.value = ON;
}
