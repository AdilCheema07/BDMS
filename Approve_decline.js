// This Script Handles the process of approving or declining requests and donations when Approve or Decline Buttons are pressed changing their status to approved or declined 

function approveDonation(donationId) {
    // Send an AJAX request to update the donation status to "approved"
    $.ajax({
        type: "POST",
        url: "update_donation_status.php", // Use the correct URL
        data: { donationId: donationId, status: "approved" },
        success: function (response) {
            if (response === "Success") {
                // Reload the page or update the table as needed
                location.reload(); // Reload the page for simplicity
            } else {
                alert("Error approving the donation: " + response);
            }
        },
        error: function () {
            alert("Error approving the donation.");
        }
    });
}

function declineDonation(donationId) {
    // Send an AJAX request to update the donation status to "declined"
    $.ajax({
        type: "POST",
        url: "update_donation_status.php", // Use the correct URL
        data: { donationId: donationId, status: "declined" },
        success: function (response) {
            if (response === "Success") {
                // Reload the page or update the table as needed
                location.reload(); // Reload the page for simplicity
            } else {
                alert("Error declining the donation: " + response);
            }
        },
        error: function () {
            alert("Error declining the donation.");
        }
    });
}


function approveRequest(requestId, bloodGroup, requestedQuantity) {
    // Send an AJAX request to check available blood quantity for the requested blood group
    $.ajax({
        type: "POST",
        url: "check_available_blood.php",
        data: { bloodGroup: bloodGroup },
        success: function (availableQuantity) {
            if (parseInt(availableQuantity) >= requestedQuantity) {
                // Available blood quantity is sufficient, proceed to update the request status
                $.ajax({
                    type: "POST",
                    url: "update_request_status.php",
                    data: { requestId: requestId, status: "approved" },
                    success: function (response) {
                        // Reload the page or update the table as needed
                        location.reload(); // Reload the page for simplicity
                    },
                    error: function () {
                        alert("Error approving the request.");
                    }
                });
            } else {
                // Not enough available blood
                alert("Not enough available blood");
            }
        },
        error: function () {
            alert("Error checking available blood quantity.");
        }
    });
}

function declineRequest(requestId) {
    // Send an AJAX request to update the status to "declined"
    $.ajax({
        type: "POST",
        url: "update_request_status.php",
        data: { requestId: requestId, status: "declined" },
        success: function (response) {
            // Reload the page or update the table as needed
            location.reload(); // Reload the page for simplicity
        },
        error: function () {
            alert("Error declining the request.");
        }
    });
}