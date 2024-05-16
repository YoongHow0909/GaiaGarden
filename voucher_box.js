
function openModal(voucherName, plantPrice, imageUrl, voucherDescription) {
    // Get the modal element
    var modal = document.getElementById("myModal");

    // Get the elements that will display the plant details
    var modalVoucherName = modal.querySelector(".modal-voucher-name");
    var modalVoucherDiscount = modal.querySelector(".modal-voucher-discount");
    var modalVoucherImage = modal.querySelector(".modal-voucher-image");
    var modalVoucherDescription = modal.querySelector(".modal-voucher-description");

    var span = document.getElementsByClassName("close")[0];
    // Set the plant details in the modal
    modalVoucherName.textContent = voucherName;
    modalVoucherDiscount.textContent = "RM" + plantPrice;
    modalVoucherImage.src = imageUrl;
    modalVoucherDescription.textContent = voucherDescription;
    // Display the modal
    modal.style.display = "block";

    span.onclick = function() {
        modal.style.display = "none";
      }
      
      // When the user clicks anywhere outside of the modal, close it
      window.onclick = function(event) {
        if (event.target == modal) {
          modal.style.display = "none";
        }
      }
}

