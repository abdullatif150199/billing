import autoFillHandler from './auto-fill';
import './bootstrap';

import { toggleDropdown } from './dropdown';
import { updateDisplayFileUpload } from './file-upload';
import { copyToHandler } from './copy';
import { previewInit } from './preview';
import { toggleRevealHandler } from './reveal';
import { handleFormGet } from './form';

function main() {
    const dropdownButtons = document.querySelectorAll('[data-dropdown-target]');
    const customFileUpload = document.querySelectorAll('[data-custom-file-upload]');
    const autoFillElements = document.querySelectorAll('[data-auto-fill-target]');
    const copyFromElement = document.querySelectorAll('[data-copy-from]');
    const previewElements = document.querySelectorAll('[data-preview]');
    const revealElements = document.querySelectorAll('[data-reveal-target]');
    const formGetElements = document.querySelectorAll('[data-custom-form-get]');

    formGetElements.forEach((element) => {
        element.addEventListener('submit', (e) => handleFormGet(e));
    })

    revealElements.forEach((element) => {
        element.addEventListener('click', () => toggleRevealHandler(element));
        toggleRevealHandler(element);
    })

    previewElements.forEach((element) => {
        previewInit(element)
    });

    autoFillElements.forEach((elements) => {
        elements.addEventListener('input', () => autoFillHandler(elements));
    })

    dropdownButtons.forEach((dropdownButton) => {
        dropdownButton.addEventListener('click', () => toggleDropdown(dropdownButton));
        toggleDropdown(dropdownButton); // simulate event
    });

    customFileUpload.forEach((fileUpload) => {
        fileUpload.addEventListener('change', () => updateDisplayFileUpload(fileUpload));
    })

    copyFromElement.forEach((element) => {
        element.addEventListener('click', () => copyToHandler(element));
    })
}

function popoutKonfirmasiHapus(nama, id, alamat, url, token) {
    const overlayDiv = document.createElement('div');
    overlayDiv.classList.add('flex', 'justify-center', 'items-center', 'fixed' , 'bg-gray-400', 'bg-opacity-20', 'p-2', 'z-[999]', 'top-0', 'left-0', 'w-screen', 'h-screen');

    const divCard = document.createElement('div');
    divCard.classList.add('flex', 'flex-col', 'gap-2', 'justify-center', 'items-center', 'bg-gray-400', 'p-8');
    overlayDiv.appendChild(divCard);

    const titleElement = document.createElement('h1');
    titleElement.textContent = "Yakin ingin menghapus?";
    titleElement.classList.add('text-red-600', 'text-3xl', 'mb-2');
    divCard.appendChild(titleElement);

    const namaElement = document.createElement('p');
    namaElement.classList.add('text-xl');
    namaElement.textContent = nama;
    divCard.appendChild(namaElement);

    const idElement = document.createElement('p');
    idElement.classList.add('text-xl');
    idElement.textContent = `ID : ${id}`;
    divCard.appendChild(idElement);

    const alamatElement = document.createElement('p');
    alamatElement.classList.add('text-xl');
    alamatElement.textContent = alamat;
    divCard.appendChild(alamatElement);

    const divPilihan = document.createElement('div');
    divPilihan.classList.add('flex', 'flex-row-reverse', 'justify-between', 'w-full');
    divCard.appendChild(divPilihan);

    const tidakButton = document.createElement('button');
    tidakButton.addEventListener('click', () => document.body.removeChild(overlayDiv));
    tidakButton.classList.add('bg-green-500', 'p-1', 'text-white', 'text-xl');
    tidakButton.textContent = "TIDAK";
    divPilihan.appendChild(tidakButton);

    const yakinForm = document.createElement('form');
    yakinForm.setAttribute('method', 'post');
    yakinForm.innerHTML = `<input type="hidden" name="_token" value="${token}" /> <input type="hidden" name="_method" value="delete">`;
    yakinForm.setAttribute('action', url);
    const yaButton = document.createElement('button');
    yaButton.classList.add('bg-red-500', 'py-1', 'px-4', 'text-white', 'text-xl');
    yaButton.setAttribute('type', 'submit');
    yaButton.textContent = "YA!";
    yakinForm.appendChild(yaButton);

    divPilihan.appendChild(yakinForm);

    document.body.appendChild(overlayDiv);
}

window.popoutKonfirmasiHapus = popoutKonfirmasiHapus;
window.addEventListener('load', main);

