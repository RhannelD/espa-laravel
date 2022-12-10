window.addEventListener('swal:modal', event => { 
    swal({
        title: event.detail.message,
        text: event.detail.text,
        icon: event.detail.type,
    });
});

window.addEventListener('redirect-blank', event => {
    window.open(event.detail.url, '_blank'); 
});

window.addEventListener('modal-toggle', event => {
    $("#"+event.detail.id).modal(event.detail.action);
});

window.addEventListener('scroll-to-top', event => {
    window.scrollTo({top: 0, behavior: 'smooth'});
});

window.addEventListener("turbolinks:load", function(event) {
    $('.modal').hide();
    $('.modal-backdrop').remove();
});