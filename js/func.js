function confirmAction() {
    if (confirm("Вы уверены?")) {
        return true;
    } else {
        return false;
    }
}

function confirmFill() {
    if (confirm("Вы уверены?")) {
        rewrite();
        return true;
    } else {
        return false;
    }
}

function rewrite() {
    $('a#zap_mest').html("Заполнено");
}