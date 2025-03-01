/**
 * @param {Event} event
 */
export function handleFormGet(event) {
    event.preventDefault();

    const elementForm = event.target;
    const input = elementForm.querySelectorAll('[data-custom-form]');
    let query = "?";
    input.forEach((element) => element.value != "" ? query += `${element.getAttribute('name')}=${element.value}&` : null);
    window.location.search = query;
}
