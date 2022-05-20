window.onload = () =>{
    const input = document.getElementById('editor');
    const editor = CodeMirror.fromTextArea(input, {lineNumbers: true, tabSize: 4});
}

// OPEN MENUS FUNCTIONS
let subMenu = document.getElementById("sub-menu");
let sizeSubMenu = document.getElementById("size-sub-menu");
let arrowIcon = document.getElementById('Myarrow');
let arrowIcon2 = document.getElementById('Myarrow2');

function openFontSizeMenu(){
    if(!sizeSubMenu.classList.contains('opened')){
        sizeSubMenu.classList.add('opened');
        arrowIcon.style.transform = "rotate(180deg)";
    }
    else{
        sizeSubMenu.classList.remove('opened');
        arrowIcon.style.transform = "rotate(0deg)";
    }
}

function openSubMenu(){
    if(!subMenu.classList.contains('opened')){
        subMenu.classList.add('opened');
        arrowIcon2.style.transform = "rotate(180deg)";
    }
    else{
        subMenu.classList.remove('opened');
        arrowIcon2.style.transform = "rotate(0deg)";
    }
}

// UI FUNCTIONS
function changeFontSize(pixels){
    const codeMirror = document.querySelector('.CodeMirror');
    codeMirror.style.fontSize = pixels + "px";
}

function changeFontFamily(fontFamily){
    const codeMirror = document.querySelector('.CodeMirror');
    codeMirror.style.fontFamily = fontFamily;
}