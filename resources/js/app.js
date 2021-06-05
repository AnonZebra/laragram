"use strict";

const langPicker = document.getElementById('language-picker');

langPicker.addEventListener('click', (e) => {
    langPicker.classList.toggle('activated');
    for (const child of langPicker.children) {
        if (child.classList.contains('language-choice')) {
            child.classList.toggle('display-none');
            child.classList.toggle('display-block');
        }
    }
});

langPicker.addEventListener('mouseover', (e) => {
    langPicker.classList.add('activated');
    for (const child of langPicker.children) {
        if (child.classList.contains('language-choice')) {
            child.classList.remove('display-none');
            child.classList.add('display-block');
        }
    }
});

langPicker.addEventListener('mouseout', (e) => {
    langPicker.classList.remove('activated');
    for (const child of langPicker.children) {
        if (child.classList.contains('language-choice')) {
            child.classList.add('display-none');
            child.classList.remove('display-block');
        }
    }
});