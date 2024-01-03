const setModal = (id) => {
  var modal = document.getElementById('myModal'+id);
  var openBtn = document.getElementById('openModalBtn'+id);
  var closeBtn = document.getElementById('closeModalBtn'+id);

  openBtn.addEventListener('click', function() {
    modal.style.display = 'block';
  });

  closeBtn.addEventListener('click', function() {
    modal.style.display = 'none';
  });

  window.addEventListener('click', function(event) {
    if (event.target == modal) {
      modal.style.display = 'none';
    }
  });
}