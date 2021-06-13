"use strict";

// language picker toggling
const desktopLangPicker = document.getElementById('language-picker');
const mobileLangPicker = document.getElementById('mobile-language-picker');

([desktopLangPicker, mobileLangPicker]).forEach(langPicker => {
    langPicker.addEventListener('click', langClickWrapper(langPicker));

    langPicker.addEventListener('mouseover', langMouseOverWrapper(langPicker));

    langPicker.addEventListener('mouseout', langMouseOutWrapper(langPicker));
});


function langClickWrapper(targetEl) {
    const innerFun = () => {
        targetEl.classList.toggle('activated');
        for (const child of targetEl.children) {
            if (child.classList.contains('language-choice')) {
                child.classList.toggle('display-none');
                child.classList.toggle('display-block');
            }
        }
    };
    return innerFun;
}


function langMouseOverWrapper(targetEl) {
    const innerFun = () => {
        targetEl.classList.add('activated');
        for (const child of targetEl.children) {
            if (child.classList.contains('language-choice')) {
                child.classList.remove('display-none');
                child.classList.add('display-block');
            }
        }
    };
    return innerFun;
}

function langMouseOutWrapper(targetEl) {
    const innerFun = () => {
        targetEl.classList.remove('activated');
        for (const child of targetEl.children) {
            if (child.classList.contains('language-choice')) {
                child.classList.add('display-none');
                child.classList.remove('display-block');
            }
        }
    };
    return innerFun;
}







// mobile navigation toggling
const menuToggle = document.getElementById('menu-toggle');
const mobileNav = document.getElementById('mobile-nav');
const mobileNavShadow = document.getElementById('mobile-nav-shadow');

let isThrottling = false;

menuToggle.addEventListener('click', () => {
    if (isThrottling) {
        return;
    }
    if (mobileNav.classList.contains('active')) {
        isThrottling = true;
        setTimeout(
            () => {
                mobileNavShadow.classList.toggle('active')
                mobileNav.classList.toggle('active')
                isThrottling = false;
            },
            1000
        );
        window.requestAnimationFrame(rightStep);
        window.requestAnimationFrame(downOpacity);
    } else {
        isThrottling = true;
        setTimeout(
            () => {
                isThrottling = false;
            },
            1000
        );
        mobileNavShadow.classList.toggle('active');
        mobileNav.classList.toggle('active');
        window.requestAnimationFrame(leftStep);
        window.requestAnimationFrame(upOpacity);
    }
});

window.addEventListener('resize', () => {
    if (isThrottling) {
        return;
    }
    if (mobileNav.classList.contains('active') && window.innerWidth > 700) {
        isThrottling = true;
        setTimeout(
            () => {
                mobileNavShadow.classList.toggle('active')
                mobileNav.classList.toggle('active')
                isThrottling = false;
            },
            1000
        );
        window.requestAnimationFrame(rightStep);
        window.requestAnimationFrame(downOpacity);
    }
});

let start;

function leftStep(timestamp) {
    if (start === undefined)
      start = timestamp;
    const elapsed = timestamp - start;
  
    // `Math.min()` is used here to make sure that the element stops at exactly 50vw.
    let vwWal = Math.max(100 - 0.2 * elapsed, 50)
    mobileNav.style.left = vwWal + 'vw';
  
    if (elapsed < 1000 || vwWal > 50) { // Stop the animation after 1 second
        window.requestAnimationFrame(leftStep);
    } else {
        start = undefined;
    }
}
 
function rightStep(timestamp) {
    if (start === undefined)
      start = timestamp;
    const elapsed = timestamp - start;
  
    // `Math.min()` is used here to make sure that the element stops at exactly 100vw.
    let vWval = Math.min(50 + 0.2 * elapsed, 100);
    mobileNav.style.left = vWval + 'vw';

    if (elapsed < 1000 || vWval < 100) { 
        window.requestAnimationFrame(rightStep);
    } else {
        start = undefined;
    }
}

let opStart;

function upOpacity(timestamp) {
    if (opStart === undefined)
        opStart = timestamp;
    const elapsed = timestamp - opStart;
  
    // `Math.min()` is used here to make sure that the element stops at exactly 0.9.
    let opa = Math.min(0.0018 * elapsed, 0.9);
    mobileNavShadow.style.opacity = opa;

    if (elapsed < 500 || opa < 0.9) { 
        window.requestAnimationFrame(upOpacity);
    } else {
        opStart = undefined;
    }
}

function downOpacity(timestamp) {
    if (opStart === undefined)
        opStart = timestamp;
    const elapsed = timestamp - opStart;
  
    let opa = Math.max(0.9 - 0.0018 * elapsed, 0);
    mobileNavShadow.style.opacity = opa;

    if (elapsed < 500 || opa > 0) { 
        window.requestAnimationFrame(downOpacity);
    } else {
        opStart = undefined;
    }
}