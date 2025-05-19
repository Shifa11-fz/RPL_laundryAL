function openModal() {
    document.getElementById("inputModal").style.display = "flex";
  }
  
  function closeModal() {
    document.getElementById("inputModal").style.display = "none";
  }
  
  // Tutup modal jika klik luar form
  window.onclick = function(event) {
    const modal = document.getElementById("inputModal");
    if (event.target === modal) {
      modal.style.display = "none";
    }
  }
  