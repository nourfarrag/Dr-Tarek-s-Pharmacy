document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('addCustomerBtn').addEventListener('click', function() {
        var addCustomerForm = document.getElementById('addCustomerForm');
        if (addCustomerForm.style.display === 'none') {
            addCustomerForm.style.display = 'block';
        } else {
            addCustomerForm.style.display = 'none';
        }
    });

    // Function to handle form submission using AJAX
    document.querySelector('#addCustomerForm form').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent the form from submitting normally

        // Get form data
        var formData = new FormData(this);

        // Send form data to addcustomer.php using AJAX
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'addcustomer.php', true);
        xhr.onload = function() {
            if (xhr.status === 200) {
                // Process the response if needed
                // For example, you can update the table with the newly added customer data
                var newRow = document.createElement('tr');
                newRow.innerHTML = `
                    <td>${formData.get('name')}</td>
                    <td>${formData.get('address')}</td>
                    <td>${formData.get('contact')}</td>
                `;
                document.querySelector('#customerTable tbody').appendChild(newRow);
                // Reset the form and hide it
                document.querySelector('#addCustomerForm form').reset();
                document.getElementById('addCustomerForm').style.display = 'none';
            } else {
                // Handle errors if any
                console.error('Error occurred during form submission:', xhr.statusText);
            }
        };
        xhr.onerror = function() {
            console.error('Error occurred during form submission:', xhr.statusText);
        };
        xhr.send(formData);
    });
});

function editCustomer(button) {
    const row = button.parentNode.parentNode; // Get the row of the clicked button
    const cells = row.cells; // Get all cells in the row

    // Log customer ID and other input field values for debugging
    console.log("Customer ID:", row.cells[0].textContent);
    console.log("Full Name:", cells[1].textContent);
    console.log("Address:", cells[2].textContent);
    console.log("Contact:", cells[3].textContent);

    // Loop through each cell in the row, except the last one (action buttons)
    for (let i = 1; i < cells.length - 1; i++) { // Start from index 1 to exclude Customer ID
        const cell = cells[i];
        let input = document.createElement("input");
        input.type = "text";
        input.value = cell.textContent;
        cell.textContent = ""; // Clear the cell content
        cell.appendChild(input);
    }

    // Change the button text and onclick action to "Save"
    button.textContent = "Save";
    button.setAttribute("onclick", "saveCustomer(this)");
}

// Function to handle saving edited customer details
function saveCustomer(button) {
    const row = button.parentNode.parentNode; // Get the row of the clicked button
    const cells = row.cells; // Get all cells in the row
    const customerId = row.cells[0].textContent; // Assuming the first cell contains the customer ID

    // Log customer ID and other input field values for debugging
    console.log("Customer ID:", customerId);
    console.log("New Full Name:", cells[1].querySelector('input').value);
    console.log("New Address:", cells[2].querySelector('input').value);
    console.log("New Contact:", cells[3].querySelector('input').value);

    // Attempt to select input elements within cells
    const inputName = cells[1].querySelector('input');
    const inputAddress = cells[2].querySelector('input');
    const inputContact = cells[3].querySelector('input');

    // Check if any of the input elements are null
    if (!inputName || !inputAddress || !inputContact) {
        console.error('Failed to find input elements.');
        return;
    }

    // Prepare an object to store the updated data
    const updatedData = {
        CustomerId: customerId,
        new_name: inputName.value,
        new_address: inputAddress.value,
        new_contact: inputContact.value
    };

    console.log("Data sent to server:", JSON.stringify(updatedData)); // Log the data sent to the server

    // Send the updated data to the server via AJAX
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'updatecustomer.php', true);
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.onload = function() {
        if (xhr.status === 200) {
            if (xhr.responseText === 'success') {
                // Update the table row with the new data
                row.cells[1].textContent = inputName.value;
                row.cells[2].textContent = inputAddress.value;
                row.cells[3].textContent = inputContact.value;
                // Reset button text and onclick action
                button.textContent = 'Update';
                button.setAttribute('onclick', 'editCustomer(this)');
                alert('Customer data updated successfully.');
            } else {
                alert('Error updating customer ');
            }
        } else {
            alert('Error: ' + xhr.statusText);
        }
    };
    xhr.onerror = function() {
        alert('Request failed.');
    };
    xhr.send(JSON.stringify(updatedData));
}

function deleteCustomer(button) {
    const row = button.parentNode.parentNode;
    const customerId = row.cells[0].textContent; // Assuming the customer ID is in the first cell

    // Send AJAX request to deletecustomer.php
    const xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                // Customer deleted successfully, remove the row from the table
                row.remove();
                alert(xhr.responseText); // Show success message
            } else {
                // Error occurred, display error message
                alert('Error deleting customer: ' + xhr.responseText);
            }
        }
    };
    xhr.open('POST', 'deletecustomer.php');
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.send('CustomerId=' + encodeURIComponent(customerId)); // Include the customer ID in the request
}
