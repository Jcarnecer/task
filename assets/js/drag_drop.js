function allowDrop(ev) {
    ev.preventDefault();
}

function drag(ev) {
    ev.dataTransfer.setData("order", ev.target.parentElement.getAttribute('data-order'));
}

function drop(ev) {
    ev.preventDefault();
    var data = ev.dataTransfer.getData("order");
    var list = document.getElementById('taskTileList');
    list.insertBefore(document.querySelector(`[data-order="${data}"]`), (ev.target.nodeName == "div" && ev.target.hasAttribute('data-order') ? ev.target : ev.target.closest('div[ondrop="drop(event)"]')));
}