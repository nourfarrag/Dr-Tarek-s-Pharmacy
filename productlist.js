function addProduct() {
    // Hide the add product form after adding a product
    document.getElementById("addProductForm").style.display = "none";

    // Extract input field values
    const name = document.getElementById("productName").value;
    const price = document.getElementById("productPrice").value;
    const quantity = document.getElementById("productQuantity").value;
    const expirydate = document.getElementById("Expirydate").value;

    // Reset input fields
    document.getElementById("productName").value = "";
    document.getElementById("productPrice").value = "";
    document.getElementById("productQuantity").value = "";
    document.getElementById("Expirydate").value = "";

    // Construct the new row HTML
    const newRow = `
        <tr>
            <td>${name}</td>
            <td>${price}</td>
            <td>${quantity}</td>
            <td>${expirydate}</td>
            <td>
                <button class="edit" onclick="editProduct(this)">Edit</button>
                <button class="delete" onclick="deleteProduct(this)">Delete</button>
            </td>
        </tr>
    `;

    // Insert the new row as the first child of tbody
    const tbody = document.getElementById("productTable");
    tbody.insertAdjacentHTML("afterbegin", newRow);
}



function showAddProductForm() {
    const addProductForm = document.getElementById("addProductForm");
    if (addProductForm.style.display === "none") {
        addProductForm.style.display = "block";
    } else {
        addProductForm.style.display = "none";
    }
}
function editProduct(button) {
    const row = button.parentNode.parentNode;
    const cells = row.cells;

    // Replace text content with input fields for editing
    for (let i = 0; i < cells.length - 1; i++) {
        const cell = cells[i];
        let input = document.createElement("input");
        input.type = "text";
        input.value = cell.textContent;
        cell.textContent = "";
        cell.appendChild(input);
        
    }
   

    // Change "Edit" button to "Save"
    button.textContent = "Save";
    button.setAttribute("onclick", "saveProduct(this)");

}

function saveProduct(button) {

    const row = button.parentNode.parentNode;
    const cells = row.cells;

   
    // Replace input fields with text content
    for (let i = 0; i < cells.length - 1; i++) {
        const cell = cells[i];
        const input = cell.querySelector("input");
        cell.textContent = input.value;
    }

    // Change "Save" button back to "Edit"
    
 //
    const productId = row.cells[0].textContent; // Assuming the product ID is in the first cell

    // Extract updated values from the table cells
    const name = cells[1].textContent;
    const price = cells[2].textContent;
    const quantity = cells[3].textContent;
    const expiry = cells[4].textContent;

    // Send AJAX request to update product
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "updateproduct.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                // Handle response if needed
                console.log("Product updated successfully");
            } else {
                // Handle error
                console.error("Error updating product:", xhr.statusText);
            }
        }
    };
    xhr.send("productId=" + encodeURIComponent(productId) + "&name=" + encodeURIComponent(name) + "&price=" + encodeURIComponent(price) + "&quantity=" + encodeURIComponent(quantity) + "&expiry=" + encodeURIComponent(expiry));
    button.textContent = "Edit";
    button.setAttribute("onclick", "editProduct(this)");
}
   
   


function deleteProduct(button) {
    const row = button.parentNode.parentNode;
    const productId = row.cells[0].textContent;
    row.remove();
     // Send AJAX request to deleteProduct.php
     const xhr = new XMLHttpRequest();
     xhr.onreadystatechange = function() {
         if (xhr.readyState === XMLHttpRequest.DONE) {
             if (xhr.status === 200) {
                 // Row deleted successfully, remove it from the table
                 row.remove();
                 alert(xhr.responseText); // Show success message
             } else {
                 // Error occurred, display error message
                 alert('Error deleting product: ' + xhr.responseText);
             }
         }
     };
     xhr.open('POST', 'deleteproduct.php');
     xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
     xhr.send('productId=' + encodeURIComponent(productId));
   
}






