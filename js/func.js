function confirmAction() {
    if (confirm("�� �������?")) {
        return true;
    } else {
        return false;
    }
}

function confirmFill() {
    if (confirm("�� �������?")) {
        rewrite();
        return true;
    } else {
        return false;
    }
}

function rewrite() {
    $('a#zap_mest').html("���������");
}