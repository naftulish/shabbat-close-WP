function scwp_toggle_input(elem, id){
    document.querySelector( '#' + id ).disabled = !elem.checked;
    document.querySelector( '#' + id ).required = elem.checked;
}
