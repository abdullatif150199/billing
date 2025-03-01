/**
 * Store a state on the element
 * @param {Element} element
 * @param {string} key
 * @param {string} initial
 */
export function useState (element, key, initial) {
    let stateValue = element.getAttribute(key) ?? initial;
    element.setAttribute(key, stateValue);

    return {
        get value() {
            return stateValue
        },
        set value(newVal) {
            stateValue = newVal;
            element.setAttribute(key, stateValue);
        }
    }
}
