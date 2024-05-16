
function openModal(plantName, plantPrice, imageUrl, plantDescription) {
    // Get the modal element
    var modal = document.getElementById("myModal");

    // Get the elements that will display the plant details
    var modalPlantName = modal.querySelector(".modal-plant-name");
    var modalPlantPrice = modal.querySelector(".modal-plant-price");
    var modalPlantImage = modal.querySelector(".modal-plant-image");
    var modalPlantDescription = modal.querySelector(".modal-plant-description");

    var span = document.getElementsByClassName("close")[0];
    // Set the plant details in the modal
    modalPlantName.textContent = plantName;
    modalPlantPrice.textContent = "RM" + plantPrice;
    modalPlantImage.src = imageUrl;
    modalPlantDescription.textContent = plantDescription;
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

