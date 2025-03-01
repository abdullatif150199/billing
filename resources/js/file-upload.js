const ATTRIBUTE_TARGET = 'data-custom-file-upload';

/**
 * Mengambil nama file dan ukuran dan diformat `<nama-file> - <ukuran-file Kb>`
 * @param {Element} element
 */
function getFilenameAndSize(element) {
    // Get the selected file
    const [file] = element.files;
    // Get the file name and size
    const { name: fileName, size } = file;
    // Convert size in bytes to kilo bytes
    const fileSize = (size / 1000).toFixed(2);

    return `${fileName} - ${fileSize}Kb`
}

/**
 * Men-update tampilan custom file upload
 * @param {Element} element
 */
export function updateDisplayFileUpload(element) {
    const parentElement = element.parentElement
    const targetDisplay = element.getAttribute(ATTRIBUTE_TARGET);
    const displayText = parentElement.querySelector(targetDisplay);
    displayText.textContent = getFilenameAndSize(element)
}
